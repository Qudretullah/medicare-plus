
@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard Overview')

@section('page-description', 'Monitor appointments, clinic services and website inquiries.')

@section('content')

<div class="medicare-dashboard">

    {{-- APPOINTMENT STATISTICS --}}

    <div class="md-section-heading">
        <div>
            <span class="md-eyebrow">CLINIC PERFORMANCE</span>
            <h2>Appointment Overview</h2>
            <p>Track patient bookings and their current status.</p>
        </div>

        <a href="{{ route('admin.appointments.index') }}"
           class="md-action-link">
            Manage Appointments →
        </a>
    </div>

    <div class="admin-stats-grid md-appointment-grid">

        <div class="admin-stat-card">
            <div class="stat-top">
                <span>Total Appointments</span>
                <span class="stat-symbol">▦</span>
            </div>

            <h2>{{ number_format($totalAppointments) }}</h2>
            <p>All appointment requests</p>
        </div>

        <div class="admin-stat-card">
            <div class="stat-top">
                <span>Pending Appointments</span>
                <span class="stat-symbol">◷</span>
            </div>

            <h2>{{ number_format($pendingAppointments) }}</h2>
            <p>Awaiting confirmation</p>
        </div>

        <div class="admin-stat-card">
            <div class="stat-top">
                <span>Approved Appointments</span>
                <span class="stat-symbol">✓</span>
            </div>

            <h2>{{ number_format($approvedAppointments) }}</h2>
            <p>Confirmed bookings</p>
        </div>

        <div class="admin-stat-card">
            <div class="stat-top">
                <span>Completed Appointments</span>
                <span class="stat-symbol">✦</span>
            </div>

            <h2>{{ number_format($completedAppointments) }}</h2>
            <p>Finished consultations</p>
        </div>

        <div class="admin-stat-card">
            <div class="stat-top">
                <span>Rejected Appointments</span>
                <span class="stat-symbol">×</span>
            </div>

            <h2>{{ number_format($rejectedAppointments) }}</h2>
            <p>Declined booking requests</p>
        </div>

    </div>


    {{-- CLINIC MANAGEMENT STATISTICS --}}

    <div class="md-section-heading">
        <div>
            <span class="md-eyebrow">MANAGEMENT SUMMARY</span>
            <h2>Clinic & Website Overview</h2>
            <p>Important information across Medicare+.</p>
        </div>
    </div>

    <div class="admin-stats-grid">

        <a href="{{ route('admin.doctors.index') }}"
           class="admin-stat-card md-clickable-card">

            <div class="stat-top">
                <span>Total Doctors</span>
                <span class="stat-symbol">♙</span>
            </div>

            <h2>{{ number_format($totalDoctors) }}</h2>
            <p>View doctors management →</p>
        </a>

        <a href="{{ route('admin.departments.index') }}"
           class="admin-stat-card md-clickable-card">

            <div class="stat-top">
                <span>Total Departments</span>
                <span class="stat-symbol">▧</span>
            </div>

            <h2>{{ number_format($totalDepartments) }}</h2>
            <p>View departments →</p>
        </a>

        <a href="{{ route('admin.services.index') }}"
           class="admin-stat-card md-clickable-card">

            <div class="stat-top">
                <span>Total Services</span>
                <span class="stat-symbol">✦</span>
            </div>

            <h2>{{ number_format($totalServices) }}</h2>
            <p>Manage clinic services →</p>
        </a>

        <a href="{{ route('admin.contact-messages.index') }}"
           class="admin-stat-card md-clickable-card">

            <div class="stat-top">
                <span>New Contact Messages</span>
                <span class="stat-symbol">✉</span>
            </div>

            <h2>{{ number_format($newContactMessages) }}</h2>

            <p>
                {{ number_format($totalContactMessages) }}
                total messages · Open inbox →
            </p>
        </a>

    </div>


    {{-- QUICK ACCESS --}}

    <div class="md-quick-panel">

        <div class="md-quick-copy">
            <span class="md-eyebrow">QUICK ACCESS</span>
            <h2>Manage Medicare+</h2>
            <p>Access the most frequently used admin tools.</p>
        </div>

        <div class="md-quick-actions">

            <a href="{{ route('admin.appointments.index') }}">
                Appointments ↗
            </a>

            <a href="{{ route('admin.doctors.index') }}">
                Doctors ↗
            </a>

            <a href="{{ route('admin.website-content.index') }}">
                Page Editor ↗
            </a>

            <a href="{{ route('admin.contact-messages.index') }}">
                Contact Inbox ↗
            </a>

        </div>

    </div>


    {{-- RECENT APPOINTMENTS --}}

    <div class="admin-table-card md-recent-card">

        <div class="admin-card-heading md-table-heading">

            <div>
                <span class="md-eyebrow">PATIENT BOOKINGS</span>
                <h2>Recent Appointments</h2>
                <p>Latest five patient booking requests.</p>
            </div>

            <a href="{{ route('admin.appointments.index') }}"
               class="md-action-link">
                View All Appointments →
            </a>

        </div>

        <div class="admin-table-scroll">

            <table class="admin-table">

                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Department</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($recentAppointments as $appointment)

                        <tr>

                           
<td>
    <div class="md-patient-info">

        <strong>
            {{ $appointment->patient_name }}
        </strong>

        <span class="md-received-time">
            <span aria-hidden="true">◷</span>
            Received:
            {{ $appointment->created_at
                ?->timezone('Asia/Karachi')
                ->format('d M Y, h:i A') ?? '—' }}
        </span>

    </div>
</td>
                            <td>
                                {{
                                    $doctorNames->get($appointment->doctor_name)
                                    ?? ucwords(str_replace(
                                        '-',
                                        ' ',
                                        $appointment->doctor_name ?? 'Not assigned'
                                    ))
                                }}
                            </td>

                            <td>
                                {{
                                    ucwords(str_replace(
                                        '-',
                                        ' ',
                                        $appointment->department ?? 'Not specified'
                                    ))
                                }}
                            </td>

                            <td>
                                {{
                                    $appointment->appointment_date
                                        ?->format('d M Y') ?? '—'
                                }}
                            </td>

                            <td>
                                {{
                                    $appointment->appointment_time
                                        ? \Carbon\Carbon::parse(
                                            $appointment->appointment_time
                                          )->format('h:i A')
                                        : '—'
                                }}
                            </td>

                            <td>
                                <span class="admin-status status-{{ $appointment->status }}">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </td>

                            <td>
                                <a href="{{ route('admin.appointments.show', $appointment) }}"
                                   class="md-table-action">
                                    View Details →
                                </a>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="admin-empty">
                                No appointments found yet.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
