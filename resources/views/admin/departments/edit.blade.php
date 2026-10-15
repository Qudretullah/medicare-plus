
@extends('admin.layouts.app')

@section('title', 'Edit Department')
@section('page-title', 'Edit Department')
@section('page-description', 'Update department details and website visibility.')

@section('content')

<div class="doctor-admin-page">

    <div class="doctor-admin-intro">
        <div>
            <h2>Edit {{ $department->name }}</h2>
            <p>Manage department information, image and visibility.</p>
        </div>

        <a href="{{ route('admin.departments.index') }}"
           class="doctor-admin-cancel-btn">
            ← Back to Departments
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

        <form action="{{ route('admin.departments.update', $department) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="doctor-admin-form-grid">

                <div class="doctor-admin-field">
                    <label for="name">Department Name *</label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name', $department->name) }}"
                        maxlength="150"
                        required
                    >
                </div>

                <div class="doctor-admin-field">
                    <label for="icon">Department Icon</label>
                    <input
                        id="icon"
                        type="text"
                        name="icon"
                        value="{{ old('icon', $department->icon) }}"
                        maxlength="30"
                        placeholder="e.g. ❤"
                    >
                </div>

                <div class="doctor-admin-field full">
                    <label for="short_description">Short Description</label>
                    <textarea
                        id="short_description"
                        name="short_description"
                        rows="3"
                        maxlength="500"
                    >{{ old('short_description', $department->short_description) }}</textarea>
                </div>

                <div class="doctor-admin-field full">
                    <label for="description">Full Description</label>
                    <textarea
                        id="description"
                        name="description"
                        rows="6"
                        maxlength="10000"
                    >{{ old('description', $department->description) }}</textarea>
                </div>

                <div class="doctor-admin-field">
                    <label for="sort_order">Display Order</label>
                    <input
                        id="sort_order"
                        type="number"
                        name="sort_order"
                        value="{{ old('sort_order', $department->sort_order) }}"
                        min="0"
                        max="9999"
                    >
                </div>

                <div class="doctor-admin-field">
                    <label for="image">Replace Department Image</label>
                    <input
                        id="image"
                        type="file"
                        name="image"
                        accept=".jpg,.jpeg,.png,.webp"
                    >
                    <small>Leave empty to keep the current image.</small>

                    @if($department->image_path)
                        <div class="doctor-admin-image-preview">
                            <img
                                src="{{ asset('storage/' . $department->image_path) }}"
                                alt="{{ $department->name }}"
                            >
                            <span>Current department image</span>
                        </div>
                    @endif
                </div>

                <div class="doctor-admin-field full">
                    <label class="doctor-admin-checkbox">
                        <input
                            type="checkbox"
                            name="is_active"
                            value="1"
                            {{ old('is_active', $department->is_active ? '1' : '0') == '1' ? 'checked' : '' }}
                        >
                        <span>Active — Show department on website</span>
                    </label>
                </div>

            </div>

            <div class="doctor-admin-form-actions">

                <button type="submit" class="doctor-admin-primary-btn">
                    Save Changes
                </button>

                <a href="{{ route('admin.departments.index') }}"
                   class="doctor-admin-cancel-btn">
                    Cancel
                </a>

            </div>

        </form>

    </div>

</div>

@endsection
