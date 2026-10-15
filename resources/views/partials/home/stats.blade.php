
@php
    /*
    |--------------------------------------------------------------------------
    | MEDICARE+ HOME STATS CMS
    |--------------------------------------------------------------------------
    | Database se values load hongi.
    | Agar record available nahi, original value show hogi.
    */

    $statsCms = \App\Models\WebsiteContentItem::query()
        ->where('page', 'home')
        ->whereIn('content_key', [
            'home_stats_experience_count',
            'home_stats_experience_label',
            'home_stats_doctors_count',
            'home_stats_doctors_label',
            'home_stats_patients_count',
            'home_stats_patients_label',
            'home_stats_support_count',
            'home_stats_support_label',
        ])
        ->pluck('value', 'content_key');

    $statsValue = fn ($key, $default) =>
        $statsCms->get($key) ?? $default;

    $experienceCount = (int) $statsValue(
        'home_stats_experience_count',
        '10'
    );

    $doctorsCount = (int) $statsValue(
        'home_stats_doctors_count',
        '50'
    );

    $patientsCount = (int) $statsValue(
        'home_stats_patients_count',
        '10000'
    );

    $supportCount = (int) $statsValue(
        'home_stats_support_count',
        '24'
    );
@endphp

<section class="stats-section">

    <div class="container stats-grid">

        <!-- EXPERIENCE -->
        <div class="stat-card">

            <div class="stat-icon">👨‍⚕️</div>

            <div>

                <h3 data-count="{{ $experienceCount }}">
                    {{ $experienceCount }}+
                </h3>

                <p>
                    {{ $statsValue(
                        'home_stats_experience_label',
                        'Years Experience'
                    ) }}
                </p>

            </div>

        </div>

        <!-- DOCTORS -->
        <div class="stat-card">

            <div class="stat-icon">🩺</div>

            <div>

                <h3 data-count="{{ $doctorsCount }}">
                    {{ $doctorsCount }}+
                </h3>

                <p>
                    {{ $statsValue(
                        'home_stats_doctors_label',
                        'Expert Doctors'
                    ) }}
                </p>

            </div>

        </div>

        <!-- HAPPY PATIENTS -->
        <div class="stat-card">

            <div class="stat-icon">❤</div>

            <div>

                <h3 data-count="{{ $patientsCount }}">
                    {{ number_format($patientsCount) }}+
                </h3>

                <p>
                    {{ $statsValue(
                        'home_stats_patients_label',
                        'Happy Patients'
                    ) }}
                </p>

            </div>

        </div>

        <!-- EMERGENCY SUPPORT -->
        <div class="stat-card">

            <div class="stat-icon">🎧</div>

            <div>

                <h3 data-count="{{ $supportCount }}">
                    {{ $supportCount }}/7
                </h3>

                <p>
                    {{ $statsValue(
                        'home_stats_support_label',
                        'Emergency Support'
                    ) }}
                </p>

            </div>

        </div>

    </div>

</section>
