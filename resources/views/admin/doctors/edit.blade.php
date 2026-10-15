
@extends('admin.layouts.app')

@section('title', 'Edit Doctor')
@section('page-title', 'Edit Doctor Profile')

@section('content')

<div class="doctor-admin-page">

    <div class="doctor-admin-intro">
        <div>
            <h2>Edit {{ $doctor->name }}</h2>
            <p>
                Update professional information and
                doctor profile settings.
            </p>
        </div>

        @if($doctor->is_active)
            <a
                href="{{ route('doctors.show', $doctor->slug) }}"
                target="_blank"
                rel="noopener noreferrer"
                class="doctor-admin-cancel-btn"
            >
                View Public Profile
            </a>
        @endif
    </div>

    <div class="doctor-admin-panel doctor-admin-form-panel">

        <form
            method="POST"
            action="{{ route('admin.doctors.update', $doctor) }}"
            enctype="multipart/form-data"
        >
            @csrf
            @method('PUT')

            @include('admin.doctors._form')

        </form>

    </div>

</div>

@endsection
