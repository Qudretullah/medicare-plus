
@extends('admin.layouts.app')

@section('title', 'Add Service')
@section('page-title', 'Add Service')
@section('page-description', 'Create a new healthcare service for Medicare+.')

@section('content')

<div class="doctor-admin-page">

    <div class="doctor-admin-intro">
        <div>
            <h2>Create Medical Service</h2>
            <p>Add a new healthcare service and configure its details.</p>
        </div>

        <a href="{{ route('admin.services.index') }}"
           class="doctor-admin-cancel-btn">
            ← Back to Services
        </a>
    </div>

    @if($errors->any())
        <div class="doctor-admin-errors" role="alert">
            <strong>Please correct the following errors:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="doctor-admin-panel doctor-admin-form-panel">

        <form action="{{ route('admin.services.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="doctor-admin-form-grid">

                <div class="doctor-admin-field">
                    <label for="name">Service Name *</label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        maxlength="150"
                        required
                        placeholder="e.g. General Checkup"
                    >
                </div>

                <div class="doctor-admin-field">
                    <label for="icon">Service Icon</label>
                    <input
                        id="icon"
                        type="text"
                        name="icon"
                        value="{{ old('icon') }}"
                        maxlength="30"
                        placeholder="e.g. 🩺"
                    >
                    <small>Enter a medical emoji or symbol.</small>
                </div>

                <div class="doctor-admin-field full">
                    <label for="short_description">Short Description</label>
                    <textarea
                        id="short_description"
                        name="short_description"
                        rows="3"
                        maxlength="500"
                        placeholder="Short description shown on service cards."
                    >{{ old('short_description') }}</textarea>
                </div>

                <div class="doctor-admin-field full">
                    <label for="description">Full Description</label>
                    <textarea
                        id="description"
                        name="description"
                        rows="6"
                        maxlength="10000"
                        placeholder="Detailed information about this service."
                    >{{ old('description') }}</textarea>
                </div>

                <div class="doctor-admin-field">
                    <label for="sort_order">Display Order</label>
                    <input
                        id="sort_order"
                        type="number"
                        name="sort_order"
                        value="{{ old('sort_order', 0) }}"
                        min="0"
                        max="9999"
                    >
                    <small>Lower numbers appear first.</small>
                </div>

                <div class="doctor-admin-field">
                    <label for="image">Service Image</label>
                    <input
                        id="image"
                        type="file"
                        name="image"
                        accept=".jpg,.jpeg,.png,.webp"
                    >
                    <small>JPG, PNG or WebP. Maximum size: 2 MB.</small>
                </div>

                <div class="doctor-admin-field full">
                    <label class="doctor-admin-checkbox">
                        <input
                            type="checkbox"
                            name="is_active"
                            value="1"
                            {{ old('is_active', '1') == '1' ? 'checked' : '' }}
                        >
                        <span>Active — Show service on website</span>
                    </label>
                </div>

            </div>

            <div class="doctor-admin-form-actions">

                <button type="submit" class="doctor-admin-primary-btn">
                    + Create Service
                </button>

                <a href="{{ route('admin.services.index') }}"
                   class="doctor-admin-cancel-btn">
                    Cancel
                </a>

            </div>

        </form>

    </div>

</div>

@endsection
