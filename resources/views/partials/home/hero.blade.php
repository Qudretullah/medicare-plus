
@php
    /*
     * Fetch saved Hero content once.
     * If a CMS record does not exist, use original text.
     */
    $heroCms = \App\Models\WebsiteContentItem::query()
        ->where('page', 'home')
        ->whereIn('content_key', [
            'home_hero_badge',
            'home_hero_heading',
            'home_hero_heading_highlight',
            'home_hero_description',
            'home_hero_primary_button',
            'home_hero_secondary_button',
            'home_hero_doctors_count',
            'home_hero_doctors_label',
            'home_hero_departments_count',
            'home_hero_departments_label',
            'home_hero_patients_count',
            'home_hero_patients_label',
        ])
        ->pluck('value', 'content_key');

    $heroValue = fn ($key, $default) =>
        $heroCms->get($key) ?? $default;

    // Counter values must stay numeric for existing JS.
    $doctorsCount = (int) $heroValue('home_hero_doctors_count', '25');
    $departmentsCount = (int) $heroValue('home_hero_departments_count', '10');
    $patientsCount = (int) $heroValue('home_hero_patients_count', '5000');
@endphp

<section class="hero-section">

    <!-- EXISTING AUTOMATIC IMAGE SLIDER -->
    <div class="hero-background" id="heroSlider">

        <img
            src="{{ asset('images/hero-1.jpg') }}"
            alt="Doctors walking in hospital"
            class="hero-background-image active"
            fetchpriority="high"
        >

        <img
            src="{{ asset('images/hero-2.jpg') }}"
            alt="Modern hospital interior"
            class="hero-background-image"
        >

        <img
            src="{{ asset('images/hero-3.jpg') }}"
            alt="Professional medical team"
            class="hero-background-image"
        >

        <img
            src="{{ asset('images/hero-4.jpg') }}"
            alt="Doctor consulting with patient"
            class="hero-background-image"
        >

    </div>

    <div class="hero-overlay"></div>

    <div class="container hero-wrapper">

        <div class="hero-content">

            <!-- CMS BADGE -->
            <span class="hero-badge">
                <span class="hero-badge-dot"></span>

                {{ $heroValue(
                    'home_hero_badge',
                    'Trusted Healthcare Professionals'
                ) }}
            </span>

            <!-- CMS HEADING -->
            <h1>
                {{ $heroValue(
                    'home_hero_heading',
                    'Expert Care For A'
                ) }}

                <span>
                    {{ $heroValue(
                        'home_hero_heading_highlight',
                        'Healthier You'
                    ) }}
                </span>
            </h1>

            <!-- CMS DESCRIPTION -->
            <p>
                {{ $heroValue(
                    'home_hero_description',
                    'Experience quality healthcare with our trusted and experienced medical professionals. Book your appointment easily and take the first step toward better health.'
                ) }}
            </p>

            <!-- BUTTONS -->
            <div class="hero-buttons">

                <a
                    href="{{ route('appointment.create') }}"
                    class="hero-primary-btn"
                >
                    {{ $heroValue(
                        'home_hero_primary_button',
                        'Book Appointment'
                    ) }}

                    <span aria-hidden="true">→</span>
                </a>

                <a
                    href="{{ route('doctors') }}"
                    class="hero-secondary-btn"
                >
                    {{ $heroValue(
                        'home_hero_secondary_button',
                        'Find A Doctor'
                    ) }}

                    <span aria-hidden="true">↗</span>
                </a>

            </div>

            <!-- ANIMATED COUNTERS -->
            <div class="hero-features">

                <div class="hero-feature">

                    <strong data-count="{{ $doctorsCount }}">
                        {{ $doctorsCount }}+
                    </strong>

                    <span>
                        {{ $heroValue(
                            'home_hero_doctors_label',
                            'Expert Doctors'
                        ) }}
                    </span>

                </div>

                <div class="hero-feature">

                    <strong data-count="{{ $departmentsCount }}">
                        {{ $departmentsCount }}+
                    </strong>

                    <span>
                        {{ $heroValue(
                            'home_hero_departments_label',
                            'Departments'
                        ) }}
                    </span>

                </div>

                <div class="hero-feature">

                    <strong data-count="{{ $patientsCount }}">
                        {{ $patientsCount }}+
                    </strong>

                    <span>
                        {{ $heroValue(
                            'home_hero_patients_label',
                            'Happy Patients'
                        ) }}
                    </span>

                </div>

            </div>

        </div>

    </div>

</section>
