
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_notification_logs', function (Blueprint $table) {
            $table->id();

            // Appointment linked to this email
            $table->foreignId('appointment_id')
                ->nullable()
                ->constrained('appointments')
                ->nullOnDelete();

            // Recipient details
            $table->string('recipient_email');
            $table->string('recipient_name')->nullable();

            // Email information
            $table->string('email_type', 50);
            $table->string('subject');

            // Processing status: queued, processing, sent, failed
            $table->string('status', 20)->default('queued');

            // Track attempts and errors
            $table->unsignedInteger('attempts')->default(0);
            $table->text('last_error')->nullable();

            // Queue and processing timestamps
            $table->timestamp('queued_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('failed_at')->nullable();

            $table->timestamps();

            // Indexes for admin dashboard filters
            $table->index(['status', 'created_at']);
            $table->index(['email_type', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_notification_logs');
    }
};
