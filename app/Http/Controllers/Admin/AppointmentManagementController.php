<?php

namespace App\Http\Controllers\Admin;
use App\Support\ActivityLogger;
use App\Http\Controllers\Controller;
use App\Mail\AppointmentStatusMail;
use App\Models\Appointment;
use App\Models\EmailNotificationLog;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Throwable;

class AppointmentManagementController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | 1. Appointment Listing
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => [
                'nullable',
                'string',
                'max:100',
            ],

            'status' => [
                'nullable',
                Rule::in([
                    'pending',
                    'approved',
                    'rejected',
                    'completed',
                ]),
            ],
        ]);

        $appointments = Appointment::query()
            ->when(
                $validated['search'] ?? null,
                function ($query, $search) {
                    $query->where(function ($q) use ($search) {
                        $q->where(
                            'patient_name',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'email',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'phone',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'doctor_name',
                            'like',
                            "%{$search}%"
                        );
                    });
                }
            )
            ->when(
                $validated['status'] ?? null,
                fn ($query, $status) =>
                    $query->where('status', $status)
            )
            ->latest()
            ->paginate(10)
            ->withQueryString();

            $doctorNames = \App\Models\Doctor::query()
    ->pluck('name', 'slug')
    ->all();

        return view('admin.appointments.index', compact('appointments', 'doctorNames'));
    }


    /*
    |--------------------------------------------------------------------------
    | 2. Appointment Details
    |--------------------------------------------------------------------------
    */

    public function show(Appointment $appointment)
    {
        return view(
            'admin.appointments.show',
            compact('appointment')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | 3. Update Appointment Status
    |--------------------------------------------------------------------------
    */

    public function updateStatus(
        Request $request,
        Appointment $appointment
    ) {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    'approved',
                    'rejected',
                    'completed',
                ]),
            ],
        ]);

        $newStatus = $validated['status'];

        /*
        | Allowed appointment transitions
        */

        $allowedTransitions = [
            'pending' => [
                'approved',
                'rejected',
            ],

            'approved' => [
                'completed',
                'rejected',
            ],

            'rejected' => [],

            'completed' => [],
        ];

        /*
        | Prevent invalid status changes
        */

        if (!in_array(
            $newStatus,
            $allowedTransitions[$appointment->status] ?? [],
            true
        )) {
            return back()->with(
                'error',
                'This appointment status cannot be changed in that way.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | 4. Save Appointment Status
        |--------------------------------------------------------------------------
        */

        $appointment->status = $newStatus;
        $appointment->save();

        
$appointment->status = $newStatus;
$appointment->save();

// Record successful appointment status change
ActivityLogger::record(
    'appointment.' . $newStatus,
    'Admin changed appointment #' . $appointment->id
        . ' status to ' . ucfirst($newStatus) . '.',
    Appointment::class,
    $appointment->id
);
  


        /*
        |--------------------------------------------------------------------------
        | 5. Send Approval / Rejection Email
        |--------------------------------------------------------------------------
        */

        if (in_array(
            $newStatus,
            ['approved', 'rejected'],
            true
        )) {

            /*
            | Get doctor's readable name from database
            */

            $doctor = Doctor::query()
                ->where(
                    'slug',
                    $appointment->doctor_name
                )
                ->first();

            $doctorName = $doctor
                ? $doctor->name
                : $appointment->doctor_name;

            
            /*
            |--------------------------------------------------------------------------
            | Send Patient Notification With Email Tracking
            |--------------------------------------------------------------------------
            */

            $emailLog = null;

            try {

                // Create email tracking record
                $emailLog = EmailNotificationLog::create([
                    'appointment_id' => $appointment->id,
                    'recipient_email' => $appointment->email,
                    'recipient_name' => $appointment->patient_name,
                    'email_type' => $newStatus,
                    'subject' => $newStatus === 'approved'
                        ? 'Your Medicare+ Appointment Is Confirmed'
                        : 'Update Regarding Your Medicare+ Appointment',
                    'status' => 'queued',
                    'attempts' => 0,
                    'queued_at' => now(),
                ]);

                // Add email to the database queue
                Mail::to($appointment->email)->queue(
                    new AppointmentStatusMail(
                        $appointment,
                        $doctorName,
                        $emailLog->id
                    )
                );

            } catch (Throwable $exception) {

                // Update tracking record if queue dispatch fails
                if ($emailLog) {
                    try {
                        $emailLog->update([
                            'status' => 'failed',
                            'last_error' => $exception->getMessage(),
                            'failed_at' => now(),
                        ]);
                    } catch (Throwable $logException) {
                        Log::error(
                            'Medicare+ email log update failed.',
                            [
                                'appointment_id' => $appointment->id,
                                'error' => $logException->getMessage(),
                            ]
                        );
                    }
                }

                Log::error(
                    'Medicare+ appointment email could not be queued.',
                    [
                        'appointment_id' => $appointment->id,
                        'status' => $newStatus,
                        'error' => $exception->getMessage(),
                    ]
                );

                return back()->with(
                    'warning',
                    'Appointment status updated, but the notification could not be queued. Please check the email logs.'
                );
            }   
        }

        /*
        |--------------------------------------------------------------------------
        | 6. Success Response
        |--------------------------------------------------------------------------
        */

             $message = match ($newStatus) {

            'approved' =>
                'Appointment approved and patient notification processed successfully.',

            'rejected' =>
                'Appointment rejected and patient notification processed successfully.',

            'completed' =>
                'Appointment marked as completed successfully.',

            default =>
                'Appointment status updated successfully.',
        };

        return back()->with(
            'success',
            $message
        );
    }
    
}