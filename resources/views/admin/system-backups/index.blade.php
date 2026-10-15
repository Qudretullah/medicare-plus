
@extends('admin.layouts.app')

@section('title', 'Database Backups')
@section('page-title', 'Backup & Restore')
@section('page-description', 'Create and manage secure Medicare+ database backups.')

@push('styles')
<style>
.backup-page {
    display: flex;
    flex-direction: column;
    gap: 22px;
}

.backup-card {
    background: #fff;
    border: 1px solid #dce7f3;
    border-radius: 18px;
    padding: 25px;
}

.backup-card h2 {
    margin: 0 0 10px;
    font-size: 20px;
    color: #193858;
    font-weight: 600;
}

.backup-card p {
    color: #738ba4;
    font-size: 13px;
    line-height: 1.7;
}

.backup-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 0;
    border-radius: 10px;
    padding: 12px 18px;
    background: #286ab0;
    color: #fff;
    font: inherit;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
}

.backup-download {
    background: #edf4ff;
    color: #286ab0;
}

.backup-alert {
    padding: 13px 16px;
    border-radius: 10px;
    font-size: 13px;
}

.backup-success {
    background: #e9f8ef;
    color: #237546;
}

.backup-error {
    background: #fff0f0;
    color: #a23737;
}

.backup-table-wrap {
    overflow-x: auto;
}

.backup-table {
    width: 100%;
    border-collapse: collapse;
}

.backup-table th,
.backup-table td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #e1e9f3;
    color: #536d88;
    font-size: 12px;
}

.backup-table th {
    font-weight: 700;
}

.backup-table td {
    overflow-wrap: anywhere;
}

.backup-status {
    font-size: 11px;
    font-weight: 700;
    color: #237546;
}

html[data-admin-theme="dark"] .backup-card {
    background: #17263e;
    border-color: #344762;
}

html[data-admin-theme="dark"] .backup-card h2 {
    color: #edf5ff;
}

html[data-admin-theme="dark"] .backup-card p,
html[data-admin-theme="dark"] .backup-table td,
html[data-admin-theme="dark"] .backup-table th {
    color: #bed0e6;
}

html[data-admin-theme="dark"] .backup-table td,
html[data-admin-theme="dark"] .backup-table th {
    border-color: #344762;
}

html[data-admin-theme="dark"] .backup-download {
    background: #29486b;
    color: #e2efff;
}

html[data-admin-theme="dark"] .backup-status {
    color: #9de4b8;
}
</style>
@endpush

@section('content')

<div class="backup-page">

    @if(session('success'))
        <div class="backup-alert backup-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="backup-alert backup-error">
            {{ session('error') }}
        </div>
    @endif

    <section class="backup-card">

        <h2>Database Backup</h2>

        <p>
            Create a private SQL backup of the Medicare+
            database, including appointments, doctors,
            services, website content and settings.
        </p>

        <p>
            Database backups do not include uploaded image
            files or Laravel application source code.
        </p>

        <form method="POST"
              action="{{ route('admin.system-backups.store') }}">

            @csrf

            <button type="submit"
                    class="backup-btn">
                Create Database Backup
            </button>

        </form>

    </section>

    <section class="backup-card">

        <h2>Backup History</h2>

        <div class="backup-table-wrap">

            <table class="backup-table">

                <thead>
                    <tr>
                        <th>Backup File</th>
                        <th>Date & Time</th>
                        <th>Size</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($backups as $backup)

                        <tr>

                            <td>
                                {{ $backup->filename }}
                            </td>

                            <td>
                                {{ $backup->created_at
                                    ?->timezone('Asia/Karachi')
                                    ->format('d M Y, h:i A') }}
                            </td>

                            <td>
                                {{ $backup->file_size !== null
                                    ? number_format($backup->file_size / 1024 / 1024, 2) . ' MB'
                                    : '—' }}
                            </td>

                            <td>
                                <span class="backup-status">
                                    {{ ucfirst($backup->status) }}
                                </span>
                            </td>

                            <td>

                                @if($backup->status === 'completed')

                                    <a
                                        href="{{ route('admin.system-backups.download', $backup) }}"
                                        class="backup-btn backup-download">
                                        Download
                                    </a>

                                @else

                                    —

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5">
                                No database backups created yet.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if($backups->hasPages())
            <div style="margin-top:20px;">
                {{ $backups->links() }}
            </div>
        @endif

    </section>

</div>

@endsection
