
@extends('admin.layouts.app')

@section('title', 'Appointment Management')

@section('page-title', 'Appointment Management')

@section('page-description', 'Review, search and manage patient appointment requests.')

@push('styles')
<style>
/* ==========================================
   MEDICARE+ APPOINTMENT MANAGEMENT
   ADMIN DASHBOARD INTEGRATION
========================================== */

.medicare-appointments {
    width: 100%;
    min-width: 0;
}

.medicare-appointments * {
    box-sizing: border-box;
}

/* Top section */
.medicare-appointments .appointments-topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 24px;
}

.medicare-appointments .appointments-intro h2 {
    margin: 0 0 7px;
    color: #284d69;
    font-size: 21px;
    font-weight: 600;
}

.medicare-appointments .appointments-intro p {
    margin: 0;
    color: #7a92a3;
    font-size: 13px;
    line-height: 1.7;
}

.medicare-appointments .dashboard-back-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 11px 17px;
    border: 1px solid #dcebf3;
    border-radius: 10px;
    background: #ffffff;
    color: #397fa9;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: background 0.2s ease;
}

.medicare-appointments .dashboard-back-link:hover {
    background: #e7f3fa;
}

/* Main card */
.medicare-appointments .appointments-card {
    background: #ffffff;
    border: 1px solid #dcebf3;
    border-radius: 18px;
    padding: 24px;
    box-shadow: 0 12px 35px rgba(85,153,195,0.07);
}

/* Filters */
.medicare-appointments .appointment-filters {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 12px;
    margin-bottom: 25px;
}

.medicare-appointments .appointment-filters input,
.medicare-appointments .appointment-filters select {
    min-height: 45px;
    padding: 11px 14px;
    border: 1px solid #dcebf3;
    border-radius: 10px;
    background: #ffffff;
    color: #476c89;
    font-family: inherit;
    font-size: 13px;
    outline: none;
}

.medicare-appointments .appointment-filters input {
    flex: 1;
    min-width: 200px;
}

.medicare-appointments .appointment-filters select {
    min-width: 150px;
}

.medicare-appointments .appointment-filters input:focus,
.medicare-appointments .appointment-filters select:focus {
    border-color: #5599c3;
    box-shadow: 0 0 0 3px rgba(85,153,195,0.1);
}

.medicare-appointments .filter-btn {
    min-height: 45px;
    padding: 11px 22px;
    border: none;
    border-radius: 10px;
    background: #397fa9;
    color: #ffffff;
    font-family: inherit;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
}

.medicare-appointments .filter-btn:hover {
    background: #28688f;
}

.medicare-appointments .reset-filter {
    display: inline-flex;
    align-items: center;
    min-height: 45px;
    padding: 11px 14px;
    color: #64748b;
    font-size: 13px;
    text-decoration: none;
}

/* Table */
.medicare-appointments .table-scroll {
    width: 100%;
    overflow-x: auto;
}

.medicare-appointments .appointments-table {
    width: 100%;
    min-width: 850px;
    border-collapse: collapse;
    text-align: left;
}

.medicare-appointments .appointments-table thead th {
    padding: 16px;
    background: #f3fafd;
    color: #476c89;
    font-size: 12px;
    font-weight: 700;
    white-space: nowrap;
}

.medicare-appointments .appointments-table tbody td {
    padding: 17px 16px;
    border-bottom: 1px solid #edf3f7;
    color: #526e82;
    font-size: 13px;
    vertical-align: middle;
}

.medicare-appointments .appointments-table tbody tr:hover td {
    background: #fbfdff;
}

.medicare-appointments .patient-name {
    display: block;
    margin-bottom: 5px;
    color: #284d69;
    font-weight: 700;
}

.medicare-appointments .patient-email {
    display: block;
    color: #7a92a3;
    font-size: 12px;
    overflow-wrap: anywhere;
}

/* Status badges */
.medicare-appointments .status-badge {
    display: inline-block;
    padding: 8px 13px;
    border-radius: 30px;
    font-size: 11px;
    font-weight: 700;
}

.medicare-appointments .status-pending {
    background: #fff6df;
    color: #ae801e;
}

.medicare-appointments .status-approved {
    background: #e7f7f0;
    color: #21866b;
}

.medicare-appointments .status-rejected {
    background: #fff0f1;
    color: #bd5260;
}

.medicare-appointments .status-completed {
    background: #e7f3fa;
    color: #397fa9;
}

/* View details */
.medicare-appointments .view-btn {
    display: inline-flex;
    align-items: center;
    padding: 10px 15px;
    border-radius: 9px;
    background: #e7f3fa;
    color: #397fa9;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    white-space: nowrap;
    transition: background 0.2s ease;
}

.medicare-appointments .view-btn:hover {
    background: #d6eaf6;
}

/* Empty state */
.medicare-appointments .empty-state {
    padding: 50px 20px !important;
    text-align: center;
    color: #7a92a3;
}

/* Pagination */
.medicare-appointments .pagination-area {
    margin-top: 24px;
}

.medicare-appointments .pagination-links {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    flex-wrap: wrap;
}

.medicare-appointments .pagination-links a,
.medicare-appointments .pagination-links span {
    display: inline-block;
    padding: 10px 15px;
    border: 1px solid #dcebf3;
    border-radius: 9px;
    font-size: 12px;
    text-decoration: none;
}

.medicare-appointments .pagination-links a {
    background: #ffffff;
    color: #397fa9;
}

.medicare-appointments .pagination-links span {
    background: #f5f8fa;
    color: #7a92a3;
}

/* Responsive */
@media (max-width: 768px) {
    .medicare-appointments .appointments-card {
        padding: 16px;
    }

    .medicare-appointments .appointments-intro h2 {
        font-size: 19px;
    }

    .medicare-appointments .appointment-filters {
        flex-direction: column;
        align-items: stretch;
    }

    .medicare-appointments .appointment-filters input,
    .medicare-appointments .appointment-filters select,
    .medicare-appointments .filter-btn {
        width: 100%;
        min-width: 0;
    }
}
</style>
@endpush


@section('content')

<div class="medicare-appointments">

    {{-- TOP INFORMATION --}}
    <div class="appointments-topbar">

        <div class="appointments-intro">
            <h2>All Patient Appointments</h2>
            <p>
                Search, review and manage clinic booking requests.
            </p>
        </div>

        <a
            href="{{ route('admin.dashboard') }}"
            class="dashboard-back-link"
        >
            ← Back to Dashboard
        </a>

    </div>


    {{-- STATUS NOTIFICATIONS --}}
    @foreach (['success', 'error', 'warning'] as $type)

        @if (session($type))

            <div
                role="{{ $type === 'error' ? 'alert' : 'status' }}"
                style="
                    margin-bottom:20px;
                    padding:14px 17px;
                    border-radius:10px;
                    background:{{ $type === 'success' ? '#e7f7f0' : ($type === 'error' ? '#fff0f1' : '#fff6df') }};
                    color:{{ $type === 'success' ? '#21866b' : ($type === 'error' ? '#bd5260' : '#ae801e') }};
                    font-size:13px;
                "
            >
                {{ session($type) }}
            </div>

        @endif

    @endforeach


    {{-- MAIN CARD --}}
    <div class="appointments-card">

        {{-- SEARCH & STATUS FILTER --}}
        <form
            action="{{ route('admin.appointments.index') }}"
            method="GET"
            class="appointment-filters"
        >

            <input
                type="search"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search patient, email, phone or doctor..."
                maxlength="100"
                aria-label="Search appointments"
            >

            <select
                name="status"
                aria-label="Filter appointment status"
            >

                <option value="">All Statuses</option>

                @foreach ([
                    'pending' => 'Pending',
                    'approved' => 'Approved',
                    'rejected' => 'Rejected',
                    'completed' => 'Completed',
                ] as $value => $label)

                    <option
                        value="{{ $value }}"
                        @selected(request('status') === $value)
                    >
                        {{ $label }}
                    </option>

                @endforeach

            </select>

            <button type="submit" class="filter-btn">
                Apply Filter
            </button>

            <a
                href="{{ route('admin.appointments.index') }}"
                class="reset-filter"
            >
                Reset
            </a>

        </form>


        {{-- APPOINTMENTS TABLE --}}
        <div class="table-scroll">

            <table class="appointments-table">

                <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Date & Time</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($appointments as $appointment)

                        <tr>

                            {{-- BOOKING REFERENCE --}}
                            <td>
                                <strong>
                                    MED-{{ str_pad(
                                        (string) $appointment->id,
                                        6,
                                        '0',
                                        STR_PAD_LEFT
                                    ) }}
                                </strong>
                            </td>


                            {{-- PATIENT --}}
                            <td>
                                <span class="patient-name">
                                    {{ $appointment->patient_name }}
                                </span>

                                <span class="patient-email">
                                    {{ $appointment->email }}
                                </span>
                            </td>


                            {{-- DOCTOR --}}
                            <td>
                                {{
                                    $doctorNames[$appointment->doctor_name]
                                    ?? ucwords(str_replace('-', ' ', $appointment->doctor_name))
                                }}
                            </td>


                            {{-- DATE & TIME --}}
                            <td>
                                {{
                                    \Carbon\Carbon::parse(
                                        $appointment->appointment_date
                                    )->format('d M Y')
                                }}

                                <div style="margin-top:5px;color:#7a92a3;">
                                    {{
                                        \Carbon\Carbon::parse(
                                            $appointment->appointment_time
                                        )->format('h:i A')
                                    }}
                                </div>
                            </td>


                            {{-- STATUS --}}
                            <td>
                                <span class="status-badge status-{{ $appointment->status }}">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </td>


                            {{-- ACTION --}}
                            <td>
                                <a
                                    href="{{ route('admin.appointments.show', $appointment) }}"
                                    class="view-btn"
                                >
                                    View Details →
                                </a>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="empty-state">
                                No appointments found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}
        @if ($appointments->hasPages())

            <div class="pagination-area">

                <div class="pagination-links">

                    @if ($appointments->onFirstPage())
                        <span>← Previous</span>
                    @else
                        <a href="{{ $appointments->previousPageUrl() }}">
                            ← Previous
                        </a>
                    @endif

                    <span>
                        Page {{ $appointments->currentPage() }}
                        of {{ $appointments->lastPage() }}
                    </span>

                    @if ($appointments->hasMorePages())
                        <a href="{{ $appointments->nextPageUrl() }}">
                            Next →
                        </a>
                    @else
                        <span>Next →</span>
                    @endif

                </div>

            </div>

        @endif

    </div>

</div>

@endsection
