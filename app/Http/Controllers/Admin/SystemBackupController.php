<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemBackup;
use App\Services\DatabaseBackupService;
use App\Support\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SystemBackupController extends Controller
{
    public function index(): View
    {
        $backups = SystemBackup::query()
            ->with('creator:id,name')
            ->latest('id')
            ->paginate(10);

        return view(
            'admin.system-backups.index',
            compact('backups')
        );
    }

    public function store(
        DatabaseBackupService $backupService
    ): RedirectResponse {
        try {
            $backup = $backupService->create();

            ActivityLogger::record(
                'database.backup_created',
                'Admin created database backup #' . $backup->id,
                SystemBackup::class,
                $backup->id
            );

            return back()->with(
                'success',
                'Database backup created successfully.'
            );

        } catch (\Throwable $exception) {

            report($exception);

            return back()->with(
                'error',
                'Backup failed. Check Laravel logs and MySQL configuration.'
            );
        }
    }

    public function download(
        SystemBackup $backup
    ): BinaryFileResponse {
        abort_unless(
            $backup->status === 'completed'
                && $backup->disk === 'local'
                && $backup->backup_type === 'database'
                && str_starts_with(
                    $backup->file_path,
                    'medicare-backups/'
                ),
            404
        );

        $disk = Storage::disk('local');

        abort_unless(
            $disk->exists($backup->file_path),
            404
        );

        $absolutePath = $disk->path(
            $backup->file_path
        );

        $currentChecksum = hash_file(
            'sha256',
            $absolutePath
        );

        abort_unless(
            $currentChecksum !== false
                && hash_equals(
                    (string) $backup->checksum,
                    $currentChecksum
                ),
            409,
            'Backup integrity verification failed.'
        );

        ActivityLogger::record(
            'database.backup_downloaded',
            'Admin downloaded database backup #' . $backup->id,
            SystemBackup::class,
            $backup->id
        );

        return response()->download(
            $absolutePath,
            $backup->filename,
            [
                'Cache-Control' => 'private, no-store',
                'X-Content-Type-Options' => 'nosniff',
            ]
        );
    }
}
