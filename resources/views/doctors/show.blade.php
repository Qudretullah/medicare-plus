
@extends('layouts.app')

@section('title', $doctor->name . ' | Medicare+')

@section('content')

<!-- DOCTOR PROFILE HERO -->
<section class="doctor-profile-hero">
    <div class="container">

        <nav class="doctor-profile-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span>/</span>
            <a href="{{ route('doctors') }}">Doctors</a>
            <span>/</span>
            <span>{{ $doctor->name }}</span>
        </nav>

        <div class="doctor-profile-card">

            <div class="doctor-profile-photo">
                <img
                    src="{{ $doctor->image_path ? asset($doctor->image_path) : asset('images/doctor-1.jpg') }}"
                    alt="{{ $doctor->name }}"
                    loading="eager"
                >
            </div>

            <div class="doctor-profile-information">

                @if($doctor->specialization)
                    <span class="doctor-profile-specialization">
                        {{ $doctor->specialization }}
                    </span>
                @endif

                <h1>{{ $doctor->name }}</h1>

                @if($doctor->qualification)
                    <p class="doctor-profile-qualification">
                        {{ $doctor->qualification }}
                    </p>
                @endif

                <div class="doctor-profile-details">

                    @if($doctor->experience_years !== null)
                        <div class="doctor-profile-detail">
                            <span>Experience</span>
                            <strong>
                                {{ $doctor->experience_years }}+ Years
                            </strong>
                        </div>
                    @endif

                    <div class="doctor-profile-detail">
                        <span>Department</span>
                        <strong>
                            {{ $doctor->department ?: 'General Healthcare' }}
                        </strong>
                    </div>

                </div>

                @if($doctor->short_description)
                    <p class="doctor-profile-summary">
                        {{ $doctor->short_description }}
                    </p>
                @endif

                <a
                    href="{{ route('appointment.create', ['doctor' => $doctor->slug]) }}"
                    class="doctor-profile-book-btn"
                >
                    Book Appointment
                    <span aria-hidden="true">→</span>
                </a>

            </div>

        </div>

    </div>
</section>


<!-- PROFESSIONAL BIOGRAPHY -->
<section class="doctor-profile-about">
    <div class="container">

        <div class="doctor-profile-section-heading">
            <span class="section-label">
                Professional Profile
            </span>

            <h2>About {{ $doctor->name }}</h2>
        </div>

        <div class="doctor-profile-bio">

            @if($doctor->bio)
                <p>{!! nl2br(e($doctor->bio)) !!}</p>
            @elseif($doctor->short_description)
                <p>{!! nl2br(e($doctor->short_description)) !!}</p>
            @else
                <p>
                    Learn more about this doctor's professional
                    experience and healthcare services.
                </p>
            @endif

        </div>

    </div>
</section>


<!-- RELATED DOCTORS -->
@if($relatedDoctors->isNotEmpty())

<section class="doctor-profile-related">
    <div class="container">

        <div class="doctor-profile-section-heading">

            <span class="section-label">
                Our Specialists
            </span>

            <h2>Meet More of Our Doctors</h2>

        </div>

        <div class="doctors-list-grid">

            @foreach($relatedDoctors as $relatedDoctor)

                <article class="doctor-list-card">

                    <div class="doctor-list-image">

                        <a href="{{ route('doctors.show', $relatedDoctor->slug) }}">
                            <img
                                src="{{ $relatedDoctor->image_path ? asset($relatedDoctor->image_path) : asset('images/doctor-1.jpg') }}"
                                alt="{{ $relatedDoctor->name }}"
                                loading="lazy"
                            >
                        </a>

                    </div>

                    <div class="doctor-list-content">

                        @if($relatedDoctor->specialization)
                            <span class="doctor-list-speciality">
                                {{ $relatedDoctor->specialization }}
                            </span>
                        @endif

                        <h3>
                            <a href="{{ route('doctors.show', $relatedDoctor->slug) }}">
                                {{ $relatedDoctor->name }}
                            </a>
                        </h3>

                        @if($relatedDoctor->experience_years !== null)
                            <p class="doctor-list-experience">
                                {{ $relatedDoctor->experience_years }}+
                                Years Experience
                            </p>
                        @endif

                        @if($relatedDoctor->short_description)
                            <p>{{ $relatedDoctor->short_description }}</p>
                        @endif

                        <a
                            href="{{ route('doctors.show', $relatedDoctor->slug) }}"
                            class="doctor-list-profile-btn"
                        >
                            View Profile →
                        </a>

                        <a
                            href="{{ route('appointment.create', ['doctor' => $relatedDoctor->slug]) }}"
                            class="doctor-profile-book-btn"
                        >
                            Book Appointment
                            <span aria-hidden="true">→</span>
                        </a>

                    </div>

                </article>

            @endforeach

        </div>

    </div>
</section>

@endif

@endsection
