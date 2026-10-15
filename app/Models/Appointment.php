<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'patient_name',
        'email',
        'phone',
        'department',
        'doctor_name',
        'appointment_date',
        'appointment_time',
        'message',
        'status',
    ];

    protected $casts = [
        'appointment_date' => 'date',
    ];
}
