
@extends('layouts.app')

@section('title', $service->name . ' | Medicare+')

@section('content')

<!-- SERVICE DETAIL HERO -->
<section class="service-detail-hero">

    <div class="container">

        <div class="service-detail-breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span>/</span>
            <a href="{{ route('services') }}">Services</a>
            <span>/</span>
            <span>{{ $service->name }}</span>
        </div>

        <div class="service-detail-hero-content">

            <span class="section-label">
                Medicare+ Healthcare Services
            </span>

            <div class="service-detail-icon">
                {{ $service->icon ?: '✚' }}
            </div>

            <h1>{{ $service->name }}</h1>

            @if($service->short_description)
                <p>{{ $service->short_description }}</p>
            @endif

            <div class="service-detail-hero-actions">

                <a href="{{ route('appointment.create') }}"
                   class="service-detail-primary-btn">
                    Book an Appointment
                    <span aria-hidden="true">→</span>
                </a>

                <a href="{{ route('services') }}"
                   class="service-detail-secondary-btn">
                    Explore All Services
                </a>

            </div>

        </div>

    </div>

</section>


<!-- SERVICE DETAILS -->
<section class="service-detail-main">

    <div class="container">

        <div class="service-detail-grid">

            <div class="service-detail-information">

                <span class="section-label">
                    About This Service
                </span>

                <h2>
                    Professional Care,
                    <span>Focused on You.</span>
                </h2>

                @if($service->description)

                    <div class="service-detail-description">
                        {!! nl2br(e($service->description)) !!}
                    </div>

                @elseif($service->short_description)

                    <div class="service-detail-description">
                        {!! nl2br(e($service->short_description)) !!}
                    </div>

                @else

                    <p>
                        Learn more about our healthcare service
                        and speak with the Medicare+ team to
                        find the right care for your needs.
                    </p>

                @endif

                <div class="service-detail-features">

                    <div class="service-detail-feature">
                        <span aria-hidden="true">✓</span>
                        <p>Patient-focused healthcare</p>
                    </div>

                    <div class="service-detail-feature">
                        <span aria-hidden="true">✓</span>
                        <p>Professional medical support</p>
                    </div>

                    <div class="service-detail-feature">
                        <span aria-hidden="true">✓</span>
                        <p>Convenient appointment booking</p>
                    </div>

                </div>

            </div>


            <!-- SERVICE IMAGE OR INFORMATION CARD -->
            <div class="service-detail-visual">

                @if($service->image_path)

                    <img
                        src="{{ asset('storage/' . $service->image_path) }}"
                        alt="{{ $service->name }}"
                        class="service-detail-image"
                        loading="lazy"
                    >

                @else

                    <div class="service-detail-placeholder">

                        <span class="service-detail-placeholder-icon">
                            {{ $service->icon ?: '✚' }}
                        </span>

                        <h3>{{ $service->name }}</h3>

                        <p>
                            Quality healthcare, delivered with
                            care and attention.
                        </p>

                    </div>

                @endif

            </div>

        </div>

    </div>

</section>



<!-- RELATED SERVICES -->
@if($relatedServices->isNotEmpty())

<section class="service-related-section">

    <div class="container">

        <div class="service-related-header">

            <div>
                <span class="section-label">
                    Explore More Care
                </span>

                <h2>
                    Other Healthcare <span>Services</span>
                </h2>

                <p>
                    Discover more medical services available
                    at Medicare+ to support your healthcare needs.
                </p>
            </div>

            <a href="{{ route('services') }}"
               class="service-related-all-btn">
                View All Services
                <span aria-hidden="true">→</span>
            </a>

        </div>

        <div class="service-related-grid">

            @foreach($relatedServices as $relatedService)

                <article class="service-related-card">

                    <div class="service-related-icon">
                        {{ $relatedService->icon ?: '✚' }}
                    </div>

                    <h3>{{ $relatedService->name }}</h3>

                    <p>
                        {{ $relatedService->short_description }}
                    </p>

                    <a href="{{ route('services.show', $relatedService->slug) }}"
                       class="service-related-link">

                        View Service

                        <span aria-hidden="true">→</span>

                    </a>

                </article>

            @endforeach

        </div>

    </div>

</section>

@endif

<!-- APPOINTMENT CTA -->
<section class="service-detail-cta-section">

    <div class="container">

        <div class="service-detail-cta">

            <div>
                <span class="section-label">
                    Your Health Matters
                </span>

                <h2>
                    Ready to Take the Next Step?
                </h2>

                <p>
                    Schedule an appointment with Medicare+
                    and let our team help you with your
                    healthcare needs.
                </p>
            </div>

            <a href="{{ route('appointment.create') }}"
               class="service-detail-primary-btn">
                Book an Appointment
                <span aria-hidden="true">→</span>
            </a>

        </div>

    </div>

</section>

@endsection
