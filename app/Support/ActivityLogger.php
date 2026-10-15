<?php

namespace App\Support;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ActivityLogger
{
    public static function record(
        string $action,
        string $description,
        ?string $subjectType = null,
        ?int $subjectId = null
    ): void {
        try {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'description' => $description,
                'subject_type' => $subjectType,
                'subject_id' => $subjectId,
                'ip_address' => request()->ip(),
            ]);
        } catch (\Throwable $exception) {
            Log::warning('Activity logging failed.', [
                'action' => $action,
                'error' => $exception->getMessage(),
            ]);
        }
    }
}
