
@extends('admin.layouts.app')

@section('title', 'Doctors Management')
@section('page-title', 'Doctors Management')

@section('content')

<div class="doctor-admin-page">

    <div class="doctor-admin-intro">
        <div>
            <h2>Manage Medical Specialists</h2>
            <p>
                Add, update and manage doctors appearing
                on the Medicare+ website.
            </p>
        </div>

        <a href="{{ route('admin.doctors.create') }}"
           class="doctor-admin-primary-btn">
            + Add New Doctor
        </a>
    </div>

    <div class="doctor-admin-stats">
        <div class="doctor-admin-stat">
            <span>Total Doctors</span>
            <strong>{{ $doctors->total() }}</strong>
        </div>

        <div class="doctor-admin-stat">
            <span>Showing</span>
            <strong>{{ $doctors->count() }}</strong>
        </div>

        <div class="doctor-admin-stat">
            <span>Current Page</span>
            <strong>{{ $doctors->currentPage() }}</strong>
        </div>
    </div>

    <div class="doctor-admin-panel">

        <form method="GET"
              action="{{ route('admin.doctors.index') }}"
              class="doctor-admin-search">

            <input
                type="search"
                name="search"
                value="{{ $search }}"
                placeholder="Search name, specialization or department..."
            >

            <button type="submit">
                Search
            </button>

            @if($search !== '')
                <a href="{{ route('admin.doctors.index') }}"
                   class="doctor-admin-reset">
                    Clear
                </a>
            @endif
        </form>

        <div class="doctor-admin-table-wrap">
            <table class="doctor-admin-table">
                <thead>
                    <tr>
                        <th>Doctor</th>
                        <th>Specialization</th>
                        <th>Experience</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($doctors as $doctor)

                        <tr>
                            <td>
                                <div class="doctor-admin-identity">

                                    <img
                                        src="{{ asset($doctor->image_path ?: 'images/doctor-1.jpg') }}"
                                        alt="{{ $doctor->name }}"
                                    >

                                    <div>
                                        <strong>
                                            {{ $doctor->name }}
                                        </strong>

                                        <span>
                                            {{ $doctor->department ?: 'No department' }}
                                        </span>
                                    </div>

                                </div>
                            </td>

                            <td>{{ $doctor->specialization }}</td>

                            <td>
                                {{ $doctor->experience_years }} years
                            </td>

                            <td>{{ $doctor->sort_order }}</td>

                            <td>
                                @if($doctor->is_active)
                                    <span class="doctor-admin-status active">
                                        Active
                                    </span>
                                @else
                                    <span class="doctor-admin-status inactive">
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="doctor-admin-actions">

                                    <a
                                        href="{{ route('admin.doctors.edit', $doctor) }}"
                                        class="doctor-admin-action edit"
                                    >
                                        Edit
                                    </a>

                                    @if($doctor->is_active)
                                        <a
                                            href="{{ route('doctors.show', $doctor->slug) }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="doctor-admin-action view"
                                        >
                                            Profile
                                        </a>
                                    @endif

                                    <form
                                        method="POST"
                                        action="{{ route('admin.doctors.status', $doctor) }}"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="doctor-admin-action status"
                                            onclick="return confirm('Change status of {{ $doctor->name }}?')"
                                        >
                                            {{ $doctor->is_active ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="doctor-admin-empty">
                                No doctors found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($doctors->hasPages())
            <div class="doctor-admin-pagination">
                {{ $doctors->links() }}
            </div>
        @endif

    </div>

</div>

@endsection
