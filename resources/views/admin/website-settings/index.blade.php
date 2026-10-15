
@extends('admin.layouts.app')

@section('title', 'Website Settings')

@section('page-title', 'Website Settings')

@section('page-description', 'Manage online booking preferences and review system configuration.')

@push('styles')
<style>
/* ==========================================
   MEDICARE+ WEBSITE SETTINGS
   SAPPHIRE GLASS LIGHT / DARK THEME
========================================== */

.ws-page {
    --ws-surface: #ffffff;
    --ws-border: #dce8f5;
    --ws-heading: #183457;
    --ws-text: #46627f;
    --ws-muted: #758aa3;
    --ws-input: #f7fbff;

    display: flex;
    flex-direction: column;
    gap: 22px;
    width: 100%;
}

.ws-intro {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    flex-wrap: wrap;
}

.ws-eyebrow {
    display: block;
    margin-bottom: 9px;
    color: #397aaf;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 1.6px;
}

.ws-intro h2 {
    margin: 0 0 8px;
    color: var(--ws-heading);
    font-size: 23px;
    font-weight: 700;
}

.ws-intro p {
    margin: 0;
    color: var(--ws-muted);
    font-size: 13px;
    line-height: 1.7;
}

.ws-card {
    min-width: 0;
    padding: 25px;
    background: var(--ws-surface);
    border: 1px solid var(--ws-border);
    border-radius: 20px;
    box-shadow: 0 12px 34px rgba(25, 66, 117, .05);
}

.ws-card-header {
    display: flex;
    align-items: center;
    gap: 13px;
    margin-bottom: 24px;
    padding-bottom: 20px;
    border-bottom: 1px solid var(--ws-border);
}

.ws-card-icon {
    display: grid;
    place-items: center;
    flex-shrink: 0;
    width: 43px;
    height: 43px;
    border-radius: 13px;
    background: #e7f2ff;
    color: #2863a8;
    font-size: 21px;
}

.ws-card-header h3 {
    margin: 0 0 6px;
    color: var(--ws-heading);
    font-size: 17px;
}

.ws-card-header p {
    margin: 0;
    color: var(--ws-muted);
    font-size: 12px;
    line-height: 1.7;
}

.ws-setting-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 18px;
    padding: 18px;
    background: var(--ws-input);
    border: 1px solid var(--ws-border);
    border-radius: 14px;
}

.ws-setting-info {
    min-width: 0;
}

.ws-setting-info strong {
    display: block;
    margin-bottom: 6px;
    color: var(--ws-heading);
    font-size: 14px;
}

.ws-setting-info p {
    margin: 0;
    color: var(--ws-muted);
    font-size: 12px;
    line-height: 1.7;
}

.ws-switch {
    display: inline-flex;
    position: relative;
    align-items: center;
    flex-shrink: 0;
    cursor: pointer;
}

.ws-switch input {
    position: absolute;
    width: 1px;
    height: 1px;
    opacity: 0;
}

.ws-switch-track {
    display: block;
    width: 50px;
    height: 28px;
    border-radius: 99px;
    background: #a9b9ca;
    transition: background .2s ease;
}

.ws-switch-track::after {
    content: "";
    position: absolute;
    left: 4px;
    top: 4px;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #ffffff;
    box-shadow: 0 2px 5px rgba(0,0,0,.15);
    transition: transform .2s ease;
}

.ws-switch input:checked + .ws-switch-track {
    background: #2d69b5;
}

.ws-switch input:checked + .ws-switch-track::after {
    transform: translateX(22px);
}

.ws-switch input:focus-visible + .ws-switch-track {
    outline: 3px solid #8bbdff;
    outline-offset: 3px;
}

.ws-field {
    display: flex;
    flex-direction: column;
    gap: 9px;
    margin-top: 22px;
}

.ws-field label {
    color: var(--ws-heading);
    font-size: 13px;
    font-weight: 700;
}

.ws-field textarea {
    width: 100%;
    min-height: 105px;
    padding: 13px 15px;
    border: 1px solid var(--ws-border);
    border-radius: 12px;
    background: var(--ws-input);
    color: var(--ws-heading);
    font: inherit;
    font-size: 13px;
    line-height: 1.7;
    resize: vertical;
    outline: none;
}

.ws-field textarea:focus {
    border-color: #70a4df;
    box-shadow: 0 0 0 3px rgba(112,164,223,.13);
}

.ws-field small {
    color: var(--ws-muted);
    font-size: 11px;
    line-height: 1.6;
}

.ws-actions {
    display: flex;
    justify-content: flex-end;
    margin-top: 22px;
}

.ws-save {
    padding: 13px 23px;
    border: 0;
    border-radius: 11px;
    background: linear-gradient(125deg, #356fbd, #183f83);
    color: #ffffff;
    font: inherit;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
}

.ws-save:hover {
    filter: brightness(1.1);
}

.ws-save:focus-visible {
    outline: 3px solid #8bbdff;
    outline-offset: 3px;
}

.ws-note {
    margin-top: 15px;
    padding: 13px 15px;
    border-radius: 11px;
    background: #edf5ff;
    border: 1px solid #d5e5f8;
    color: #476789;
    font-size: 12px;
    line-height: 1.7;
}

.ws-system-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 14px;
}

.ws-system-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    padding: 16px;
    background: var(--ws-input);
    border: 1px solid var(--ws-border);
    border-radius: 12px;
}

.ws-system-item span {
    color: var(--ws-muted);
    font-size: 12px;
}

.ws-system-item strong {
    color: var(--ws-heading);
    font-size: 12px;
    text-align: right;
    overflow-wrap: anywhere;
}

.ws-badge {
    display: inline-flex;
    align-items: center;
    padding: 6px 10px;
    border-radius: 25px;
    font-size: 11px;
    font-weight: 700;
}

.ws-badge-ok {
    background: #e1f4eb;
    color: #25785b;
}

.ws-badge-warning {
    background: #fff1dd;
    color: #98631a;
}

.ws-errors {
    padding: 16px 19px;
    border-radius: 12px;
    border: 1px solid #f2cbd3;
    background: #fff0f3;
    color: #a13f55;
    font-size: 13px;
}

.ws-errors ul {
    margin: 8px 0 0;
    padding-left: 20px;
}

/* DARK MODE */

html[data-admin-theme="dark"] .ws-page {
    --ws-surface: #16253d;
    --ws-border: #344762;
    --ws-heading: #edf5ff;
    --ws-text: #bed0e6;
    --ws-muted: #aabdd5;
    --ws-input: #101d32;
}

html[data-admin-theme="dark"] .ws-card-icon {
    background: #294361;
    color: #bfdbff;
}

html[data-admin-theme="dark"] .ws-eyebrow {
    color: #95c4ff;
}

html[data-admin-theme="dark"] .ws-note {
    background: #203551;
    border-color: #405b7c;
    color: #b7d1ee;
}

html[data-admin-theme="dark"] .ws-badge-ok {
    background: #1c453b;
    color: #9de8c9;
}

html[data-admin-theme="dark"] .ws-badge-warning {
    background: #4b3b25;
    color: #f4d19a;
}

html[data-admin-theme="dark"] .ws-errors {
    background: #4b2c3a;
    border-color: #784658;
    color: #ffc0ce;
}

/* RESPONSIVE */

@media (max-width: 750px) {
    .ws-system-grid {
        grid-template-columns: 1fr;
    }

    .ws-card {
        padding: 20px;
    }
}

@media (max-width: 500px) {
    .ws-setting-row {
        align-items: flex-start;
    }

    .ws-system-item {
        flex-wrap: wrap;
    }

    .ws-actions,
    .ws-save {
        width: 100%;
    }
}
</style>
@endpush

@section('content')

<div class="ws-page">

    <div class="ws-intro">
        <div>
            <span class="ws-eyebrow">CONTROL CENTER</span>
            <h2>Website Configuration</h2>
            <p>Manage appointment preferences and review your system status.</p>
        </div>
    </div>

    @if($errors->any())
        <div class="ws-errors" role="alert">
            <strong>Please correct the following errors:</strong>

            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- APPOINTMENT SETTINGS --}}

    <form method="POST"
          action="{{ route('admin.website-settings.update') }}">

        @csrf
        @method('PUT')

        <section class="ws-card">

            <div class="ws-card-header">
                <span class="ws-card-icon" aria-hidden="true">◷</span>

                <div>
                    <h3>Appointment Booking</h3>
                    <p>Configure online appointment booking preferences.</p>
                </div>
            </div>

            <div class="ws-setting-row">

                <div class="ws-setting-info">
                    <strong>Enable Online Appointments</strong>

                    <p>
                        Allow patients to submit appointment requests
                        from your website.
                    </p>
                </div>

                <label class="ws-switch"
                       for="appointment_booking_enabled">

                    <input type="hidden"
                           name="appointment_booking_enabled"
                           value="0">

                    <input
                        type="checkbox"
                        id="appointment_booking_enabled"
                        name="appointment_booking_enabled"
                        value="1"
                        {{ old(
                            'appointment_booking_enabled',
                            $settings['appointment_booking_enabled']
                        ) == '1' ? 'checked' : '' }}
                    >

                    <span class="ws-switch-track" aria-hidden="true"></span>
                </label>

            </div>

            <div class="ws-field">

                <label for="appointment_notice">
                    Appointment Notice
                </label>

                <textarea
                    id="appointment_notice"
                    name="appointment_notice"
                    maxlength="500"
                    placeholder="Enter an optional message for patients..."
                >{{ old('appointment_notice', $settings['appointment_notice']) }}</textarea>

                <small>
                    Maximum 500 characters. This message will be shown
                    on the appointment page after public integration.
                </small>

            </div>

            <div class="ws-note">
                <strong>Important:</strong>
                Saving these settings currently stores preferences
                in the database. We will connect them to the public
                booking controller in the next step.
                Until then, existing bookings continue to work normally.
            </div>

            <div class="ws-actions">
                <button type="submit" class="ws-save">
                    Save Website Settings →
                </button>
            </div>

        </section>

    </form>

    {{-- SYSTEM STATUS --}}

    <section class="ws-card">

        <div class="ws-card-header">
            <span class="ws-card-icon" aria-hidden="true">⚙</span>

            <div>
                <h3>System Information</h3>
                <p>Read-only technical details of your Medicare+ installation.</p>
            </div>
        </div>

        <div class="ws-system-grid">

            <div class="ws-system-item">
                <span>PHP Version</span>
                <strong>{{ $system['php_version'] }}</strong>
            </div>

            <div class="ws-system-item">
                <span>Laravel Version</span>
                <strong>{{ $system['laravel_version'] }}</strong>
            </div>

            <div class="ws-system-item">
                <span>Application Environment</span>
                <strong>{{ ucfirst($system['app_environment']) }}</strong>
            </div>

            <div class="ws-system-item">
                <span>Debug Mode</span>

                @if($system['debug_enabled'])
                    <span class="ws-badge ws-badge-warning">
                        Enabled
                    </span>
                @else
                    <span class="ws-badge ws-badge-ok">
                        Disabled
                    </span>
                @endif
            </div>

            <div class="ws-system-item">
                <span>Mail Sender Config</span>

                <span class="ws-badge {{ $system['mail_configured'] ? 'ws-badge-ok' : 'ws-badge-warning' }}">
                    {{ $system['mail_configured'] ? 'Configured' : 'Missing' }}
                </span>
            </div>

            <div class="ws-system-item">
                <span>Contact Recipient Config</span>

                <span class="ws-badge {{ $system['contact_recipient_configured'] ? 'ws-badge-ok' : 'ws-badge-warning' }}">
                    {{ $system['contact_recipient_configured'] ? 'Configured' : 'Missing' }}
                </span>
            </div>

        </div>

        <div class="ws-note">
            Email configuration status only confirms that settings
            are present. Actual email delivery depends on your
            configured mail server and queue worker.
        </div>

    </section>

</div>

@endsection
