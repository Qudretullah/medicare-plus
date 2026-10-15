<?php

namespace App\Services;

use App\Models\SystemBackup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Symfony\Component\Process\Process;

class DatabaseBackupService
{
    public function create(): SystemBackup
    {
        $connectionName = config('database.default');
        $database = config("database.connections.{$connectionName}");

        if (($database['driver'] ?? null) !== 'mysql') {
            throw new RuntimeException(
                'MySQL database connection is required.'
            );
        }

        $dumpExecutable = config(
            'medicare_backup.mysqldump_path'
        );

        if (!$dumpExecutable) {
            throw new RuntimeException(
                'MySQL dump executable is not configured.'
            );
        }

        $disk = Storage::disk('local');

        $directory = 'medicare-backups';

        $disk->makeDirectory($directory);

        $filename = 'medicare-db-'
            . now()->format('Ymd-His')
            . '-'
            . bin2hex(random_bytes(6))
            . '.sql';

        $relativePath = $directory . '/' . $filename;

        $absolutePath = $disk->path($relativePath);

        
        $command = [
            $dumpExecutable,
            '--protocol=TCP',
            '--host=127.0.0.1',
            '--port=' . ($database['port'] ?? '3306'),
            '--user=' . ($database['username'] ?? 'root'),
            '--default-character-set=utf8mb4',
            '--single-transaction',
            '--quick',
            '--skip-lock-tables',
            '--no-tablespaces',
            '--result-file=' . $absolutePath,
            $database['database'],
        ];

        
        // Build the MySQL dump command
        $command = [
            $dumpExecutable,
            '--no-defaults',
            '--protocol=TCP',
            '--host=127.0.0.1',
            '--port=' . ($database['port'] ?? '3306'),
            '--user=' . ($database['username'] ?? 'root'),
            '--default-character-set=utf8mb4',
            '--single-transaction',
            '--quick',
            '--skip-lock-tables',
            '--no-tablespaces',
            '--result-file=' . $absolutePath,
            $database['database'],
        ];

        // Create the process only once
        
        /*
        |--------------------------------------------------------------------------
        | Windows MySQL Process Environment Fix
        |--------------------------------------------------------------------------
        */

        $processEnvironment = [
            'SystemRoot' => getenv('SystemRoot') ?: 'C:\\Windows',
            'WINDIR' => getenv('WINDIR') ?: 'C:\\Windows',
            'PATH' => getenv('PATH') ?: '',
        ];

        // Keep the database password out of command arguments.
        $password = (string) ($database['password'] ?? '');

        if ($password !== '') {
            $processEnvironment['MYSQL_PWD'] = $password;
        }

        $process = new Process(
            $command,
            base_path(),
            $processEnvironment
        );

        $process->setTimeout(300);



        try {
            $process->run();

if (!$process->isSuccessful()) {

    $error = trim($process->getErrorOutput());

    // Do not write the database password to logs.
    // Store the diagnostic internally, not in the browser.
    \Illuminate\Support\Facades\Log::error(
        'Medicare database backup process failed.',
        [
            'exit_code' => $process->getExitCode(),
            'stderr' => $error,
        ]
    );

    throw new RuntimeException(
        'MySQL dump command failed.'
    );
}


            if (!$disk->exists($relativePath)) {
                throw new RuntimeException(
                    'Backup file was not created.'
                );
            }

            $fileSize = $disk->size($relativePath);

            if ($fileSize <= 0) {
                throw new RuntimeException(
                    'Backup file is empty.'
                );
            }

            $maxSize = (int) config(
                'medicare_backup.max_file_size',
                524288000
            );

            if ($fileSize > $maxSize) {
                throw new RuntimeException(
                    'Backup exceeded the configured size limit.'
                );
            }

            $checksum = hash_file(
                'sha256',
                $absolutePath
            );

            if ($checksum === false) {
                throw new RuntimeException(
                    'Backup checksum could not be generated.'
                );
            }

            return SystemBackup::create([
                'filename' => $filename,
                'disk' => 'local',
                'file_path' => $relativePath,
                'backup_type' => 'database',
                'file_size' => $fileSize,
                'checksum' => $checksum,
                'status' => 'completed',
                'created_by' => Auth::id(),
                'verified_at' => now(),
            ]);

        } catch (\Throwable $exception) {

            if ($disk->exists($relativePath)) {
                $disk->delete($relativePath);
            }

            throw $exception;
        }
    }
}
