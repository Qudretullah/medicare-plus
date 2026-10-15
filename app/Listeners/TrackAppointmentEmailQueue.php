<?php

namespace App\Listeners;

use App\Mail\AppointmentBookingMail;
use App\Mail\AppointmentStatusMail;
use App\Models\EmailNotificationLog;
use Illuminate\Mail\SendQueuedMailable;
use Illuminate\Queue\Events\JobExceptionOccurred;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\Facades\Log;
use Throwable;

class TrackAppointmentEmailQueue
{
    public function handle(
        JobProcessing|JobProcessed|JobExceptionOccurred|JobFailed $event
    ): void {
        try {
            Log::info('Medicare+ queue listener executed', [
    'event' => get_class($event),
    'job_id' => $event->job->getJobId(),
]);
            $payload = $event->job->payload();

            // Laravel stores queued object jobs as serialized commands.
            $command = $payload['data']['command'] ?? null;

            if (!is_string($command)) {
                return;
            }

            // Only use this with Laravel's trusted internal queue.
            $queuedJob = @unserialize($command, [
                'allowed_classes' => true,
            ]);

            Log::info('Medicare+ queued job identification', [
    'job_class' => is_object($queuedJob)
        ? get_class($queuedJob)
        : gettype($queuedJob),

    'mailable_class' => $queuedJob instanceof SendQueuedMailable
        ? get_class($queuedJob->mailable)
        : null,

    'email_log_id' => $queuedJob instanceof SendQueuedMailable
        ? ($queuedJob->mailable->emailLogId ?? null)
        : null,
]);

            // Ignore unrelated queue jobs.
            if (!$queuedJob instanceof SendQueuedMailable) {
                return;
            }

            $mailable = $queuedJob->mailable;

            // Only track Medicare+ appointment emails.
            if (
                !$mailable instanceof AppointmentBookingMail &&
                !$mailable instanceof AppointmentStatusMail
            ) {
                return;
            }

            $emailLogId = $mailable->emailLogId ?? null;

            if (!is_int($emailLogId) || $emailLogId <= 0) {
                return;
            }

            $emailLog = EmailNotificationLog::find($emailLogId);

            if (!$emailLog) {
                return;
            }

            // Worker starts an email attempt.
            if ($event instanceof JobProcessing) {
                $emailLog->update([
                    'status' => 'processing',
                    'attempts' => $event->job->attempts(),
                ]);

                return;
            }

            // Worker completed email sending successfully.
            if ($event instanceof JobProcessed) {
                $emailLog->update([
                    'status' => 'sent',
                    'sent_at' => now(),
                    'failed_at' => null,
                    'last_error' => null,
                ]);

                return;
            }

            // Temporary exception: record error while waiting for retry.
            if ($event instanceof JobExceptionOccurred) {
                $emailLog->update([
                    'status' => 'queued',
                    'last_error' => $event->exception->getMessage(),
                ]);

                return;
            }

            // Job exhausted retries or failed permanently.
            if ($event instanceof JobFailed) {
                $emailLog->update([
                    'status' => 'failed',
                    'failed_at' => now(),
                    'last_error' => $event->exception->getMessage(),
                ]);
            }

        } catch (Throwable $exception) {
            Log::error(
                'Medicare+ email queue tracking listener failed.',
                [
                    'error' => $exception->getMessage(),
                ]
            );
        }
    }
}
