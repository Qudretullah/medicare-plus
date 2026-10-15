<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmailNotificationLog extends Model
{
    protected $fillable = [
        'appointment_id',
        'recipient_email',
        'recipient_name',
        'email_type',
        'subject',
        'status',
        'attempts',
        'last_error',
        'queued_at',
        'sent_at',
        'failed_at',
    ];

    protected $casts = [
        'appointment_id' => 'integer',
        'attempts' => 'integer',
        'queued_at' => 'datetime',
        'sent_at' => 'datetime',
        'failed_at' => 'datetime',
    ];

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
}
