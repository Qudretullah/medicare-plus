
@extends('admin.layouts.app')

@section('title', 'Departments Management')
@section('page-title', 'Departments Management')
@section('page-description', 'Manage medical departments, availability and display order.')

@section('content')

<div class="doctor-admin-page">

    <div class="doctor-admin-intro">
        <div>
            <h2>Medical Departments</h2>
            <p>Organize specialties and manage departments across your clinic.</p>
        </div>

        <a href="{{ route('admin.departments.create') }}"
           class="doctor-admin-primary-btn">
            + Add Department
        </a>
    </div>

    <div class="doctor-admin-stats">
        <div class="doctor-admin-stat">
            <span>Total Departments</span>
            <strong>{{ \App\Models\Department::count() }}</strong>
        </div>

        <div class="doctor-admin-stat">
            <span>Active Departments</span>
            <strong>{{ \App\Models\Department::where('is_active', true)->count() }}</strong>
        </div>

        <div class="doctor-admin-stat">
            <span>Inactive Departments</span>
            <strong>{{ \App\Models\Department::where('is_active', false)->count() }}</strong>
        </div>
    </div>

    <div class="doctor-admin-panel">

        <form action="{{ route('admin.departments.index') }}"
              method="GET"
              class="doctor-admin-search">

            <input type="search"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Search departments by name or description...">

            <button type="submit">Search</button>

            @if(request()->filled('search'))
                <a href="{{ route('admin.departments.index') }}"
                   class="doctor-admin-reset">
                    Clear
                </a>
            @endif
        </form>

        <div class="doctor-admin-table-wrap">

            <table class="doctor-admin-table">
                <thead>
                    <tr>
                        <th>Department</th>
                        <th>Status</th>
                        <th>Sort Order</th>
                        <th>Updated</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($departments as $department)
                        <tr>
                            <td>
                                <div class="doctor-admin-identity">
                                    <div class="department-admin-icon">
                                        {{ $department->icon ?: '✚' }}
                                    </div>

                                    <div>
                                        <strong>{{ $department->name }}</strong>
                                        <span>{{ $department->slug }}</span>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="doctor-admin-status {{ $department->is_active ? 'active' : 'inactive' }}">
                                    {{ $department->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>

                            <td>{{ $department->sort_order }}</td>

                            <td>
                                {{ $department->updated_at?->format('d M Y') }}
                            </td>

                            <td>
                                <div class="doctor-admin-actions">

                                    <a href="{{ route('admin.departments.edit', $department) }}"
                                       class="doctor-admin-action edit">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.departments.toggle-status', $department) }}"
                                          method="POST">
                                        @csrf
                                        @method('PATCH')

                                        <button type="submit"
                                                class="doctor-admin-action status">
                                            {{ $department->is_active ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.departments.destroy', $department) }}"
                                          method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this department?');">

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
                                No departments found. Add your first department to get started.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

        @if($departments->hasPages())
            <div class="doctor-admin-pagination">
                {{ $departments->links() }}
            </div>
        @endif

    </div>
</div>

@endsection
