
@php
    /*
    |--------------------------------------------------------------------------
    | MEDICARE+ HOME ABOUT SECTION CMS
    |--------------------------------------------------------------------------
    | Only Home Page About content is loaded.
    | Standalone About Page uses separate about_* keys.
    */

    $aboutCms = \App\Models\WebsiteContentItem::query()
        ->where('page', 'home')
        ->where('content_key', 'like', 'home_about_%')
        ->pluck('value', 'content_key');

    $aboutValue = fn ($key, $default) =>
        $aboutCms->get($key) ?? $default;
@endphp

<!-- ABOUT CTA -->

<section class="about-cta-section">
    <div class="container">

        <div class="about-cta-box">

            <div class="about-cta-content">

                <span class="about-cta-label">
                    {{ $aboutValue('home_about_cta_label', 'YOUR HEALTH, OUR PRIORITY') }}
                </span>

                <h2>
                    {{ $aboutValue('home_about_cta_heading', 'Need A Doctor?') }}

                    <span>
                        {{ $aboutValue('home_about_cta_highlight', 'Schedule Your Visit Today') }}
                    </span>
                </h2>

                <p>
                    {{ $aboutValue('home_about_cta_description', 'Your health matters. Book trusted medical care with ease.') }}
                </p>

            </div>

            <div class="about-cta-action">

                <a href="{{ route('appointment.create') }}"
                   class="about-cta-btn">

                    {{ $aboutValue('home_about_cta_button', 'Book Appointment') }}

                    <span aria-hidden="true">→</span>

                </a>

            </div>

        </div>

    </div>
</section>

<!-- OUR STORY -->

<section class="about-story-section">

    <div class="container about-story-wrapper">

        <div class="about-story-image">

            <img
                src="{{ asset('images/about-clinic.jpg') }}"
                alt="Modern Medicare Plus healthcare facility"
                loading="lazy"
            >

            <div class="about-story-image-badge">
                <span>✦</span>

                {{ $aboutValue('home_about_story_image_badge', 'Trusted Healthcare') }}
            </div>

        </div>

        <div class="about-story-content">

            <span class="section-label">
                {{ $aboutValue('home_about_story_label', 'Our Story') }}
            </span>

            <h2>
                {{ $aboutValue('home_about_story_heading', 'Dedicated To Better') }}

                <span>
                    {{ $aboutValue('home_about_story_highlight', 'Healthcare And Better Lives') }}
                </span>
            </h2>

            <p>
                {{ $aboutValue('home_about_story_paragraph_1', 'Medicare+ was created with one clear purpose: to make reliable and professional healthcare more accessible for every patient.') }}
            </p>

            <p>
                {{ $aboutValue('home_about_story_paragraph_2', 'Our clinic combines experienced doctors, modern medical facilities and a patient-first approach to provide quality care in a safe and comfortable environment.') }}
            </p>

            <div class="about-story-points">

                <div>
                    <span>✓</span>
                    {{ $aboutValue('home_about_story_point_1', 'Experienced Medical Professionals') }}
                </div>

                <div>
                    <span>✓</span>
                    {{ $aboutValue('home_about_story_point_2', 'Modern Healthcare Facilities') }}
                </div>

                <div>
                    <span>✓</span>
                    {{ $aboutValue('home_about_story_point_3', 'Patient-Centered Treatment') }}
                </div>

                <div>
                    <span>✓</span>
                    {{ $aboutValue('home_about_story_point_4', 'Trusted Medical Support') }}
                </div>

            </div>

        </div>

    </div>

</section>

<!-- MISSION & VISION -->

<section class="mission-vision-section">

    <div class="container">

        <div class="section-heading about-section-heading">

            <span class="section-label">
                {{ $aboutValue('home_about_purpose_label', 'Our Purpose') }}
            </span>

            <h2>
                {{ $aboutValue('home_about_purpose_heading', 'Guided By Care,') }}

                <span>
                    {{ $aboutValue('home_about_purpose_highlight', 'Driven By Excellence') }}
                </span>
            </h2>

            <p>
                {{ $aboutValue('home_about_purpose_description', 'Our mission and vision guide everything we do at Medicare+ and help us deliver better healthcare experiences for every patient.') }}
            </p>

        </div>

        <div class="mission-vision-grid">

            <!-- MISSION -->
            <div class="mission-card">

                <div class="mission-card-icon">
                    <span>◎</span>
                </div>

                <h3>
                    {{ $aboutValue('home_about_mission_title', 'Our Mission') }}
                </h3>

                <p>
                    {{ $aboutValue('home_about_mission_description', 'To provide accessible, reliable and patient-focused healthcare through experienced medical professionals, modern facilities and compassionate service.') }}
                </p>

                <div class="purpose-card-bottom"></div>

            </div>

            <!-- VISION -->
            <div class="vision-card">

                <div class="mission-card-icon">
                    <span>◉</span>
                </div>

                <h3>
                    {{ $aboutValue('home_about_vision_title', 'Our Vision') }}
                </h3>

                <p>
                    {{ $aboutValue('home_about_vision_description', 'To become a trusted healthcare provider known for quality treatment, innovation and a strong commitment to the health and well-being of every patient.') }}
                </p>

                <div class="purpose-card-bottom"></div>

            </div>

        </div>

    </div>

</section>

<!-- WHY CHOOSE US -->

<section class="why-choose-section">

    <div class="container">

        <div class="section-heading about-section-heading">

            <span class="section-label">
                {{ $aboutValue('home_about_why_label', 'Why Choose Us') }}
            </span>

            <h2>
                {{ $aboutValue('home_about_why_heading', 'Why Patients') }}

                <span>
                    {{ $aboutValue('home_about_why_highlight', 'Trust Medicare+') }}
                </span>
            </h2>

            <p>
                {{ $aboutValue('home_about_why_description', 'We combine professional medical expertise, modern facilities and patient-focused care to provide a better healthcare experience.') }}
            </p>

        </div>

        <div class="why-choose-grid">

            <!-- CARD 1 -->
            <div class="why-choose-card">

                <div class="why-choose-icon">
                    <span>✚</span>
                </div>

                <h3>
                    {{ $aboutValue('home_about_why_card_1_title', 'Experienced Doctors') }}
                </h3>

                <p>
                    {{ $aboutValue('home_about_why_card_1_description', 'Our medical team includes qualified and experienced doctors from different specialties.') }}
                </p>

            </div>

            <!-- CARD 2 -->
            <div class="why-choose-card">

                <div class="why-choose-icon">
                    <span>▣</span>
                </div>

                <h3>
                    {{ $aboutValue('home_about_why_card_2_title', 'Modern Facilities') }}
                </h3>

                <p>
                    {{ $aboutValue('home_about_why_card_2_description', 'We use modern medical facilities and reliable healthcare equipment for better care.') }}
                </p>

            </div>

            <!-- CARD 3 -->
            <div class="why-choose-card">

                <div class="why-choose-icon">
                    <span>♥</span>
                </div>

                <h3>
                    {{ $aboutValue('home_about_why_card_3_title', 'Patient First Care') }}
                </h3>

                <p>
                    {{ $aboutValue('home_about_why_card_3_description', 'Every patient receives respectful, compassionate and personalized medical attention.') }}
                </p>

            </div>

            <!-- CARD 4 -->
            <div class="why-choose-card">

                <div class="why-choose-icon">
                    <span>◷</span>
                </div>

                <h3>
                    {{ $aboutValue('home_about_why_card_4_title', 'Easy Appointments') }}
                </h3>

                <p>
                    {{ $aboutValue('home_about_why_card_4_description', 'Our appointment system makes it easy to schedule your visit at a convenient time.') }}
                </p>

            </div>

        </div>

    </div>

</section>
