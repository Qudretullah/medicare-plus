
<footer class="footer">

    <div class="container footer-grid">

        <!-- BRAND -->
        <div class="footer-brand">

            <a href="{{ route('home') }}" class="footer-logo">

                @if(!empty($siteSettings['site_logo']))
                    <img
                        src="{{ asset('storage/' . $siteSettings['site_logo']) }}"
                        alt="{{ $siteSettings['site_name'] }} Logo"
                        class="site-brand-image"
                    >
                @else
                    <span class="logo-icon" aria-hidden="true">✚</span>
                @endif

                <span>{{ $siteSettings['site_name'] }}</span>
            </a>

            <p>{{ $siteSettings['footer_description'] }}</p>

            <!-- SOCIAL MEDIA -->
            @if(
                !empty($siteSettings['facebook_url']) ||
                !empty($siteSettings['instagram_url']) ||
                !empty($siteSettings['linkedin_url']) ||
                !empty($siteSettings['whatsapp_number'])
            )
                <div class="footer-social-links">

                    @if(!empty($siteSettings['facebook_url']))
                        <a
                            href="{{ $siteSettings['facebook_url'] }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="Facebook"
                        >
                            Facebook ↗
                        </a>
                    @endif

                    @if(!empty($siteSettings['instagram_url']))
                        <a
                            href="{{ $siteSettings['instagram_url'] }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="Instagram"
                        >
                            Instagram ↗
                        </a>
                    @endif

                    @if(!empty($siteSettings['linkedin_url']))
                        <a
                            href="{{ $siteSettings['linkedin_url'] }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="LinkedIn"
                        >
                            LinkedIn ↗
                        </a>
                    @endif

                    @if(!empty($siteSettings['whatsapp_number']))
                        <a
                            href="https://wa.me/{{ preg_replace('/\D+/', '', $siteSettings['whatsapp_number']) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="WhatsApp"
                        >
                            WhatsApp ↗
                        </a>
                    @endif

                </div>
            @endif

        </div>

        <!-- QUICK LINKS -->
        <div class="footer-column">

            <h3>Quick Links</h3>

            <a href="{{ route('home') }}">Home</a>

            <a href="{{ route('about') }}">About</a>

            <a href="{{ route('doctors') }}">Doctors</a>

            <a href="{{ route('departments') }}">Departments</a>

            <a href="{{ route('services') }}">Services</a>

            <a href="{{ route('contact') }}">Contact</a>

            <a href="{{ route('appointment.create') }}">
                Book Appointment
            </a>

        </div>

        <!-- SERVICES -->
        <div class="footer-column">

            <h3>Our Services</h3>

            @php
                $footerServices = preg_split(
                    '/\r\n|\r|\n/',
                    $siteSettings['footer_services'] ?? ''
                );
            @endphp

            @foreach($footerServices as $service)
                @if(trim($service) !== '')
                    <p>{{ trim($service) }}</p>
                @endif
            @endforeach

        </div>

        <!-- CONTACT -->
        <div class="footer-column">

            <h3>Contact Us</h3>

            @if(!empty($siteSettings['clinic_address_line_1']))
                <p>{{ $siteSettings['clinic_address_line_1'] }}</p>
            @endif

            @if(!empty($siteSettings['clinic_address_line_2']))
                <p>{{ $siteSettings['clinic_address_line_2'] }}</p>
            @endif

            @if(!empty($siteSettings['clinic_phone']))
                <p>
                    <a href="tel:{{ preg_replace('/[^\d+]/', '', $siteSettings['clinic_phone']) }}">
                        {{ $siteSettings['clinic_phone'] }}
                    </a>
                </p>
            @endif

            @if(!empty($siteSettings['clinic_email']))
                <p>
                    <a href="mailto:{{ $siteSettings['clinic_email'] }}">
                        {{ $siteSettings['clinic_email'] }}
                    </a>
                </p>
            @endif

        </div>

    </div>

    <!-- COPYRIGHT -->
    <div class="container footer-bottom">

        <p>
            © {{ date('Y') }}
            {{ $siteSettings['site_name'] }}.
            {{ $siteSettings['copyright_text'] }}
        </p>

    </div>

</footer>
