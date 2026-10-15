
@extends('admin.layouts.app')

@section('title', 'Activity Logs')

@section('page-title', 'Activity Logs')

@section('page-description', 'Review administrative activity and system changes.')

@push('styles')
<style>
.al-page {
    --al-surface: #ffffff;
    --al-border: #dce8f5;
    --al-heading: #193858;
    --al-text: #47637e;
    --al-muted: #8194a9;
    --al-soft: #f5f9fe;

    display: flex;
    flex-direction: column;
    gap: 22px;
}

.al-stats {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 17px;
}

.al-stat,
.al-panel {
    background: var(--al-surface);
    border: 1px solid var(--al-border);
    border-radius: 18px;
    box-shadow: 0 10px 30px rgba(28, 71, 127, .05);
}

.al-stat {
    padding: 22px;
}

.al-stat span {
    display: block;
    color: var(--al-muted);
    font-size: 12px;
    font-weight: 600;
}

.al-stat strong {
    display: block;
    margin-top: 12px;
    color: var(--al-heading);
    font-size: 30px;
    font-weight: 750;
}

.al-panel {
    overflow: hidden;
}

.al-panel-header {
    padding: 23px;
    border-bottom: 1px solid var(--al-border);
}

.al-panel-header h2 {
    margin: 0 0 7px;
    color: var(--al-heading);
    font-size: 19px;
}

.al-panel-header p {
    margin: 0;
    color: var(--al-muted);
    font-size: 12px;
}

.al-filters {
    display: flex;
    flex-wrap: wrap;
    gap: 11px;
    padding: 19px 23px;
    border-bottom: 1px solid var(--al-border);
}

.al-filters input,
.al-filters select {
    min-width: 155px;
    padding: 11px 12px;
    border: 1px solid var(--al-border);
    border-radius: 10px;
    background: var(--al-soft);
    color: var(--al-heading);
    font: inherit;
    font-size: 12px;
}

.al-filters input[name="search"] {
    flex: 1;
    min-width: 200px;
}

.al-search-btn,
.al-reset-btn {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    padding: 11px 17px;
    border-radius: 10px;
    font: inherit;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
}

.al-search-btn {
    border: none;
    background: #2866ad;
    color: #ffffff;
}

.al-reset-btn {
    border: 1px solid var(--al-border);
    background: var(--al-soft);
    color: var(--al-heading);
}

.al-table-wrap {
    width: 100%;
    overflow-x: auto;
}

.al-table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
}

.al-table th {
    padding: 15px 19px;
    background: var(--al-soft);
    color: var(--al-muted);
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .6px;
    white-space: nowrap;
}

.al-table td {
    padding: 17px 19px;
    border-top: 1px solid var(--al-border);
    color: var(--al-text);
    font-size: 12px;
    vertical-align: top;
}

.al-table tbody tr:hover {
    background: rgba(107, 161, 226, .05);
}

.al-actor strong,
.al-actor small {
    display: block;
}

.al-actor strong {
    color: var(--al-heading);
    font-size: 12px;
}

.al-actor small {
    margin-top: 5px;
    color: var(--al-muted);
    font-size: 11px;
}

.al-action {
    display: inline-flex;
    padding: 7px 11px;
    border-radius: 30px;
    background: #e7f1ff;
    color: #285d9d;
    font-size: 11px;
    font-weight: 700;
    white-space: nowrap;
}

.al-description {
    min-width: 180px;
    max-width: 350px;
    line-height: 1.6;
    overflow-wrap: anywhere;
}

.al-date {
    white-space: nowrap;
    line-height: 1.7;
}

.al-empty {
    padding: 45px 20px !important;
    text-align: center;
    color: var(--al-muted) !important;
}

.al-pagination {
    padding: 18px 23px;
    border-top: 1px solid var(--al-border);
    overflow-x: auto;
}

/* DARK MODE */

html[data-admin-theme="dark"] .al-page {
    --al-surface: #16253d;
    --al-border: #344762;
    --al-heading: #edf5ff;
    --al-text: #c1d2e8;
    --al-muted: #a8bbd4;
    --al-soft: #101d32;
}

html[data-admin-theme="dark"] .al-action {
    background: #294463;
    color: #c2dfff;
}

html[data-admin-theme="dark"] .al-table tbody tr:hover {
    background: #203650;
}

@media (max-width: 700px) {
    .al-stats {
        grid-template-columns: 1fr;
    }

    .al-panel-header,
    .al-filters {
        padding: 17px;
    }
}
</style>
@endpush

@section('content')

<div class="al-page">

    {{-- STATISTICS --}}
    <div class="al-stats">

        <div class="al-stat">
            <span>Total Activities</span>
            <strong>{{ number_format($stats['total']) }}</strong>
        </div>

        <div class="al-stat">
            <span>Today's Activities</span>
            <strong>{{ number_format($stats['today']) }}</strong>
        </div>

    </div>

    {{-- HISTORY --}}
    <section class="al-panel">

        <div class="al-panel-header">
            <h2>Activity History</h2>
            <p>Search and review recorded administrative actions.</p>
        </div>

        <form
            class="al-filters"
            method="GET"
            action="{{ route('admin.activity-logs.index') }}"
        >

            <input
                type="search"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search activity..."
                maxlength="150"
                aria-label="Search activity"
            >

            <select name="action" aria-label="Filter activity">
                <option value="">All Actions</option>

                @foreach($actions as $action)
                    <option
                        value="{{ $action }}"
                        @selected(request('action') === $action)
                    >
                        {{ ucwords(str_replace(['_', '.'], ' ', $action)) }}
                    </option>
                @endforeach
            </select>

            <input
                type="date"
                name="date"
                value="{{ request('date') }}"
                aria-label="Filter by date"
            >

            <button type="submit" class="al-search-btn">
                Apply Filters
            </button>

            <a href="{{ route('admin.activity-logs.index') }}"
               class="al-reset-btn">
                Reset
            </a>

        </form>

        <div class="al-table-wrap">

            <table class="al-table">

                <thead>
                    <tr>
                        <th>Administrator</th>
                        <th>Action</th>
                        <th>Description</th>
                        <th>IP Address</th>
                        <th>Date & Time</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($logs as $log)

                        <tr>
                            <td>
                                <div class="al-actor">
                                    <strong>
                                        {{ $log->user?->name ?? 'System' }}
                                    </strong>

                                    <small>
                                        User ID: {{ $log->user_id ?? '—' }}
                                    </small>
                                </div>
                            </td>

                            <td>
                                <span class="al-action">
                                    {{ ucwords(str_replace(['_', '.'], ' ', $log->action)) }}
                                </span>
                            </td>

                            <td>
                                <div class="al-description">
                                    {{ $log->description }}
                                </div>
                            </td>

                            <td>
                                {{ $log->ip_address ?? '—' }}
                            </td>

                            <td>
                                <div class="al-date">
                                    {{ $log->created_at?->format('d M Y') }}
                                    <br>
                                    {{ $log->created_at?->format('h:i A') }}
                                </div>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="al-empty">
                                No activities recorded yet.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if($logs->hasPages())
            <div class="al-pagination">
                {{ $logs->links() }}
            </div>
        @endif

    </section>

</div>

@endsection
