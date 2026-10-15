
@extends('admin.layouts.app')

@section('title', 'Add Doctor')
@section('page-title', 'Add New Doctor')

@section('content')

<div class="doctor-admin-page">

    <div class="doctor-admin-intro">
        <div>
            <h2>Create Doctor Profile</h2>
            <p>
                Enter professional information to add a
                doctor to the Medicare+ website.
            </p>
        </div>
    </div>

    <div class="doctor-admin-panel doctor-admin-form-panel">

        <form
            method="POST"
            action="{{ route('admin.doctors.store') }}"
            enctype="multipart/form-data"
        >
            @csrf

            @include('admin.doctors._form')

        </form>

    </div>

</div>

@endsection
