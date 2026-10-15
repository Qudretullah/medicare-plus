
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_backups', function (Blueprint $table) {
            $table->id();

            $table->string('filename');
            $table->string('disk')->default('local');
            $table->string('file_path');

            $table->string('backup_type', 30)->default('database');

            $table->unsignedBigInteger('file_size')->nullable();

            $table->string('checksum', 64)->nullable();

            $table->string('status', 30)->default('pending');

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('verified_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_backups');
    }
};
