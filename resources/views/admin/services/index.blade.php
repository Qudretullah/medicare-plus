
@extends('admin.layouts.app')

@section('title', 'Services Management')
@section('page-title', 'Services Management')
@section('page-description', 'Manage healthcare services, visibility and display order.')

@section('content')

<div class="doctor-admin-page">

    <!-- PAGE INTRO -->
    <div class="doctor-admin-intro">

        <div>
            <h2>Medical Services</h2>
            <p>Manage the services offered by Medicare+.</p>
        </div>

        <a href="{{ route('admin.services.create') }}"
           class="doctor-admin-primary-btn">
            + Add Service
        </a>

    </div>

    <!-- STATISTICS -->
    <div class="doctor-admin-stats">

        <div class="doctor-admin-stat">
            <span>Total Services</span>
            <strong>{{ $stats['total'] }}</strong>
        </div>

        <div class="doctor-admin-stat">
            <span>Active Services</span>
            <strong>{{ $stats['active'] }}</strong>
        </div>

        <div class="doctor-admin-stat">
            <span>Inactive Services</span>
            <strong>{{ $stats['inactive'] }}</strong>
        </div>

    </div>

    <!-- SERVICES TABLE -->
    <div class="doctor-admin-panel">

        <!-- SEARCH -->
        <form action="{{ route('admin.services.index') }}"
              method="GET"
              class="doctor-admin-search">

            <input
                type="search"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search services by name or description..."
            >

            <button type="submit">Search</button>

            @if(request()->filled('search'))
                <a href="{{ route('admin.services.index') }}"
                   class="doctor-admin-reset">
                    Clear
                </a>
            @endif

        </form>

        <div class="doctor-admin-table-wrap">

            <table class="doctor-admin-table">

                <thead>
                    <tr>
                        <th>Service</th>
                        <th>Status</th>
                        <th>Sort Order</th>
                        <th>Updated</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($services as $service)

                        <tr>

                            <!-- SERVICE -->
                            <td>
                                <div class="doctor-admin-identity">

                                    <div class="department-admin-icon">
                                        {{ $service->icon ?: '✚' }}
                                    </div>

                                    <div>
                                        <strong>{{ $service->name }}</strong>
                                        <span>{{ $service->slug }}</span>
                                    </div>

                                </div>
                            </td>

                            <!-- STATUS -->
                            <td>
                                <span class="doctor-admin-status {{ $service->is_active ? 'active' : 'inactive' }}">
                                    {{ $service->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>

                            <!-- SORT ORDER -->
                            <td>{{ $service->sort_order }}</td>

                            <!-- UPDATED -->
                            <td>
                                {{ $service->updated_at?->format('d M Y') }}
                            </td>

                            <!-- ACTIONS -->
                            <td>

                                <div class="doctor-admin-actions">

                                    <a href="{{ route('admin.services.edit', $service) }}"
                                       class="doctor-admin-action edit">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.services.toggle-status', $service) }}"
                                          method="POST">

                                        @csrf
                                        @method('PATCH')

                                        <button type="submit"
                                                class="doctor-admin-action status">
                                            {{ $service->is_active ? 'Deactivate' : 'Activate' }}
                                        </button>

                                    </form>

                                    <form action="{{ route('admin.services.destroy', $service) }}"
                                          method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this service?');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="doctor-admin-action"
                                                style="background:#fff0f1;color:#b84759;">
                                            Delete
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="doctor-admin-empty">
                                No services found. Add your first service to get started.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <!-- PAGINATION -->
        @if($services->hasPages())
            <div class="doctor-admin-pagination">
                {{ $services->links() }}
            </div>
        @endif

    </div>

</div>

@endsection
