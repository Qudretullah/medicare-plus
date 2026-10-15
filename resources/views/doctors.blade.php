
@extends('layouts.app')

@section('title', 'Doctors | Medicare+')

@section('content')

<section class="doctors-page-hero">
    <div class="container doctors-page-hero-wrapper">
        <div class="doctors-page-hero-content">

            <span class="section-label">
                {{ $contentItems->get('doctors_hero_label')?->value ?? 'Our Doctors' }}
            </span>

            <h1>
                {{ $contentItems->get('doctors_hero_heading')?->value ?? 'Meet Our Trusted' }}

                <span>
                    {{ $contentItems->get('doctors_hero_highlight')?->value ?? 'Medical Specialists' }}
                </span>
            </h1>

            <p>
                {{ $contentItems->get('doctors_hero_description')?->value ?? 'Our experienced doctors are committed to providing professional, compassionate and reliable healthcare across multiple specialties.' }}
            </p>

        </div>
    </div>
</section>

<section class="doctors-list-section">
    <div class="container">

        <div class="doctors-list-grid">

            @forelse($doctors as $doctor)

                <div class="doctor-list-card">

                    <div class="doctor-list-image">
                        <img
                            src="{{ $doctor->image_path ? asset($doctor->image_path) : asset('images/doctor-1.jpg') }}"
                            alt="{{ $doctor->name }}"
                            loading="lazy"
                        >
                    </div>

                    <div class="doctor-list-content">

                        <span class="doctor-list-speciality">
                            {{ $doctor->specialization }}
                        </span>

                        <h3>{{ $doctor->name }}</h3>

                        <p class="doctor-list-experience">
                            {{ $doctor->experience_years }}+
                            Years Experience
                        </p>

                        <p>
                            {{ $doctor->short_description }}
                        </p>

                        <a
                            href="{{ route('doctors.show', $doctor->slug) }}"
                            class="doctor-list-btn"
                        >
                            View Profile
                        </a>

                    </div>
                </div>

            @empty

                <p>No doctors are currently available.</p>

            @endforelse

        </div>
    </div>
</section>

@endsection
