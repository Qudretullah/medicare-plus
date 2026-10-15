
@extends('admin.layouts.app')

@section('title', 'Content Revision History')

@section('page-title', 'Content Revision History')

@section('page-description', 'Review and safely restore previous website content.')

@push('styles')
<style>
.cr-page {
    --cr-bg: #ffffff;
    --cr-border: #dce7f3;
    --cr-text: #193956;
    --cr-muted: #71869f;
    --cr-soft: #f5f9fd;
    --cr-old: #fff3f1;
    --cr-new: #edf8f3;

    display: flex;
    flex-direction: column;
    gap: 22px;
}

.cr-card {
    background: var(--cr-bg);
    border: 1px solid var(--cr-border);
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 8px 24px rgba(30, 71, 120, .04);
}

.cr-header {
    padding: 24px;
    border-bottom: 1px solid var(--cr-border);
}

.cr-header h2 {
    color: var(--cr-text);
    font-size: 20px;
    font-weight: 600;
    margin: 0 0 8px;
}

.cr-header p {
    color: var(--cr-muted);
    font-size: 13px;
    margin: 0;
    line-height: 1.6;
}

.cr-alert {
    padding: 14px 18px;
    border-radius: 12px;
    font-size: 13px;
    line-height: 1.6;
}

.cr-success {
    background: #e8f7ee;
    color: #206441;
}

.cr-error {
    background: #fff0f0;
    color: #a53535;
}

.cr-toolbar {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    padding: 20px 24px;
    border-bottom: 1px solid var(--cr-border);
}

.cr-search {
    min-width: 200px;
    flex: 1;
    border: 1px solid var(--cr-border);
    background: var(--cr-soft);
    border-radius: 10px;
    padding: 12px 14px;
    color: var(--cr-text);
    font: inherit;
    font-size: 13px;
}

.cr-btn {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    gap: 7px;
    text-decoration: none;
    border-radius: 10px;
    padding: 11px 16px;
    font: inherit;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
}

.cr-btn-primary {
    color: #fff;
    border: 1px solid #276bb0;
    background: #276bb0;
}

.cr-btn-outline {
    color: var(--cr-text);
    border: 1px solid var(--cr-border);
    background: var(--cr-soft);
}

.cr-list {
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.cr-item {
    border: 1px solid var(--cr-border);
    border-radius: 14px;
    overflow: hidden;
    background: var(--cr-bg);
}

.cr-item-top {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
    padding: 17px 20px;
    background: var(--cr-soft);
    border-bottom: 1px solid var(--cr-border);
}

.cr-item-title {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.cr-item-title strong {
    font-size: 14px;
    font-weight: 600;
    color: var(--cr-text);
}

.cr-item-title small {
    color: var(--cr-muted);
    font-size: 11px;
    overflow-wrap: anywhere;
}

.cr-status {
    display: inline-flex;
    border-radius: 50px;
    padding: 7px 11px;
    background: #e5f0ff;
    color: #285f9d;
    font-size: 11px;
    font-weight: 700;
    text-transform: capitalize;
}

.cr-status-created {
    background: #e9f7ed;
    color: #237a46;
}

.cr-status-deleted {
    background: #fff0ee;
    color: #b54939;
}

.cr-item-body {
    padding: 20px;
}

.cr-diff {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 14px;
}

.cr-value-box {
    border: 1px solid var(--cr-border);
    border-radius: 12px;
    padding: 15px;
    min-width: 0;
}

.cr-old {
    background: var(--cr-old);
}

.cr-new {
    background: var(--cr-new);
}

.cr-value-label {
    font-size: 11px;
    font-weight: 700;
    margin-bottom: 12px;
    color: var(--cr-text);
}

.cr-value-content {
    color: var(--cr-text);
    font-size: 13px;
    line-height: 1.7;
    white-space: pre-wrap;
    overflow-wrap: anywhere;
    max-height: 180px;
    overflow-y: auto;
}

.cr-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 8px 22px;
    margin-top: 17px;
    color: var(--cr-muted);
    font-size: 11px;
}

.cr-restore-area {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 12px;
    margin-top: 20px;
    padding-top: 16px;
    border-top: 1px solid var(--cr-border);
}

.cr-confirm {
    display: flex;
    align-items: flex-start;
    gap: 9px;
    font-size: 12px;
    line-height: 1.5;
    color: var(--cr-text);
}

.cr-confirm input {
    margin-top: 3px;
}

.cr-restore-btn {
    border: 0;
    border-radius: 9px;
    background: #285f9d;
    color: #fff;
    padding: 11px 18px;
    font: inherit;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
}

.cr-note {
    margin-top: 15px;
    color: var(--cr-muted);
    font-size: 12px;
    line-height: 1.6;
}

.cr-empty {
    padding: 45px 20px;
    color: var(--cr-muted);
    text-align: center;
    font-size: 13px;
}

.cr-pagination {
    padding: 20px;
    border-top: 1px solid var(--cr-border);
    overflow-x: auto;
}

html[data-admin-theme="dark"] .cr-page {
    --cr-bg: #17263e;
    --cr-border: #344762;
    --cr-text: #edf5ff;
    --cr-muted: #a8bad0;
    --cr-soft: #111e32;
    --cr-old: #35262f;
    --cr-new: #1d393a;
}

html[data-admin-theme="dark"] .cr-status {
    background: #29486b;
    color: #d4e8ff;
}

html[data-admin-theme="dark"] .cr-status-created {
    background: #214b39;
    color: #b6f0cd;
}

html[data-admin-theme="dark"] .cr-status-deleted {
    background: #512b36;
    color: #ffd0d0;
}

html[data-admin-theme="dark"] .cr-success {
    background: #204735;
    color: #c6f5d8;
}

html[data-admin-theme="dark"] .cr-error {
    background: #502931;
    color: #ffd1d1;
}

@media (max-width: 768px) {
    .cr-diff {
        grid-template-columns: 1fr;
    }

    .cr-toolbar,
    .cr-header,
    .cr-item-body {
        padding: 16px;
    }

    .cr-list {
        padding: 12px;
    }

    .cr-search {
        flex-basis: 100%;
    }
}
</style>
@endpush

@section('content')

<div class="cr-page">

    @if(session('success'))
        <div class="cr-alert cr-success" role="status">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="cr-alert cr-error" role="alert">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="cr-alert cr-error" role="alert">
            {{ $errors->first() }}
        </div>
    @endif

    <section class="cr-card">

        <div class="cr-header">
            <h2>Website Content History</h2>

            <p>
                Review previous CMS changes and restore
                the immediately preceding value when
                it is still safe to do so.
            </p>
        </div>

        <form
            method="GET"
            action="{{ route('admin.content-revisions.index') }}"
            class="cr-toolbar"
        >

            <input
                type="search"
                name="search"
                class="cr-search"
                placeholder="Search action or item ID..."
                aria-label="Search revisions"
                maxlength="150"
                value="{{ request('search') }}"
            >

            <button type="submit"
                    class="cr-btn cr-btn-primary">
                Search History
            </button>

            <a href="{{ route('admin.content-revisions.index') }}"
               class="cr-btn cr-btn-outline">
                Reset
            </a>

        </form>

        <div class="cr-list">

            @forelse($revisions as $revision)

                @php
                    $oldValues = $revision->old_values ?? [];
                    $newValues = $revision->new_values ?? [];

                    $oldValue = $oldValues['value'] ?? null;
                    $newValue = $newValues['value'] ?? null;

                    $hasOldValue = array_key_exists(
                        'value',
                        $oldValues
                    );

                    $hasNewValue = array_key_exists(
                        'value',
                        $newValues
                    );

                    $canRequestRestore =
                        $revision->action === 'updated'
                        && $hasOldValue
                        && $hasNewValue
                        && is_string($oldValue)
                        && is_string($newValue);
                @endphp

                <article class="cr-item">

                    <div class="cr-item-top">

                        <div class="cr-item-title">

                            <strong>
                                CMS Item #{{ $revision->model_id }}
                            </strong>

                            <small>
                                Revision #{{ $revision->id }}
                                ·
                                {{ $revision->created_at?->timezone('Asia/Karachi')->format('d M Y, h:i A') ?? '—' }}
                            </small>

                        </div>

                        <span class="cr-status cr-status-{{ $revision->action }}">
                            {{ ucfirst($revision->action) }}
                        </span>

                    </div>

                    <div class="cr-item-body">

                        <div class="cr-diff">

                            <div class="cr-value-box cr-old">

                                <div class="cr-value-label">
                                    Previous Value
                                </div>

                                <div class="cr-value-content">
                                    @if($hasOldValue)
                                        {{ is_scalar($oldValue) || is_null($oldValue) ? ($oldValue ?? 'Empty') : '[Complex value]' }}
                                    @else
                                        Not recorded in this revision
                                    @endif
                                </div>

                            </div>

                            <div class="cr-value-box cr-new">

                                <div class="cr-value-label">
                                    Updated Value
                                </div>

                                <div class="cr-value-content">
                                    @if($hasNewValue)
                                        {{ is_scalar($newValue) || is_null($newValue) ? ($newValue ?? 'Empty') : '[Complex value]' }}
                                    @else
                                        Not recorded in this revision
                                    @endif
                                </div>

                            </div>

                        </div>

                        <div class="cr-meta">

                            <span>
                                Changed By:
                                {{ $revision->editor?->name ?? 'Unknown Admin' }}
                            </span>

                            <span>
                                Action:
                                {{ ucfirst($revision->action) }}
                            </span>

                            <span>
                                Item ID:
                                {{ $revision->model_id }}
                            </span>

                        </div>

                        @if($canRequestRestore)

                            <form
                                method="POST"
                                action="{{ route('admin.content-revisions.restore', $revision) }}"
                                class="cr-restore-area"
                            >

                                @csrf

                                <label class="cr-confirm">
                                    <input
                                        type="checkbox"
                                        name="confirm_restore"
                                        value="1"
                                        required
                                    >

                                    <span>
                                        I understand that this will
                                        restore the previous CMS value.
                                    </span>
                                </label>

                                <button
                                    type="submit"
                                    class="cr-restore-btn"
                                >
                                    Restore Previous Value
                                </button>

                            </form>

                        @else

                            <p class="cr-note">
                                This revision does not support
                                direct value restoration.
                            </p>

                        @endif

                    </div>

                </article>

            @empty

                <div class="cr-empty">
                    No revision history found.
                </div>

            @endforelse

        </div>

        @if($revisions->hasPages())
            <div class="cr-pagination">
                {{ $revisions->links() }}
            </div>
        @endif

    </section>

</div>

@endsection
