
@extends('admin.layouts.app')

@section('title', 'View Contact Message | Medicare+ Admin')

@section('content')

<div class="cmd-page">

    <div class="cmd-topbar">
        <div>
            <span class="cmd-eyebrow">COMMUNICATION CENTER</span>
            <h1>Message Details</h1>
            <p>Review the complete inquiry received through your website.</p>
        </div>

        <a href="{{ route('admin.contact-messages.index') }}"
           class="cmd-back">
            ← Back to Inbox
        </a>
    </div>

    <div class="cmd-layout">

        <div class="cmd-main-card">

            <div class="cmd-message-header">
                <div>
                    <span class="cmd-label">MESSAGE SUBJECT</span>
                    <h2>{{ $contactMessage->subject }}</h2>
                </div>

                <span class="cmd-status">
                    {{ ucfirst($contactMessage->status) }}
                </span>
            </div>

            <div class="cmd-sender">
                <div class="cmd-avatar">
                    {{ strtoupper(substr($contactMessage->name, 0, 1)) }}
                </div>

                <div>
                    <strong>{{ $contactMessage->name }}</strong>
                    <span>{{ $contactMessage->email }}</span>
                </div>
            </div>

            <div class="cmd-divider"></div>

            <div class="cmd-message-body">
                <span class="cmd-label">MESSAGE</span>

                <div class="cmd-message-text">{{ $contactMessage->message }}</div>
            </div>

            <div class="cmd-message-footer">
                <span>
                    Received on
                    {{ $contactMessage->created_at->format('d M Y, h:i A') }}
                </span>
            </div>

        </div>

        <div class="cmd-sidebar">

            <div class="cmd-info-card">
                <h3>Sender Information</h3>

                <div class="cmd-info-item">
                    <span>Full Name</span>
                    <strong>{{ $contactMessage->name }}</strong>
                </div>

                <div class="cmd-info-item">
                    <span>Email Address</span>
                    <strong>{{ $contactMessage->email }}</strong>
                </div>

                <div class="cmd-info-item">
                    <span>Phone Number</span>
                    <strong>{{ $contactMessage->phone }}</strong>
                </div>

                <div class="cmd-info-item">
                    <span>Received Date</span>
                    <strong>{{ $contactMessage->created_at->format('d M Y') }}</strong>
                </div>
            </div>

            <div class="cmd-action-card">
                <h3>Quick Actions</h3>

                <a href="mailto:{{ $contactMessage->email }}"
                   class="cmd-reply-btn">
                    Reply via Email
                </a>

                <form action="{{ route('admin.contact-messages.destroy', $contactMessage) }}"
                      method="POST"
                      onsubmit="return confirm('Are you sure you want to permanently delete this message?');">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="cmd-delete-btn">
                        Delete Message
                    </button>
                </form>
            </div>

        </div>

    </div>

</div>

<style>
.cmd-page {
    padding: 12px 0 35px;
    color: #183153;
}

.cmd-topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 26px;
}

.cmd-eyebrow {
    display: block;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 2px;
    color: #4386bb;
    margin-bottom: 10px;
}

.cmd-topbar h1 {
    margin: 0 0 8px;
    font-size: 30px;
    font-weight: 700;
    color: #183153;
}

.cmd-topbar p {
    margin: 0;
    font-size: 14px;
    color: #7a8da5;
}

.cmd-back {
    display: inline-flex;
    align-items: center;
    padding: 11px 16px;
    background: #fff;
    border: 1px solid #dce9f5;
    border-radius: 11px;
    color: #28699e;
    text-decoration: none;
    font-weight: 600;
    font-size: 13px;
    white-space: nowrap;
}

.cmd-layout {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 290px;
    align-items: start;
    gap: 22px;
}

.cmd-main-card,
.cmd-info-card,
.cmd-action-card {
    background: #fff;
    border: 1px solid #e0ebf5;
    border-radius: 19px;
    box-shadow: 0 12px 35px rgba(38, 88, 142, .05);
}

.cmd-main-card {
    padding: 28px;
}

.cmd-message-header {
    display: flex;
    justify-content: space-between;
    gap: 15px;
    align-items: flex-start;
    margin-bottom: 27px;
}

.cmd-label {
    display: block;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.2px;
    color: #8a9caf;
    margin-bottom: 12px;
}

.cmd-message-header h2 {
    margin: 0;
    color: #1c4267;
    font-size: 23px;
    line-height: 1.4;
    overflow-wrap: anywhere;
}

.cmd-status {
    padding: 8px 13px;
    border-radius: 30px;
    background: #e9f7f0;
    color: #27805b;
    font-size: 11px;
    font-weight: 700;
}

.cmd-sender {
    display: flex;
    align-items: center;
    gap: 13px;
}

.cmd-avatar {
    display: grid;
    place-items: center;
    width: 47px;
    height: 47px;
    flex-shrink: 0;
    border-radius: 14px;
    background: #e7f3fc;
    color: #246aa6;
    font-weight: 700;
    font-size: 18px;
}

.cmd-sender strong,
.cmd-sender span {
    display: block;
}

.cmd-sender strong {
    color: #234767;
    font-size: 14px;
}

.cmd-sender span {
    margin-top: 5px;
    color: #8195a9;
    font-size: 12px;
    overflow-wrap: anywhere;
}

.cmd-divider {
    height: 1px;
    background: #e9eff6;
    margin: 28px 0;
}

.cmd-message-text {
    color: #45627e;
    font-size: 14px;
    line-height: 1.9;
    white-space: pre-wrap;
    overflow-wrap: anywhere;
    min-height: 145px;
}

.cmd-message-footer {
    margin-top: 35px;
    padding-top: 20px;
    border-top: 1px solid #e9eff6;
    font-size: 12px;
    color: #90a0b2;
}

.cmd-info-card,
.cmd-action-card {
    padding: 23px;
    margin-bottom: 19px;
}

.cmd-info-card h3,
.cmd-action-card h3 {
    color: #1c4267;
    font-size: 16px;
    margin: 0 0 22px;
}

.cmd-info-item {
    padding: 0 0 17px;
    margin-bottom: 17px;
    border-bottom: 1px solid #edf2f7;
}

.cmd-info-item:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.cmd-info-item span {
    display: block;
    font-size: 11px;
    color: #92a2b2;
    margin-bottom: 7px;
}

.cmd-info-item strong {
    display: block;
    color: #355677;
    font-size: 13px;
    font-weight: 600;
    overflow-wrap: anywhere;
}

.cmd-reply-btn,
.cmd-delete-btn {
    display: block;
    width: 100%;
    padding: 12px 15px;
    text-align: center;
    border-radius: 10px;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
    box-sizing: border-box;
}

.cmd-reply-btn {
    background: #246aa6;
    color: #fff;
    border: 1px solid #246aa6;
    margin-bottom: 11px;
}

.cmd-delete-btn {
    background: #fff1f1;
    color: #be4b54;
    border: 1px solid #ffdada;
}

.cmd-delete-btn:hover {
    background: #ffe3e5;
}

@media (max-width: 900px) {
    .cmd-layout {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 600px) {
    .cmd-topbar {
        flex-direction: column;
        align-items: flex-start;
    }

    .cmd-topbar h1 {
        font-size: 25px;
    }

    .cmd-main-card {
        padding: 20px;
    }

    .cmd-message-header h2 {
        font-size: 20px;
    }
}
</style>

@endsection
