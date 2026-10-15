
@extends('layouts.app')

@section('title', $department->name . ' | Medicare+')

@section('content')

<!-- DEPARTMENT HERO -->
<section class="department-detail-hero">

    <div class="container">

        <!-- BREADCRUMB -->
        <nav class="department-detail-breadcrumb" aria-label="Breadcrumb">

            <a href="{{ route('home') }}">Home</a>

            <span>/</span>

            <a href="{{ route('departments') }}">Departments</a>

            <span>/</span>

            <span>{{ $department->name }}</span>

        </nav>

        <div class="department-detail-hero-grid">

            <div class="department-detail-hero-content">

                <span class="section-label">
                    Medicare+ Medical Departments
                </span>

                <div class="department-detail-icon">
                    {{ $department->icon ?: '✚' }}
                </div>

                <h1>{{ $department->name }}</h1>

                @if($department->short_description)
                    <p>{{ $department->short_description }}</p>
                @endif

                <div class="department-detail-hero-actions">

                    <a href="#department-doctors"
                       class="department-detail-primary-btn">
                        Meet Our Specialists
                        <span aria-hidden="true">→</span>
                    </a>

                    <a href="{{ route('departments') }}"
                       class="department-detail-secondary-btn">
                        All Departments
                    </a>

                </div>

            </div>

            <div class="department-detail-hero-visual">

                @if($department->image_path)

                    <img
                        src="{{ asset('storage/' . $department->image_path) }}"
                        alt="{{ $department->name }}"
                        class="department-detail-image"
                        loading="eager"
                    >

                @else

                    <div class="department-detail-placeholder">

                        <span>
                            {{ $department->icon ?: '✚' }}
                        </span>

                        <h2>{{ $department->name }}</h2>

                        <p>
                            Professional healthcare focused
                            on your wellbeing.
                        </p>

                    </div>

                @endif

            </div>

        </div>

    </div>

</section>


<!-- ABOUT DEPARTMENT -->
<section class="department-detail-about">

    <div class="container">

        <div class="department-detail-about-grid">

            <div>

                <span class="section-label">
                    About Our Department
                </span>

                <h2>
                    Dedicated Care,
                    <span>Better Health.</span>
                </h2>

                <div class="department-detail-description">

                    @if($department->description)

                        {!! nl2br(e($department->description)) !!}

                    @elseif($department->short_description)

                        {!! nl2br(e($department->short_description)) !!}

                    @else

                        <p>
                            Discover our professional medical care
                            and experienced healthcare team at Medicare+.
                        </p>

                    @endif

                </div>

            </div>

            <div class="department-detail-info-card">

                <span class="department-detail-info-icon">
                    {{ $department->icon ?: '✚' }}
                </span>

                <h3>Expert Medical Support</h3>

                <p>
                    Our healthcare professionals are committed
                    to providing patient-focused care and
                    medical guidance.
                </p>

                <div class="department-detail-info-stat">

                    <strong>{{ $doctors->count() }}</strong>

                    <span>
                        Available {{ $doctors->count() === 1 ? 'Specialist' : 'Specialists' }}
                    </span>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- DEPARTMENT DOCTORS -->
<section id="department-doctors" class="department-detail-doctors">

    <div class="container">

        <div class="department-detail-section-heading">

            <div>

                <span class="section-label">
                    Our Medical Team
                </span>

                <h2>
                    Meet Our <span>Specialists</span>
                </h2>

                <p>
                    Explore the doctors available in our
                    {{ $department->name }} department.
                </p>

            </div>

            <a href="{{ route('doctors') }}"
               class="department-detail-all-doctors">
                View All Doctors →
            </a>

        </div>

        <div class="doctors-list-grid">

            @forelse($doctors as $doctor)

                <article class="doctor-list-card">

                    <div class="doctor-list-image">

                        <a href="{{ route('doctors.show', $doctor->slug) }}">

                            <img
                                src="{{ $doctor->image_path ? asset($doctor->image_path) : asset('images/doctor-1.jpg') }}"
                                alt="{{ $doctor->name }}"
                                loading="lazy"
                            >

                        </a>

                    </div>

                    <div class="doctor-list-content">

                        @if($doctor->specialization)
                            <span class="doctor-list-speciality">
                                {{ $doctor->specialization }}
                            </span>
                        @endif

                        <h3>
                            <a href="{{ route('doctors.show', $doctor->slug) }}">
                                {{ $doctor->name }}
                            </a>
                        </h3>

                        @if($doctor->experience_years !== null)
                            <p class="doctor-list-experience">
                                {{ $doctor->experience_years }}+ Years Experience
                            </p>
                        @endif

                        @if($doctor->short_description)
                            <p>{{ $doctor->short_description }}</p>
                        @endif

                        <a href="{{ route('doctors.show', $doctor->slug) }}"
                           class="department-detail-view-profile">
                            View Profile →
                        </a>

                        <a href="{{ route('appointment.create', ['doctor' => $doctor->slug]) }}"
                           class="doctor-profile-book-btn">
                            Book Appointment
                            <span aria-hidden="true">→</span>
                        </a>

                    </div>

                </article>

            @empty

                <div class="department-detail-empty">

                    <h3>No Specialists Available Yet</h3>

                    <p>
                        There are currently no active doctors
                        listed for this department.
                        Please explore our other medical departments.
                    </p>

                    <a href="{{ route('doctors') }}"
                       class="department-detail-primary-btn">
                        Explore All Doctors →
                    </a>

                </div>

            @endforelse

        </div>

    </div>

</section>


<!-- APPOINTMENT CTA -->
<section class="department-detail-cta-section">

    <div class="container">

        <div class="department-detail-cta">

            <div>

                <span class="section-label">
                    Your Health Matters
                </span>

                <h2>Need Medical Assistance?</h2>

                <p>
                    Book an appointment with Medicare+ and
                    get the healthcare support you need.
                </p>

            </div>

            <a href="{{ route('appointment.create') }}"
               class="department-detail-primary-btn">

                Book an Appointment

                <span aria-hidden="true">→</span>

            </a>

        </div>

    </div>

</section>

@endsection
