<?php

namespace App\Http\Controllers;
use App\Support\ActivityLogger;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\EmailNotificationLog;
use App\Models\SiteSetting;
use App\Mail\AppointmentBookingMail;
use Carbon\Carbon;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | 1. CHECK ONLINE BOOKING STATUS
        |--------------------------------------------------------------------------
        */

        $bookingEnabled = SiteSetting::query()
            ->where('key', 'appointment_booking_enabled')
            ->value('value');

        // Default is enabled when no setting exists.
        if ($bookingEnabled === '0') {
            return back()
                ->withErrors([
                    'booking' => 'Online appointment booking is temporarily unavailable. Please contact the clinic for assistance.',
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | 2. VALIDATE PATIENT INFORMATION
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'patient_name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
            ],

            'phone' => [
                'required',
                'regex:/^03[0-9]{9}$/',
            ],

            'department' => [
                'required',
                'string',
                Rule::exists('departments', 'slug')
                    ->where('is_active', true),
            ],

            'doctor_name' => [
                'required',
                'string',
                Rule::exists('doctors', 'slug')
                    ->where('is_active', true),

                function ($attribute, $value, $fail) use ($request) {
                    $doctor = Doctor::query()
                        ->where('slug', $value)
                        ->where('is_active', true)
                        ->first();

                    if (!$doctor) {
                        return;
                    }

                    $doctorDepartment = Str::slug(
                        $doctor->department ?? ''
                    );

                    if (
                        $doctorDepartment !==
                        $request->input('department')
                    ) {
                        $fail(
                            'The selected doctor does not belong to the selected department.'
                        );
                    }
                },
            ],

            'appointment_date' => [
                'required',
                'date_format:Y-m-d',
            ],

            'appointment_time' => [
                'required',
                'date_format:H:i',
            ],

            'message' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | 3. VALIDATE DATE AND TIME
        |--------------------------------------------------------------------------
        */

        $bookingDateTime = Carbon::createFromFormat(
            '!Y-m-d H:i',
            $validated['appointment_date'] . ' ' .
            $validated['appointment_time'],
            'Asia/Karachi'
        );

        // Prevent past bookings.
        if (
            $bookingDateTime->lessThanOrEqualTo(
                Carbon::now('Asia/Karachi')
            )
        ) {
            return back()
                ->withErrors([
                    'appointment_time' =>
                        'Please select a future appointment date and time.',
                ])
                ->withInput();
        }

        // Clinic is closed on Sundays.
        if ($bookingDateTime->isSunday()) {
            return back()
                ->withErrors([
                    'appointment_date' =>
                        'Appointments are not available on Sundays.',
                ])
                ->withInput();
        }

        // Clinic hours: 09:00 AM – 05:00 PM.
        $bookingTime = $bookingDateTime->format('H:i');

        if (
            $bookingTime < '09:00' ||
            $bookingTime > '17:00'
        ) {
            return back()
                ->withErrors([
                    'appointment_time' =>
                        'Please select a time between 9:00 AM and 5:00 PM.',
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | 4. PREVENT DUPLICATE APPOINTMENT SLOTS
        |--------------------------------------------------------------------------
        */

        $slotAlreadyBooked = Appointment::where(
            'doctor_name',
            $validated['doctor_name']
        )
            ->where(
                'appointment_date',
                $validated['appointment_date']
            )
            ->where(
                'appointment_time',
                $validated['appointment_time']
            )
            ->whereIn('status', [
                'pending',
                'approved',
            ])
            ->exists();

        if ($slotAlreadyBooked) {
            return back()
                ->withErrors([
                    'appointment_time' =>
                        'This doctor already has an appointment at the selected date and time. Please choose another slot.',
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | 5. SAVE APPOINTMENT
        |--------------------------------------------------------------------------
        */

        try {
            $appointment = Appointment::create([
                ...$validated,
                'status' => 'pending',
            ]);
        } catch (UniqueConstraintViolationException $exception) {
            $errorMessage = $exception->errorInfo[2] ?? '';

            if (
                str_contains(
                    $errorMessage,
                    'appointments_unique_active_slot'
                )
            ) {
                return back()
                    ->withErrors([
                        'appointment_time' =>
                            'This appointment slot has just been booked. Please choose another date or time.',
                    ])
                    ->withInput();
            }

            throw $exception;
        }

        /*
        |--------------------------------------------------------------------------
        | 6. BOOKING CONFIRMATION EMAIL + TRACKING
        |--------------------------------------------------------------------------
        */

        $doctor = Doctor::where(
            'slug',
            $appointment->doctor_name
        )->first();

        $doctorName = $doctor
            ? $doctor->name
            : $appointment->doctor_name;

        $emailLog = null;

        try {
            $emailLog = EmailNotificationLog::create([
                'appointment_id' => $appointment->id,
                'recipient_email' => $appointment->email,
                'recipient_name' => $appointment->patient_name,
                'email_type' => 'booking',
                'subject' => 'Medicare+ | Appointment Request Received',
                'status' => 'queued',
                'attempts' => 0,
                'queued_at' => now(),
            ]);

            Mail::to($appointment->email)->queue(
                new AppointmentBookingMail(
                    $appointment,
                    $doctorName,
                    $emailLog->id
                )
            );
        } catch (\Throwable $exception) {
            if ($emailLog) {
                try {
                    $emailLog->update([
                        'status' => 'failed',
                        'last_error' => $exception->getMessage(),
                        'failed_at' => now(),
                    ]);
                } catch (\Throwable $logException) {
                    Log::error(
                        'Could not update booking email log.',
                        [
                            'appointment_id' => $appointment->id,
                            'error' => $logException->getMessage(),
                        ]
                    );
                }
            }

            Log::error(
                'Appointment booking email could not be queued.',
                [
                    'appointment_id' => $appointment->id,
                    'error' => $exception->getMessage(),
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 7. SUCCESS RESPONSE
        |--------------------------------------------------------------------------
        */

        return back()
            ->with(
                'success',
                'Your appointment request has been submitted successfully!'
            )
            ->with(
                'booking_reference',
                'MED-' . str_pad(
                    (string) $appointment->id,
                    6,
                    '0',
                    STR_PAD_LEFT
                )
            )
            ->with('booking_details', [
                'patient_name' => $appointment->patient_name,
                'department' => $appointment->department,
                'doctor_name' => $appointment->doctor_name,
                'appointment_date' =>
                    $appointment->appointment_date->format('d M Y'),
                'appointment_time' => Carbon::parse(
                    $appointment->appointment_time
                )->format('h:i A'),
                'status' => $appointment->status,
            ]);
    }
}
