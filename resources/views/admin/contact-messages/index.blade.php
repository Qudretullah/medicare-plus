
@extends('admin.layouts.app')

@section('title', 'Contact Messages | Medicare+ Admin')

@section('content')

<div class="cm-page">

    <div class="cm-page-header">
        <div>
            <span class="cm-eyebrow">COMMUNICATION CENTER</span>
            <h1>Contact Messages</h1>
            <p>View and manage messages received from your website.</p>
        </div>
    </div>

    <div class="cm-stats">
        <div class="cm-stat-card">
            <span>Total Messages</span>
            <strong>{{ $stats['total'] }}</strong>
        </div>

        <div class="cm-stat-card">
            <span>New Messages</span>
            <strong>{{ $stats['new'] }}</strong>
        </div>

        <div class="cm-stat-card">
            <span>Read Messages</span>
            <strong>{{ $stats['read'] }}</strong>
        </div>
    </div>

    @if(session('success'))
        <div class="cm-alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="cm-panel">

        <div class="cm-panel-header">
            <div>
                <h2>Message Inbox</h2>
                <p>Manage patient and visitor inquiries.</p>
            </div>

            <form method="GET"
                  action="{{ route('admin.contact-messages.index') }}"
                  class="cm-search">

                <input
                    type="search"
                    name="search"
                    placeholder="Search name, email or subject..."
                    value="{{ request('search') }}"
                >

                <button type="submit">Search</button>

                @if(request()->filled('search'))
                    <a href="{{ route('admin.contact-messages.index') }}">
                        Clear
                    </a>
                @endif
            </form>
        </div>

        <div class="cm-table-wrap">
            <table class="cm-table">
                <thead>
                    <tr>
                        <th>Sender</th>
                        <th>Subject</th>
                        <th>Received</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($messages as $message)
                        <tr>
                            <td>
                                <div class="cm-sender">
                                    <span class="cm-avatar">
                                        {{ strtoupper(substr($message->name, 0, 1)) }}
                                    </span>

                                    <div>
                                        <strong>{{ $message->name }}</strong>
                                        <small>{{ $message->email }}</small>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="cm-subject">
                                    <strong>{{ $message->subject }}</strong>
                                    <small>
                                        {{ \Illuminate\Support\Str::limit($message->message, 65) }}
                                    </small>
                                </div>
                            </td>

                            <td>
                                <span class="cm-date">
                                    {{ $message->created_at->format('d M Y') }}
                                </span>
                                <small class="cm-time">
                                    {{ $message->created_at->format('h:i A') }}
                                </small>
                            </td>

                            <td>
                                @if($message->status === 'new')
                                    <span class="cm-status cm-status-new">
                                        New
                                    </span>
                                @else
                                    <span class="cm-status cm-status-read">
                                        Read
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="cm-actions">
                                    <a
                                        class="cm-view-btn"
                                        href="{{ route('admin.contact-messages.show', $message) }}"
                                    >
                                        View
                                    </a>

                                    <form
                                        action="{{ route('admin.contact-messages.destroy', $message) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this message?');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="cm-delete-btn">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="cm-empty">
                                    <h3>No Messages Found</h3>
                                    <p>No contact messages match your search.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($messages->hasPages())
            <div class="cm-pagination">
                {{ $messages->links() }}
            </div>
        @endif

    </div>
</div>

<style>
.cm-page {
    padding: 12px 0 32px;
    color: #183153;
}

.cm-page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 25px;
}

.cm-eyebrow {
    display: block;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 2px;
    color: #4386bb;
    margin-bottom: 10px;
}

.cm-page-header h1 {
    font-size: 30px;
    font-weight: 700;
    margin: 0 0 8px;
}

.cm-page-header p,
.cm-panel-header p {
    color: #7a8da5;
    margin: 0;
    font-size: 14px;
}

.cm-stats {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 18px;
    margin-bottom: 25px;
}

.cm-stat-card {
    background: linear-gradient(135deg, #ffffff, #f5faff);
    border: 1px solid #e0ebf5;
    border-radius: 17px;
    padding: 25px;
    box-shadow: 0 8px 30px rgba(38, 88, 142, .05);
}

.cm-stat-card span {
    color: #7188a1;
    font-size: 13px;
    font-weight: 600;
}

.cm-stat-card strong {
    display: block;
    font-size: 32px;
    color: #173c67;
    margin-top: 10px;
}

.cm-panel {
    background: #fff;
    border: 1px solid #e0ebf5;
    border-radius: 20px;
    box-shadow: 0 12px 35px rgba(38, 88, 142, .05);
    overflow: hidden;
}

.cm-panel-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    padding: 25px;
    border-bottom: 1px solid #e8eff6;
}

.cm-panel-header h2 {
    margin: 0 0 7px;
    font-size: 19px;
    color: #183153;
}

.cm-search {
    display: flex;
    align-items: center;
    gap: 8px;
}

.cm-search input {
    min-width: 235px;
    padding: 11px 13px;
    border: 1px solid #dae7f1;
    border-radius: 10px;
    background: #f8fbff;
    color: #183153;
    outline: none;
}

.cm-search input:focus {
    border-color: #65a2d8;
}

.cm-search button,
.cm-view-btn {
    background: #246aa6;
    color: #fff;
    border: 0;
    border-radius: 9px;
    padding: 11px 15px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
}

.cm-search a {
    color: #597b9c;
    font-size: 12px;
    text-decoration: none;
}

.cm-table-wrap {
    width: 100%;
    overflow-x: auto;
}

.cm-table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
}

.cm-table th {
    background: #f7fbff;
    padding: 15px 20px;
    font-size: 11px;
    color: #69829b;
    text-transform: uppercase;
    letter-spacing: .6px;
    white-space: nowrap;
}

.cm-table td {
    padding: 17px 20px;
    border-top: 1px solid #edf2f7;
    font-size: 13px;
    vertical-align: middle;
}

.cm-table tbody tr:hover {
    background: #f9fcff;
}

.cm-sender {
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 180px;
}

.cm-avatar {
    display: grid;
    place-items: center;
    width: 39px;
    height: 39px;
    flex-shrink: 0;
    border-radius: 12px;
    background: #e7f3fc;
    color: #246aa6;
    font-weight: 700;
}

.cm-sender strong,
.cm-subject strong {
    display: block;
    color: #203e60;
    font-size: 13px;
    margin-bottom: 5px;
}

.cm-sender small,
.cm-subject small,
.cm-time {
    display: block;
    color: #8799ac;
    font-size: 11px;
}

.cm-subject {
    min-width: 170px;
    max-width: 260px;
}

.cm-date {
    display: block;
    color: #45627f;
    font-size: 12px;
    white-space: nowrap;
}

.cm-status {
    display: inline-block;
    padding: 7px 12px;
    border-radius: 30px;
    font-size: 11px;
    font-weight: 700;
}

.cm-status-new {
    background: #e1f2ff;
    color: #196ca8;
}

.cm-status-read {
    background: #e9f7f0;
    color: #27805b;
}

.cm-actions {
    display: flex;
    align-items: center;
    gap: 8px;
}

.cm-actions form {
    margin: 0;
}

.cm-delete-btn {
    padding: 10px 13px;
    background: #fff1f1;
    border: 1px solid #ffdada;
    border-radius: 9px;
    color: #be4b54;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
}

.cm-delete-btn:hover {
    background: #ffe3e5;
}

.cm-pagination {
    padding: 20px 25px;
    border-top: 1px solid #edf2f7;
}

.cm-alert {
    padding: 14px 18px;
    background: #eaf8ef;
    color: #26794c;
    border: 1px solid #ccebd8;
    border-radius: 12px;
    margin-bottom: 20px;
    font-size: 13px;
}

.cm-empty {
    padding: 45px 20px;
    text-align: center;
}

.cm-empty h3 {
    margin-bottom: 8px;
    color: #294e70;
}

.cm-empty p {
    color: #8598ac;
}

@media (max-width: 900px) {
    .cm-panel-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .cm-search {
        width: 100%;
        flex-wrap: wrap;
    }

    .cm-search input {
        flex: 1;
        min-width: 150px;
    }
}

@media (max-width: 600px) {
    .cm-stats {
        grid-template-columns: 1fr;
    }

    .cm-page-header h1 {
        font-size: 25px;
    }

    .cm-panel-header {
        padding: 20px;
    }
}
</style>

@endsection
