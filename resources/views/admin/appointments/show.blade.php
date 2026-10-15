
@extends('admin.layouts.app')

@section('title', 'Appointment Details')

@section('page-title', 'Appointment Details')

@section('page-description', 'Review patient information and manage appointment status.')

@push('styles')
<style>
/* ===== MEDICARE+ APPOINTMENT DETAILS ===== */

.medicare-detail-page {
    width: 100%;
    min-width: 0;
}

.medicare-detail-page * {
    box-sizing: border-box;
}

.medicare-detail-topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 25px;
}

.medicare-detail-topbar h2 {
    margin: 0 0 8px;
    color: #284d69;
    font-size: 22px;
    font-weight: 600;
}

.medicare-detail-topbar p {
    margin: 0;
    color: #7a92a3;
    font-size: 13px;
    line-height: 1.7;
}

.medicare-detail-back {
    display: inline-flex;
    align-items: center;
    padding: 12px 18px;
    border: 1px solid #dcebf3;
    border-radius: 10px;
    background: #ffffff;
    color: #397fa9;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
}

.medicare-detail-back:hover {
    background: #e7f3fa;
}

.medicare-detail-card {
    background: #ffffff;
    border: 1px solid #dcebf3;
    border-radius: 18px;
    padding: 28px;
    margin-bottom: 22px;
    box-shadow: 0 12px 35px rgba(85, 153, 195, 0.07);
}

.medicare-detail-card-heading {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 14px;
    flex-wrap: wrap;
    margin-bottom: 25px;
}

.medicare-detail-card-heading h3 {
    margin: 0;
    color: #284d69;
    font-size: 19px;
    font-weight: 600;
}

.medicare-detail-reference {
    padding: 9px 14px;
    border-radius: 9px;
    background: #e7f3fa;
    color: #397fa9;
    font-size: 13px;
    font-weight: 700;
}

.medicare-detail-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 22px;
}

.medicare-detail-item {
    min-width: 0;
    padding-bottom: 15px;
    border-bottom: 1px solid #edf3f7;
}

.medicare-detail-label {
    display: block;
    margin-bottom: 8px;
    color: #7a92a3;
    font-size: 12px;
    font-weight: 600;
}

.medicare-detail-value {
    display: block;
    color: #284d69;
    font-size: 14px;
    font-weight: 600;
    overflow-wrap: anywhere;
}

.medicare-detail-value a {
    color: #397fa9;
    text-decoration: none;
}

.medicare-detail-status {
    display: inline-flex;
    padding: 9px 14px;
    border-radius: 30px;
    font-size: 12px;
    font-weight: 700;
}

.medicare-detail-status.pending {
    background: #fff6df;
    color: #ae801e;
}

.medicare-detail-status.approved {
    background: #e7f7f0;
    color: #21866b;
}

.medicare-detail-status.rejected {
    background: #fff0f1;
    color: #bd5260;
}

.medicare-detail-status.completed {
    background: #e7f3fa;
    color: #397fa9;
}

.medicare-detail-message {
    padding: 18px;
    border-radius: 12px;
    background: #f3fafd;
    color: #526e82;
    font-size: 14px;
    line-height: 1.8;
    white-space: pre-wrap;
    overflow-wrap: anywhere;
}

.medicare-detail-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 22px;
}

.medicare-detail-actions form {
    margin: 0;
}

.medicare-detail-btn {
    border: none;
    padding: 13px 21px;
    border-radius: 10px;
    color: #ffffff;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.medicare-detail-btn:hover {
    transform: translateY(-2px);
}

.medicare-detail-btn:focus-visible {
    outline: 3px solid #96c6e0;
    outline-offset: 3px;
}

.medicare-detail-btn.approve {
    background: #21866b;
}

.medicare-detail-btn.reject {
    background: #bd5260;
}

.medicare-detail-btn.complete {
    background: #397fa9;
}

.medicare-detail-note {
    margin: 18px 0 0;
    color: #7a92a3;
    font-size: 13px;
    line-height: 1.8;
}

.medicare-detail-warning {
    margin-bottom: 20px;
    padding: 15px 18px;
    border-radius: 10px;
    background: #fff6df;
    color: #ae801e;
    font-size: 13px;
    line-height: 1.7;
}

@media (max-width: 768px) {
    .medicare-detail-card {
        padding: 20px;
    }

    .medicare-detail-grid {
        grid-template-columns: 1fr;
        gap: 17px;
    }

    .medicare-detail-actions {
        flex-direction: column;
    }

    .medicare-detail-actions form,
    .medicare-detail-btn {
        width: 100%;
    }
}
</style>
@endpush


@section('content')

@php
    $bookingReference = 'MED-' . str_pad(
        (string) $appointment->id,
        6,
        '0',
        STR_PAD_LEFT
    );

    $departmentName = ucwords(
        str_replace('-', ' ', $appointment->department ?? '')
    );

    $doctorName = \App\Models\Doctor::query()
        ->where('slug', $appointment->doctor_name)
        ->value('name') ?? ucwords(
            str_replace('-', ' ', $appointment->doctor_name ?? '')
        );

    $status = $appointment->status ?? 'pending';
@endphp


<div class="medicare-detail-page">

    {{-- TOP BAR --}}
    <div class="medicare-detail-topbar">

        <div>
            <h2>Patient Booking Information</h2>
            <p>
                View appointment details and manage the booking.
            </p>
        </div>

        <a
            href="{{ route('admin.appointments.index') }}"
            class="medicare-detail-back"
        >
            ← Back to Appointments
        </a>

    </div>


    {{-- WARNING NOTIFICATION --}}
    @if (session('warning'))
        <div class="medicare-detail-warning" role="alert">
            {{ session('warning') }}
        </div>
    @endif


    {{-- BOOKING INFORMATION --}}
    <section class="medicare-detail-card">

        <div class="medicare-detail-card-heading">
            <h3>Booking Information</h3>

            <span class="medicare-detail-reference">
                {{ $bookingReference }}
            </span>
        </div>

        <div class="medicare-detail-grid">

            <div class="medicare-detail-item">
                <span class="medicare-detail-label">
                    Patient Name
                </span>
                <span class="medicare-detail-value">
                    {{ $appointment->patient_name }}
                </span>
            </div>

            <div class="medicare-detail-item">
                <span class="medicare-detail-label">
                    Email Address
                </span>
                <span class="medicare-detail-value">
                    <a href="mailto:{{ $appointment->email }}">
                        {{ $appointment->email }}
                    </a>
                </span>
            </div>

            <div class="medicare-detail-item">
                <span class="medicare-detail-label">
                    Phone Number
                </span>
                <span class="medicare-detail-value">
                    {{ $appointment->phone }}
                </span>
            </div>

            <div class="medicare-detail-item">
                <span class="medicare-detail-label">
                    Department
                </span>
                <span class="medicare-detail-value">
                    {{ $departmentName }}
                </span>
            </div>

            <div class="medicare-detail-item">
                <span class="medicare-detail-label">
                    Doctor
                </span>
                <span class="medicare-detail-value">
                    {{ $doctorName }}
                </span>
            </div>

            <div class="medicare-detail-item">
                <span class="medicare-detail-label">
                    Appointment Date
                </span>
                <span class="medicare-detail-value">
                    {{ $appointment->appointment_date?->format('d M Y') }}
                </span>
            </div>

            <div class="medicare-detail-item">
                <span class="medicare-detail-label">
                    Appointment Time
                </span>
                <span class="medicare-detail-value">
                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                </span>
            </div>

            <div class="medicare-detail-item">
                <span class="medicare-detail-label">
                    Current Status
                </span>
                <span class="medicare-detail-value">
                    <span class="medicare-detail-status {{ $status }}">
                        {{ ucfirst($status) }}
                    </span>
                </span>
            </div>

        </div>

    </section>


    {{-- PATIENT MESSAGE --}}
    <section class="medicare-detail-card">

        <div class="medicare-detail-card-heading">
            <h3>Patient Message</h3>
        </div>

        <div class="medicare-detail-message">
            {{ $appointment->message ?: 'No additional message provided.' }}
        </div>

    </section>


    {{-- STATUS MANAGEMENT --}}
    <section class="medicare-detail-card">

        <div class="medicare-detail-card-heading">
            <h3>Manage Appointment</h3>

            <span class="medicare-detail-status {{ $status }}">
                {{ ucfirst($status) }}
            </span>
        </div>

        <div class="medicare-detail-actions">

            @if ($status === 'pending')

                {{-- APPROVE --}}
                <form
                    action="{{ route('admin.appointments.update-status', $appointment) }}"
                    method="POST"
                    onsubmit="return confirm('Approve this appointment and send the patient a notification?');"
                >
                    @csrf
                    @method('PATCH')

                    <input type="hidden" name="status" value="approved">

                    <button type="submit" class="medicare-detail-btn approve">
                        ✓ Approve Appointment
                    </button>
                </form>

                {{-- REJECT --}}
                <form
                    action="{{ route('admin.appointments.update-status', $appointment) }}"
                    method="POST"
                    onsubmit="return confirm('Reject this appointment and notify the patient?');"
                >
                    @csrf
                    @method('PATCH')

                    <input type="hidden" name="status" value="rejected">

                    <button type="submit" class="medicare-detail-btn reject">
                        ✕ Reject Appointment
                    </button>
                </form>

            @elseif ($status === 'approved')

                {{-- COMPLETE --}}
                <form
                    action="{{ route('admin.appointments.update-status', $appointment) }}"
                    method="POST"
                    onsubmit="return confirm('Mark this appointment as completed?');"
                >
                    @csrf
                    @method('PATCH')

                    <input type="hidden" name="status" value="completed">

                    <button type="submit" class="medicare-detail-btn complete">
                        ✓ Mark as Completed
                    </button>
                </form>

                {{-- REJECT APPROVED APPOINTMENT --}}
                <form
                    action="{{ route('admin.appointments.update-status', $appointment) }}"
                    method="POST"
                    onsubmit="return confirm('Reject this approved appointment and notify the patient?');"
                >
                    @csrf
                    @method('PATCH')

                    <input type="hidden" name="status" value="rejected">

                    <button type="submit" class="medicare-detail-btn reject">
                        ✕ Reject Appointment
                    </button>
                </form>

            @else

                <p class="medicare-detail-note">
                    This appointment is {{ $status }}.
                    No further status changes are available.
                </p>

            @endif

        </div>

        @if (in_array($status, ['pending', 'approved'], true))
            <p class="medicare-detail-note">
                Approving or rejecting an appointment will queue
                a notification email for the patient.
            </p>
        @endif

    </section>

</div>

@endsection
