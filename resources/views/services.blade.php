
@extends('layouts.app')

@section('title', 'Services | Medicare+')

@section('content')

<!-- SERVICES HERO -->
<section class="services-page-hero">

    <div class="container services-page-hero-wrapper">

        <div class="services-page-hero-content">

            <span class="section-label">
                {{ $contentItems->get('services_hero_label')?->value ?? 'Our Services' }}
            </span>

            <h1>
                {{ $contentItems->get('services_hero_heading')?->value ?? 'Complete Healthcare' }}

                <span>
                    {{ $contentItems->get('services_hero_highlight')?->value ?? 'Services For You' }}
                </span>
            </h1>

            <p>
                {{ $contentItems->get('services_hero_description')?->value ?? 'Medicare+ provides reliable and professional healthcare services designed to meet the medical needs of individuals and families.' }}
            </p>

        </div>

    </div>

</section>


<!-- SERVICES LIST -->
<section class="services-list-section">

    <div class="container">

        <div class="section-heading">

            <span class="section-label">
                {{ $contentItems->get('services_list_label')?->value ?? 'What We Offer' }}
            </span>

            <h2>
                {{ $contentItems->get('services_list_heading')?->value ?? 'Professional Medical Services' }}
            </h2>

            <p>
                {{ $contentItems->get('services_list_description')?->value ?? 'Explore our healthcare services designed to support your health, wellness and medical needs.' }}
            </p>

        </div>


        <div class="services-list-grid">

            @forelse($services as $service)

                <div class="service-card">

                    <!-- SERVICE ICON -->
                    <div class="service-icon">
                        {{ $service->icon ?: '✚' }}
                    </div>

                    <!-- SERVICE NAME -->
                    <h3>
                        {{ $service->name }}
                    </h3>

                    <!-- SERVICE DESCRIPTION -->
                    <p>
                        {{ $service->short_description }}
                    </p>

                    <!-- SERVICE BUTTON -->
                   
                   <a href="{{ route('services.show', $service->slug) }}"
                    class="service-btn">
                   {{ $contentItems->get('services_card_button')?->value ?? 'Learn More' }}
                   </a>

                </div>

            @empty

                <div class="services-empty-state">
                    <h3>No Services Available</h3>
                    <p>Please check back later for our healthcare services.</p>
                </div>

            @endforelse

        </div>

    </div>

</section>

@endsection
