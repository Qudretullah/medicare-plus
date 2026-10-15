
@extends('admin.layouts.app')

@section('title', 'Navbar & Footer Settings')

@section('page-title', 'Navbar & Footer')

@section('page-description', 'Manage your website branding, contact details and footer content.')

@push('styles')
<style>
/* ==========================================
   MEDICARE+ SITE SETTINGS — SAPPHIRE GLASS
========================================== */

.ss-page {
    --ss-bg: #ffffff;
    --ss-text: #183457;
    --ss-muted: #758aa3;
    --ss-border: #dce8f5;
    --ss-input: #f8fbff;
    --ss-accent: #285fa9;

    display: flex;
    flex-direction: column;
    gap: 24px;
    width: 100%;
}

.ss-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
}

.ss-heading h2 {
    margin: 7px 0 6px;
    font-size: 23px;
    color: var(--ss-text);
}

.ss-heading p {
    margin: 0;
    font-size: 13px;
    color: var(--ss-muted);
    line-height: 1.7;
}

.ss-eyebrow {
    display: inline-block;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 1.4px;
    color: #5285bf;
}

.ss-site-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 11px 16px;
    background: #e8f2ff;
    border: 1px solid #d4e5fa;
    color: #245b99;
    border-radius: 11px;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
}

.ss-card {
    background: var(--ss-bg);
    border: 1px solid var(--ss-border);
    border-radius: 20px;
    padding: 25px;
    box-shadow: 0 10px 32px rgba(31, 75, 130, .05);
}

.ss-card-head {
    display: flex;
    gap: 13px;
    align-items: flex-start;
    margin-bottom: 24px;
    padding-bottom: 20px;
    border-bottom: 1px solid var(--ss-border);
}

.ss-card-icon {
    display: grid;
    place-items: center;
    width: 43px;
    height: 43px;
    flex-shrink: 0;
    border-radius: 13px;
    background: #e8f2ff;
    color: #285fa9;
    font-size: 21px;
}

.ss-card-head h3 {
    margin: 0 0 6px;
    font-size: 17px;
    color: var(--ss-text);
}

.ss-card-head p {
    margin: 0;
    color: var(--ss-muted);
    font-size: 12px;
    line-height: 1.7;
}

.ss-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 20px;
}

.ss-field {
    display: flex;
    flex-direction: column;
    gap: 9px;
    min-width: 0;
}

.ss-field-full {
    grid-column: 1 / -1;
}

.ss-field label {
    font-size: 12px;
    font-weight: 700;
    color: var(--ss-text);
}

.ss-field input:not([type="checkbox"]),
.ss-field textarea {
    width: 100%;
    padding: 12px 14px;
    background: var(--ss-input);
    border: 1px solid var(--ss-border);
    border-radius: 11px;
    color: var(--ss-text);
    font: inherit;
    font-size: 13px;
    outline: none;
    transition: border-color .2s, box-shadow .2s;
}

.ss-field textarea {
    min-height: 115px;
    resize: vertical;
    line-height: 1.7;
}

.ss-field input:focus,
.ss-field textarea:focus {
    border-color: #6499d6;
    box-shadow: 0 0 0 3px rgba(90, 146, 213, .13);
}

.ss-field small {
    font-size: 11px;
    color: var(--ss-muted);
    line-height: 1.6;
}

.ss-logo-preview {
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
    padding: 18px;
    border-radius: 13px;
    background: var(--ss-input);
    border: 1px dashed var(--ss-border);
}

.ss-logo-preview img {
    max-width: 180px;
    max-height: 90px;
    object-fit: contain;
}

.ss-logo-placeholder {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 60px;
    padding: 14px 20px;
    border-radius: 12px;
    background: #e4effc;
    color: #255b99;
    font-weight: 800;
    font-size: 18px;
}

.ss-checkbox {
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    color: var(--ss-text);
    font-size: 12px;
    font-weight: 600;
}

.ss-checkbox input {
    width: 17px;
    height: 17px;
    accent-color: #2866b0;
}

.ss-errors {
    padding: 17px 20px;
    border-radius: 13px;
    background: #fff0f2;
    border: 1px solid #f4cad1;
    color: #a33d54;
    font-size: 13px;
}

.ss-errors ul {
    margin: 8px 0 0;
    padding-left: 20px;
}

.ss-errors li {
    margin: 5px 0;
}

.ss-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
    padding: 22px 25px;
    background: var(--ss-bg);
    border: 1px solid var(--ss-border);
    border-radius: 18px;
}

.ss-footer p {
    margin: 0;
    color: var(--ss-muted);
    font-size: 12px;
}

.ss-save {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 13px 25px;
    border: 0;
    border-radius: 11px;
    background: linear-gradient(125deg, #356fbd, #183f83);
    color: #fff;
    font: inherit;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: transform .2s, box-shadow .2s;
}

.ss-save:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 22px rgba(38, 84, 155, .22);
}

.ss-save:focus-visible,
.ss-site-link:focus-visible {
    outline: 3px solid #8dbaf2;
    outline-offset: 3px;
}

/* DARK MODE */

html[data-admin-theme="dark"] .ss-page {
    --ss-bg: #16253d;
    --ss-text: #edf5ff;
    --ss-muted: #a8bdd7;
    --ss-border: #344762;
    --ss-input: #101d32;
}

html[data-admin-theme="dark"] .ss-site-link {
    background: #294361;
    border-color: #456382;
    color: #d5e9ff;
}

html[data-admin-theme="dark"] .ss-card-icon {
    background: #294361;
    color: #b9d9ff;
}

html[data-admin-theme="dark"] .ss-logo-placeholder {
    background: #294361;
    color: #d5e9ff;
}

html[data-admin-theme="dark"] .ss-errors {
    background: #4a2b3b;
    border-color: #774458;
    color: #ffc0cd;
}

/* RESPONSIVE */

@media (max-width: 720px) {
    .ss-grid {
        grid-template-columns: 1fr;
    }

    .ss-field-full {
        grid-column: auto;
    }

    .ss-card {
        padding: 20px;
    }

    .ss-heading h2 {
        font-size: 21px;
    }

    .ss-footer {
        padding: 20px;
    }

    .ss-save {
        width: 100%;
    }
}
</style>
@endpush

@section('content')

<div class="ss-page">

    <div class="ss-heading">
        <div>
            <span class="ss-eyebrow">WEBSITE BRANDING</span>
            <h2>Navbar & Footer Settings</h2>
            <p>
                Manage your website identity, clinic information,
                footer services and social media links.
            </p>
        </div>

        <a href="{{ route('home') }}"
           target="_blank"
           rel="noopener noreferrer"
           class="ss-site-link">
            Preview Website ↗
        </a>
    </div>

    @if($errors->any())
        <div class="ss-errors" role="alert">
            <strong>Please correct the following errors:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        method="POST"
        action="{{ route('admin.site-settings.update') }}"
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')

        {{-- BRAND SETTINGS --}}

        <section class="ss-card" style="margin-bottom:22px;">

            <div class="ss-card-head">
                <span class="ss-card-icon" aria-hidden="true">✦</span>

                <div>
                    <h3>Website Branding</h3>
                    <p>Manage the name and logo displayed on your website.</p>
                </div>
            </div>

            <div class="ss-grid">

                <div class="ss-field ss-field-full">
                    <label for="site_name">Website Name *</label>

                    <input
                        type="text"
                        id="site_name"
                        name="site_name"
                        value="{{ old('site_name', $settings['site_name']) }}"
                        maxlength="100"
                        required
                    >
                </div>

                <div class="ss-field ss-field-full">
                    <label for="site_logo">Website Logo</label>

                    <div class="ss-logo-preview">

                        @if(!empty($settings['site_logo']))
                            <img
                                src="{{ asset('storage/' . $settings['site_logo']) }}"
                                alt="Current website logo"
                            >
                        @else
                            <span class="ss-logo-placeholder">
                                {{ $settings['site_name'] }}
                            </span>
                        @endif

                    </div>

                    <input
                        type="file"
                        id="site_logo"
                        name="site_logo"
                        accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                    >

                    <small>
                        JPG, PNG or WebP. Maximum image size: 2 MB.
                        Leave empty to keep the existing logo.
                    </small>

                    @if(!empty($settings['site_logo']))
                        <label class="ss-checkbox">
                            <input
                                type="checkbox"
                                name="remove_logo"
                                value="1"
                                {{ old('remove_logo') ? 'checked' : '' }}
                            >
                            Remove existing logo
                        </label>
                    @endif
                </div>

            </div>
        </section>


        {{-- FOOTER CONTENT --}}

        <section class="ss-card" style="margin-bottom:22px;">

            <div class="ss-card-head">
                <span class="ss-card-icon" aria-hidden="true">▤</span>

                <div>
                    <h3>Footer Content</h3>
                    <p>Control the description, services and copyright information.</p>
                </div>
            </div>

            <div class="ss-grid">

                <div class="ss-field ss-field-full">
                    <label for="footer_description">Footer Description *</label>

                    <textarea
                        id="footer_description"
                        name="footer_description"
                        maxlength="1000"
                        required
                    >{{ old('footer_description', $settings['footer_description']) }}</textarea>
                </div>

                <div class="ss-field ss-field-full">
                    <label for="footer_services">Footer Services</label>

                    <textarea
                        id="footer_services"
                        name="footer_services"
                        maxlength="2000"
                        placeholder="One service per line"
                    >{{ old('footer_services', $settings['footer_services']) }}</textarea>

                    <small>
                        Enter one service per line. These will appear
                        under the Our Services footer column.
                    </small>
                </div>

                <div class="ss-field ss-field-full">
                    <label for="copyright_text">Copyright Text *</label>

                    <input
                        type="text"
                        id="copyright_text"
                        name="copyright_text"
                        value="{{ old('copyright_text', $settings['copyright_text']) }}"
                        maxlength="200"
                        required
                    >

                    <small>
                        The website year and name will be displayed automatically.
                    </small>
                </div>

            </div>
        </section>


        {{-- CONTACT DETAILS --}}

        <section class="ss-card" style="margin-bottom:22px;">

            <div class="ss-card-head">
                <span class="ss-card-icon" aria-hidden="true">✉</span>

                <div>
                    <h3>Clinic Contact Information</h3>
                    <p>These details will appear in your public website footer.</p>
                </div>
            </div>

            <div class="ss-grid">

                <div class="ss-field">
                    <label for="clinic_phone">Clinic Phone *</label>

                    <input
                        type="text"
                        id="clinic_phone"
                        name="clinic_phone"
                        value="{{ old('clinic_phone', $settings['clinic_phone']) }}"
                        maxlength="40"
                        required
                    >
                </div>

                <div class="ss-field">
                    <label for="clinic_email">Clinic Email *</label>

                    <input
                        type="email"
                        id="clinic_email"
                        name="clinic_email"
                        value="{{ old('clinic_email', $settings['clinic_email']) }}"
                        maxlength="255"
                        required
                    >
                </div>

                <div class="ss-field">
                    <label for="clinic_address_line_1">Address Line 1 *</label>

                    <input
                        type="text"
                        id="clinic_address_line_1"
                        name="clinic_address_line_1"
                        value="{{ old('clinic_address_line_1', $settings['clinic_address_line_1']) }}"
                        maxlength="200"
                        required
                    >
                </div>

                <div class="ss-field">
                    <label for="clinic_address_line_2">Address Line 2</label>

                    <input
                        type="text"
                        id="clinic_address_line_2"
                        name="clinic_address_line_2"
                        value="{{ old('clinic_address_line_2', $settings['clinic_address_line_2']) }}"
                        maxlength="200"
                    >
                </div>

            </div>
        </section>


        {{-- SOCIAL MEDIA --}}

        <section class="ss-card" style="margin-bottom:22px;">

            <div class="ss-card-head">
                <span class="ss-card-icon" aria-hidden="true">↗</span>

                <div>
                    <h3>Social Media Links</h3>
                    <p>Optional links to your clinic's official social profiles.</p>
                </div>
            </div>

            <div class="ss-grid">

                <div class="ss-field">
                    <label for="facebook_url">Facebook URL</label>

                    <input
                        type="url"
                        id="facebook_url"
                        name="facebook_url"
                        value="{{ old('facebook_url', $settings['facebook_url']) }}"
                        placeholder="https://facebook.com/..."
                        maxlength="500"
                    >
                </div>

                <div class="ss-field">
                    <label for="instagram_url">Instagram URL</label>

                    <input
                        type="url"
                        id="instagram_url"
                        name="instagram_url"
                        value="{{ old('instagram_url', $settings['instagram_url']) }}"
                        placeholder="https://instagram.com/..."
                        maxlength="500"
                    >
                </div>

                <div class="ss-field">
                    <label for="linkedin_url">LinkedIn URL</label>

                    <input
                        type="url"
                        id="linkedin_url"
                        name="linkedin_url"
                        value="{{ old('linkedin_url', $settings['linkedin_url']) }}"
                        placeholder="https://linkedin.com/..."
                        maxlength="500"
                    >
                </div>

                <div class="ss-field">
                    <label for="whatsapp_number">WhatsApp Number</label>

                    <input
                        type="text"
                        id="whatsapp_number"
                        name="whatsapp_number"
                        value="{{ old('whatsapp_number', $settings['whatsapp_number']) }}"
                        placeholder="+923001234567"
                        maxlength="16"
                    >

                    <small>
                        Use country code without spaces or dashes.
                        Example: +923001234567
                    </small>
                </div>

            </div>
        </section>


        {{-- SAVE ACTION --}}

        <div class="ss-footer">
            <p>
                Changes will be saved to the website settings database.
            </p>

            <button type="submit" class="ss-save">
                Save Website Settings →
            </button>
        </div>

    </form>

</div>

@endsection
