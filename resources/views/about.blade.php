
@extends('layouts.app')

@section('title', 'About | Medicare+')

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | MEDICARE+ STANDALONE ABOUT PAGE CMS
    |--------------------------------------------------------------------------
    | Only page = about records are loaded.
    | Original content is used if a database value is missing.
    */

    $aboutCms = \App\Models\WebsiteContentItem::query()
        ->where('page', 'about')
        ->whereIn('content_key', [
            'about_hero_label',
            'about_hero_heading',
            'about_hero_highlight',
            'about_hero_description',
            'about_story_label',
            'about_story_heading',
            'about_story_paragraph_1',
            'about_story_paragraph_2',
            'about_story_point_1',
            'about_story_point_2',
            'about_story_point_3',
            'about_story_point_4',
            'about_purpose_label',
            'about_purpose_heading',
            'about_purpose_description',
            'about_mission_title',
            'about_mission_description',
            'about_vision_title',
            'about_vision_description',
            'about_why_label',
            'about_why_heading',
            'about_why_description',
            'about_why_card_1_title',
            'about_why_card_1_description',
            'about_why_card_2_title',
            'about_why_card_2_description',
            'about_why_card_3_title',
            'about_why_card_3_description',
            'about_why_card_4_title',
            'about_why_card_4_description',
            'about_cta_label',
            'about_cta_heading',
            'about_cta_description',
            'about_cta_button',
        ])
        ->pluck('value', 'content_key');

    $aboutValue = fn ($key, $default) =>
        $aboutCms->get($key) ?? $default;
@endphp

<!-- ABOUT PAGE HERO -->

<section class="about-page-hero">

    <div class="container about-page-hero-wrapper">

        <div class="about-page-hero-content">

            <span class="section-label">
                {{ $aboutValue('about_hero_label', 'About Medicare+') }}
            </span>

            <h1>
                {{ $aboutValue('about_hero_heading', 'Trusted Healthcare With') }}
                <span>{{ $aboutValue('about_hero_highlight', 'Compassion & Experience') }}</span>
            </h1>

            <p>
                {{ $aboutValue('about_hero_description', 'Medicare+ is committed to delivering reliable, modern and patient-focused healthcare through experienced doctors and advanced medical facilities.') }}
            </p>

        </div>

    </div>

</section>

<!-- OUR STORY -->

<section class="about-story-section">

    <div class="container about-story-wrapper">

        <div class="about-story-image">

            <img
                src="{{ asset('images/about-clinic.jpg') }}"
                alt="Medicare Plus Clinic"
            >

        </div>

        <div class="about-story-content">

            <span class="section-label">
                {{ $aboutValue('about_story_label', 'Our Story') }}
            </span>

            <h2>
                {{ $aboutValue('about_story_heading', 'Dedicated To Better Healthcare And Better Lives') }}
            </h2>

            <p>
                {{ $aboutValue('about_story_paragraph_1', 'Medicare+ was created with one clear purpose: to make reliable and professional healthcare more accessible for every patient.') }}
            </p>

            <p>
                {{ $aboutValue('about_story_paragraph_2', 'Our clinic combines experienced doctors, modern medical facilities and a patient-first approach to provide quality care in a safe and comfortable environment.') }}
            </p>

            <div class="about-story-points">

                <div>
                    <span>✓</span>
                    {{ $aboutValue('about_story_point_1', 'Experienced Medical Professionals') }}
                </div>

                <div>
                    <span>✓</span>
                    {{ $aboutValue('about_story_point_2', 'Modern Healthcare Facilities') }}
                </div>

                <div>
                    <span>✓</span>
                    {{ $aboutValue('about_story_point_3', 'Patient-Centered Treatment') }}
                </div>

                <div>
                    <span>✓</span>
                    {{ $aboutValue('about_story_point_4', 'Trusted Medical Support') }}
                </div>

            </div>

        </div>

    </div>

</section>

<!-- MISSION & VISION -->

<section class="mission-vision-section">

    <div class="container">

        <div class="section-heading">

            <span class="section-label">
                {{ $aboutValue('about_purpose_label', 'Our Purpose') }}
            </span>

            <h2>
                {{ $aboutValue('about_purpose_heading', 'Guided By Care, Driven By Excellence') }}
            </h2>

            <p>
                {{ $aboutValue('about_purpose_description', 'Our mission and vision guide everything we do at Medicare+ and help us deliver better healthcare experiences for every patient.') }}
            </p>

        </div>

        <div class="mission-vision-grid">

            <!-- MISSION -->

            <div class="mission-card">

                <div class="mission-card-icon">
                    🎯
                </div>

                <h3>
                    {{ $aboutValue('about_mission_title', 'Our Mission') }}
                </h3>

                <p>
                    {{ $aboutValue('about_mission_description', 'To provide accessible, reliable and patient-focused healthcare through experienced medical professionals, modern facilities and compassionate service.') }}
                </p>

            </div>

            <!-- VISION -->

            <div class="vision-card">

                <div class="mission-card-icon">
                    👁
                </div>

                <h3>
                    {{ $aboutValue('about_vision_title', 'Our Vision') }}
                </h3>

                <p>
                    {{ $aboutValue('about_vision_description', 'To become a trusted healthcare provider known for quality treatment, innovation and a strong commitment to the health and well-being of every patient.') }}
                </p>

            </div>

        </div>

    </div>

</section>

<!-- WHY CHOOSE US -->

<section class="why-choose-section">

    <div class="container">

        <div class="section-heading">

            <span class="section-label">
                {{ $aboutValue('about_why_label', 'Why Choose Us') }}
            </span>

            <h2>
                {{ $aboutValue('about_why_heading', 'Why Patients Trust Medicare+') }}
            </h2>

            <p>
                {{ $aboutValue('about_why_description', 'We combine professional medical expertise, modern facilities and patient-focused care to provide a better healthcare experience.') }}
            </p>

        </div>

        <div class="why-choose-grid">

            <!-- CARD 1 -->

            <div class="why-choose-card">

                <div class="why-choose-icon">
                    👨‍⚕️
                </div>

                <h3>
                    {{ $aboutValue('about_why_card_1_title', 'Experienced Doctors') }}
                </h3>

                <p>
                    {{ $aboutValue('about_why_card_1_description', 'Our medical team includes qualified and experienced doctors from different specialties.') }}
                </p>

            </div>

            <!-- CARD 2 -->

            <div class="why-choose-card">

                <div class="why-choose-icon">
                    🏥
                </div>

                <h3>
                    {{ $aboutValue('about_why_card_2_title', 'Modern Facilities') }}
                </h3>

                <p>
                    {{ $aboutValue('about_why_card_2_description', 'We use modern medical facilities and reliable healthcare equipment for better care.') }}
                </p>

            </div>

            <!-- CARD 3 -->

            <div class="why-choose-card">

                <div class="why-choose-icon">
                    ❤
                </div>

                <h3>
                    {{ $aboutValue('about_why_card_3_title', 'Patient First Care') }}
                </h3>

                <p>
                    {{ $aboutValue('about_why_card_3_description', 'Every patient receives respectful, compassionate and personalized medical attention.') }}
                </p>

            </div>

            <!-- CARD 4 -->

            <div class="why-choose-card">

                <div class="why-choose-icon">
                    🕒
                </div>

                <h3>
                    {{ $aboutValue('about_why_card_4_title', 'Easy Appointments') }}
                </h3>

                <p>
                    {{ $aboutValue('about_why_card_4_description', 'Our appointment system makes it easy to schedule your visit at a convenient time.') }}
                </p>

            </div>

        </div>

    </div>

</section>

<!-- ABOUT CTA -->

<section class="about-cta-section">

    <div class="container about-cta-wrapper">

        <div class="about-cta-content">

            <span class="section-label about-cta-label">
                {{ $aboutValue('about_cta_label', 'Your Health Matters') }}
            </span>

            <h2>
                {{ $aboutValue('about_cta_heading', 'Ready To Book Your Appointment?') }}
            </h2>

            <p>
                {{ $aboutValue('about_cta_description', 'Connect with our experienced doctors and get professional medical care at a time that suits you.') }}
            </p>

        </div>

        <div class="about-cta-action">

            <a href="{{ route('appointment.create') }}"
               class="about-cta-btn">

                {{ $aboutValue('about_cta_button', 'Book Appointment') }}

            </a>

        </div>

    </div>

</section>

@endsection
