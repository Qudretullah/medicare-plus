
@php
    $editing = isset($doctor);
@endphp

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

<div class="doctor-admin-form-grid">

    <div class="doctor-admin-field">
        <label for="name">Doctor Name *</label>
        <input
            type="text"
            id="name"
            name="name"
            maxlength="255"
            value="{{ old('name', $doctor->name ?? '') }}"
            placeholder="Dr. Sarah Ahmed"
            required
        >
    </div>

    <div class="doctor-admin-field">
        <label for="specialization">Specialization *</label>
        <input
            type="text"
            id="specialization"
            name="specialization"
            maxlength="255"
            value="{{ old('specialization', $doctor->specialization ?? '') }}"
            placeholder="Cardiologist"
            required
        >
    </div>

    <div class="doctor-admin-field">
        <label for="department">Department</label>
        <input
            type="text"
            id="department"
            name="department"
            maxlength="255"
            value="{{ old('department', $doctor->department ?? '') }}"
            placeholder="Cardiology"
        >
    </div>

    <div class="doctor-admin-field">
        <label for="qualification">Qualification</label>
        <input
            type="text"
            id="qualification"
            name="qualification"
            maxlength="255"
            value="{{ old('qualification', $doctor->qualification ?? '') }}"
            placeholder="MBBS, FCPS"
        >
    </div>

    <div class="doctor-admin-field">
        <label for="experience_years">Experience (Years) *</label>
        <input
            type="number"
            id="experience_years"
            name="experience_years"
            min="0"
            max="100"
            value="{{ old('experience_years', $doctor->experience_years ?? 0) }}"
            required
        >
    </div>

    <div class="doctor-admin-field">
        <label for="sort_order">Display Order *</label>
        <input
            type="number"
            id="sort_order"
            name="sort_order"
            min="0"
            max="999999"
            value="{{ old('sort_order', $doctor->sort_order ?? 0) }}"
            required
        >
    </div>

    <div class="doctor-admin-field full">
        <label for="short_description">Short Description</label>
        <textarea
            id="short_description"
            name="short_description"
            rows="3"
            maxlength="2000"
            placeholder="Brief introduction for the doctor card..."
        >{{ old('short_description', $doctor->short_description ?? '') }}</textarea>
    </div>

    <div class="doctor-admin-field full">
        <label for="bio">Professional Biography</label>
        <textarea
            id="bio"
            name="bio"
            rows="6"
            maxlength="10000"
            placeholder="Detailed biography for the individual doctor profile..."
        >{{ old('bio', $doctor->bio ?? '') }}</textarea>
    </div>

    <div class="doctor-admin-field full">

        <label for="image">Doctor Profile Image</label>

        @if($editing && $doctor->image_path)
            <div class="doctor-admin-image-preview">
                <img
                    src="{{ asset($doctor->image_path) }}"
                    alt="{{ $doctor->name }}"
                >
                <span>Current Photo</span>
            </div>
        @endif

        <input
            type="file"
            id="image"
            name="image"
            accept=".jpg,.jpeg,.png,.webp"
        >

        <small>
            JPG, PNG or WEBP. Maximum 2 MB.
            @if($editing)
                Leave empty to keep the existing photo.
            @endif
        </small>

    </div>

    <div class="doctor-admin-field full">
        <label class="doctor-admin-checkbox">
            <input
                type="checkbox"
                name="is_active"
                value="1"
                {{ old('is_active', $doctor->is_active ?? true) ? 'checked' : '' }}
            >
            <span>Active — Show doctor on public website</span>
        </label>
    </div>

</div>

<div class="doctor-admin-form-actions">
    <button type="submit" class="doctor-admin-primary-btn">
        {{ $editing ? 'Save Doctor Changes' : 'Create Doctor' }}
    </button>

    <a href="{{ route('admin.doctors.index') }}"
       class="doctor-admin-cancel-btn">
        Cancel
    </a>
</div>
