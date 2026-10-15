
@extends('layouts.app')

@section('title', 'Book Appointment | Medicare+')

@section('content')

@php
    $departmentDoctors = $departmentDoctors ?? [];

    $currentDepartment = old(
        'department',
        $selectedDepartment ?? ''
    );

    $currentDoctor = old(
        'doctor_name',
        $selectedDoctor ?? ''
    );

    
    // Read the booking settings from the database.
    $bookingEnabled = \App\Models\SiteSetting::query()
        ->where('key', 'appointment_booking_enabled')
        ->value('value') !== '0';

    $appointmentNotice = \App\Models\SiteSetting::query()
        ->where('key', 'appointment_notice')
        ->value('value') ?? '';



@endphp

<section class="appointment-page-hero">
    <div class="container appointment-page-hero-wrapper">
        <div class="appointment-page-hero-content">

            <span class="section-label">
                Book Appointment
            </span>

            <h1>
                Schedule Your Visit
                <span>With Ease</span>
            </h1>

            <p>
                Choose your preferred department, doctor,
                date and time to book your appointment with Medicare+.
            </p>

        </div>
    </div>
</section>


<section class="appointment-booking-section">

    <div class="container appointment-booking-wrapper">

        {{-- LEFT SIDE INFORMATION --}}
        <div class="appointment-info-area">

            <span class="section-label">
                Easy Booking
            </span>

            <h2>Book Your Appointment</h2>

            <p>
                Fill in your details and select your preferred
                doctor and appointment time.
            </p>

            <div class="appointment-info-list">

                <div class="appointment-info-item">
                    <span>1</span>
                    <div>
                        <h3>Select Department</h3>
                        <p>Choose the medical department you need.</p>
                    </div>
                </div>

                <div class="appointment-info-item">
                    <span>2</span>
                    <div>
                        <h3>Choose Doctor</h3>
                        <p>Select your preferred medical specialist.</p>
                    </div>
                </div>

                <div class="appointment-info-item">
                    <span>3</span>
                    <div>
                        <h3>Select Date & Time</h3>
                        <p>Choose a convenient appointment schedule.</p>
                    </div>
                </div>

            </div>
        </div>


        {{-- RIGHT SIDE APPOINTMENT FORM --}}
        <div class="appointment-form-area">

            {{-- ===== APPOINTMENT SUCCESS CONFIRMATION ===== --}}

            @if (session('success'))

                    
                <div
                    class="appointment-success-alert appointment-slip-modal"
                    id="appointmentSuccessAlert"
                    role="dialog"
                    aria-modal="true"
                    aria-labelledby="bookingSuccessTitle"
>

                    
                <button
                   type="button"
                   class="appointment-modal-close"
                   id="appointmentModalClose"
                   aria-label="Close appointment slip"
                   title="Close"
            >
                     &times;
                           </button>


                    {{-- SUCCESS HEADER --}}
                    <div class="booking-success-header">

                        <span class="booking-success-icon">✓</span>

                        <div>
                           <h3 id="bookingSuccessTitle">Appointment Request Submitted!</h3>
                            <p>{{ session('success') }}</p>
                        </div>

                    </div>


                    {{-- BOOKING REFERENCE --}}
                    @if (session('booking_reference'))

                        <div class="booking-reference-box">

                            <span class="booking-reference-label">
                                YOUR BOOKING REFERENCE
                            </span>

                            <strong id="bookingReference">
                                {{ session('booking_reference') }}
                            </strong>

                            <span class="booking-pending-status">
                                Pending Approval
                            </span>

                            <button
                                type="button"
                                class="booking-copy-btn"
                                id="copyBookingReference"
                            >
                                Copy Reference
                            </button>

                        </div>

                    @endif


                    {{-- APPOINTMENT SUMMARY --}}
                    @if (session('booking_details'))

                        @php
                            $booking = session('booking_details');

                            $doctorNames = [];

                            foreach ($departmentDoctors as $items) {
                                foreach ($items as $item) {
                                    $doctorNames[$item['value']] = $item['name'];
                                }
                            }

                            $departmentNames = [
                                'cardiology' => 'Cardiology',
                                'neurology' => 'Neurology',
                                'pediatrics' => 'Pediatrics',
                                'orthopedics' => 'Orthopedics',
                                'dermatology' => 'Dermatology',
                                'general-medicine' => 'General Medicine',
                            ];
                        @endphp

                        <div class="booking-summary">

                            <h4>Appointment Summary</h4>

                            <div class="booking-summary-row">
                                <span>Patient Name</span>
                                <strong>
                                    {{ $booking['patient_name'] ?? '—' }}
                                </strong>
                            </div>

                            <div class="booking-summary-row">
                                <span>Department</span>
                                <strong>
                                    {{
                                        $departmentNames[$booking['department'] ?? '']
                                        ?? ucwords(str_replace('-', ' ', $booking['department'] ?? '—'))
                                    }}
                                </strong>
                            </div>

                            <div class="booking-summary-row">
                                <span>Doctor</span>
                                <strong>
                                    {{
                                        $doctorNames[$booking['doctor_name'] ?? '']
                                        ?? ($booking['doctor_name'] ?? '—')
                                    }}
                                </strong>
                            </div>

                            <div class="booking-summary-row">
                                <span>Appointment Date</span>
                                <strong>
                                    {{ $booking['appointment_date'] ?? '—' }}
                                </strong>
                            </div>

                            <div class="booking-summary-row">
                                <span>Appointment Time</span>
                                <strong>
                                    {{ $booking['appointment_time'] ?? '—' }}
                                </strong>
                            </div>

                            <div class="booking-summary-row">
                                <span>Status</span>

                                <span class="booking-summary-status">
                                    {{ ucfirst($booking['status'] ?? 'pending') }}
                                </span>
                            </div>

                        </div>

                    @endif


                    {{-- CONFIRMATION NOTE --}}
                    <p class="booking-success-note">
                        Please keep your booking reference for future
                        communication. Your appointment is awaiting confirmation.
                    </p>

                </div>

            @endif


            {{-- ===== APPOINTMENT FORM ===== --}}
            <form
                class="appointment-form"
                id="appointmentForm"
                action="{{ route('appointment.store') }}"
                method="POST"
            >

            
{{-- APPOINTMENT NOTICE --}}
@if(!empty($appointmentNotice))
    <div class="booking-system-notice" role="status">
        <strong>Clinic Notice</strong>
        <p>{{ $appointmentNotice }}</p>
    </div>
@endif

{{-- BOOKING AVAILABILITY --}}
@if(!$bookingEnabled)

    <div class="booking-unavailable-panel" role="status">
        <div class="booking-unavailable-icon" aria-hidden="true">
            ◷
        </div>

        <h2>Online Booking Temporarily Unavailable</h2>

        <p>
            We are currently not accepting online appointment
            requests. Please contact Medicare+ directly for
            assistance with your appointment.
        </p>

        <a href="{{ route('contact') }}"
           class="booking-unavailable-link">
            Contact Our Clinic →
        </a>
    </div>

@else


                @csrf

                <div class="appointment-form-grid">

                    {{-- PATIENT NAME --}}
                    <div class="appointment-form-group">

                        <label for="patientName">
                            Full Name
                        </label>

                        <input
                            type="text"
                            id="patientName"
                            name="patient_name"
                            value="{{ old('patient_name') }}"
                            placeholder="Enter your full name"
                            maxlength="255"
                            autocomplete="name"
                            required
                        >

                        @error('patient_name')
                            <small class="field-error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- EMAIL --}}
                    <div class="appointment-form-group">

                        <label for="patientEmail">
                            Email Address
                        </label>

                        <input
                            type="email"
                            id="patientEmail"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Enter your email"
                            maxlength="255"
                            autocomplete="email"
                            required
                        >

                        @error('email')
                            <small class="field-error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- PHONE --}}
                    <div class="appointment-form-group">

                        <label for="patientPhone">
                            Phone Number
                        </label>

                        <input
                            type="tel"
                            id="patientPhone"
                            name="phone"
                            value="{{ old('phone') }}"
                            placeholder="03XXXXXXXXX"
                            maxlength="11"
                            pattern="03[0-9]{9}"
                            autocomplete="tel"
                            title="Enter an 11-digit Pakistani mobile number starting with 03"
                            required
                        >

                        @error('phone')
                            <small class="field-error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- DEPARTMENT - DATABASE DRIVEN --}}
                    <div class="appointment-form-group">

                        <label for="department">
                            Department
                        </label>

                        <select
                            id="department"
                            name="department"
                            required
                        >

                            <option value="">
                                Select Department
                            </option>

                            @foreach ($departmentDoctors as $departmentSlug => $doctors)

                                <option
                                    value="{{ $departmentSlug }}"
                                    @selected($currentDepartment === $departmentSlug)
                                >
                                    {{ ucwords(str_replace('-', ' ', $departmentSlug)) }}
                                </option>

                            @endforeach

                        </select>

                        @error('department')
                            <small class="field-error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- DOCTOR - DATABASE DRIVEN --}}
                    <div class="appointment-form-group">

                        <label for="doctor">
                            Doctor
                        </label>

                        <select
                            id="doctor"
                            name="doctor_name"
                            data-selected="{{ $currentDoctor }}"
                            required
                        >

                            <option value="">
                                {{ $currentDepartment ? 'Select Doctor' : 'Select Department First' }}
                            </option>

                            @foreach ($departmentDoctors[$currentDepartment] ?? [] as $doctor)

                                <option
                                    value="{{ $doctor['value'] }}"
                                    @selected($currentDoctor === $doctor['value'])
                                >
                                    {{ $doctor['name'] }}
                                </option>

                            @endforeach

                        </select>

                        @error('doctor_name')
                            <small class="field-error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- APPOINTMENT DATE --}}
                    <div class="appointment-form-group">

                        <label for="appointmentDate">
                            Appointment Date
                        </label>

                        <input
                            type="date"
                            id="appointmentDate"
                            name="appointment_date"
                            value="{{ old('appointment_date') }}"
                            min="{{ now()->toDateString() }}"
                            required
                        >


                        {{-- PREMIUM ARCTIC CALENDAR --}}
                        <div
                            class="arctic-date-tools"
                            id="arcticDateTools"
                            hidden
                        >

                            <button
                                type="button"
                                class="arctic-calendar-trigger"
                                id="arcticCalendarTrigger"
                                aria-expanded="false"
                                aria-controls="arcticCalendarPopup"
                            >
                                <span aria-hidden="true">▦</span>
                                Open Modern Calendar
                            </button>

                            <div
                                class="arctic-calendar-popup"
                                id="arcticCalendarPopup"
                                hidden
                            >

                                <div class="arctic-calendar-toolbar">

                                    <button
                                        type="button"
                                        id="arcticCalendarPrev"
                                        aria-label="Previous month"
                                    >‹</button>

                                    <strong id="arcticCalendarMonth"></strong>

                                    <button
                                        type="button"
                                        id="arcticCalendarNext"
                                        aria-label="Next month"
                                    >›</button>

                                </div>

                                <div class="arctic-calendar-weekdays">
                                    <span>Mon</span>
                                    <span>Tue</span>
                                    <span>Wed</span>
                                    <span>Thu</span>
                                    <span>Fri</span>
                                    <span>Sat</span>
                                    <span>Sun</span>
                                </div>

                                <div
                                    class="arctic-calendar-days"
                                    id="arcticCalendarDays"
                                ></div>

                                <p class="arctic-calendar-hint">
                                    Select a future appointment date.
                                    Sundays are unavailable.
                                </p>

                            </div>

                        </div>

                        @error('appointment_date')
                            <small class="field-error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- APPOINTMENT TIME --}}
                    <div class="appointment-form-group">

                        <label for="appointmentTime">
                            Appointment Time
                        </label>

                        <input
                            type="time"
                            id="appointmentTime"
                            name="appointment_time"
                            value="{{ old('appointment_time') }}"
                            min="09:00"
                            max="17:00"
                            step="60"
                            required
                        >


                        {{-- PREMIUM ARCTIC TIME SLOTS --}}
                        <div
                            class="arctic-time-tools"
                            id="arcticTimeTools"
                            hidden
                        >

                            <div class="arctic-time-heading">
                                <span aria-hidden="true">◷</span>
                                Choose Your Preferred Time
                            </div>

                            <div
                                class="arctic-time-slots"
                                id="arcticTimeSlots"
                                role="group"
                                aria-label="Preferred appointment time"
                            ></div>

                            <p class="arctic-time-hint">
                                Clinic hours: 9:00 AM – 5:00 PM.
                                Selected time is subject to availability.
                            </p>

                        </div>

                        @error('appointment_time')
                            <small class="field-error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                </div>


                {{-- OPTIONAL MESSAGE --}}
                <div class="appointment-form-group">

                    <label for="appointmentMessage">
                        Message (Optional)
                    </label>

                    <textarea
                        id="appointmentMessage"
                        name="message"
                        rows="5"
                        maxlength="2000"
                        placeholder="Tell us anything important about your appointment"
                    >{{ old('message') }}</textarea>

                    @error('message')
                        <small class="field-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- SUBMIT BUTTON --}}
                <button
                    type="submit"
                    class="appointment-submit-btn"
                >
                    Book Appointment
                </button>

           
</form>

@endif

</div>


    </div>

</section>


{{-- ===== DYNAMIC DEPARTMENT & DOCTOR SELECTION ===== --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const departmentSelect = document.getElementById('department');
    const doctorSelect = document.getElementById('doctor');

    if (!departmentSelect || !doctorSelect) {
        return;
    }

    // Doctors data provided by Laravel
    const departmentDoctors = {{ \Illuminate\Support\Js::from($departmentDoctors) }};

    // Doctor selected through profile or previous form input
    const initiallySelectedDoctor = doctorSelect.dataset.selected || '';

    function populateDoctors(department, selectedDoctor = '') {

        doctorSelect.replaceChildren();

        const placeholder = document.createElement('option');
        placeholder.value = '';
        placeholder.textContent = department
            ? 'Select Doctor'
            : 'Select Department First';

        doctorSelect.appendChild(placeholder);

        const doctors = departmentDoctors[department] || [];

        doctors.forEach(function (doctor) {

            const option = document.createElement('option');

            option.value = doctor.value;
            option.textContent = doctor.name;

            if (doctor.value === selectedDoctor) {
                option.selected = true;
            }

            doctorSelect.appendChild(option);

        });

        doctorSelect.disabled = doctors.length === 0;

    }

    // Initial selection when appointment page opens
    populateDoctors(
        departmentSelect.value,
        initiallySelectedDoctor
    );

    // Update doctors automatically on department change
    departmentSelect.addEventListener('change', function () {

        populateDoctors(this.value);

        doctorSelect.dataset.selected = '';

    });

});
</script>
           
<script>
document.addEventListener('DOMContentLoaded', function () {

    const modal = document.getElementById('appointmentSuccessAlert');
    const copyButton = document.getElementById('copyBookingReference');
    const reference = document.getElementById('bookingReference');
    const closeButton = document.getElementById('appointmentModalClose');

    if (!modal) {
        return;
    }

    // Close the modal safely
    function closeModal() {
        if (modal.isConnected) {
            modal.remove();
        }
    }

    // Close button
    if (closeButton) {
        closeButton.addEventListener('click', closeModal);
        closeButton.focus();
    }

    // Escape key
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && modal.isConnected) {
            closeModal();
        }
    });

    if (!copyButton || !reference) {
        return;
    }

    // Copy appointment details
    copyButton.addEventListener('click', async function () {

        if (copyButton.disabled) {
            return;
        }

        const rows = Array.from(
            modal.querySelectorAll('.booking-summary-row')
        );

        const details = rows.map(function (row) {

            const label = row.querySelector('span');
            const value = row.querySelector(
                'strong, .booking-summary-status'
            );

            if (!label || !value) {
                return '';
            }

            return (
                label.textContent.trim() +
                ': ' +
                value.textContent.trim()
            );

        }).filter(Boolean);

        const slipText = [
            'MEDICARE+ APPOINTMENT SLIP',
            'Booking Reference: ' + reference.textContent.trim(),
            ...details,
            'Please wait for appointment approval.'
        ].join('\n');

        const originalText = copyButton.textContent;

        copyButton.disabled = true;

        try {

            await navigator.clipboard.writeText(slipText);

            // Show successful copy feedback
            copyButton.textContent = 'Copied Successfully';

            // Close modal after successful copy
            closeModal();

        } catch (error) {

            // Keep modal open if copying fails
            copyButton.textContent = 'Copy failed - Try again';

            copyButton.disabled = false;

        }

    });

});
</script>



@endsection
