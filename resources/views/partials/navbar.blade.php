
<header class="main-header">
    <div class="container navbar">

        <!-- WEBSITE LOGO -->
        <a href="{{ route('home') }}" class="logo">

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

        <!-- NAVIGATION -->
        <nav class="nav-links" id="navLinks">

            <a
                href="{{ route('home') }}"
                class="{{ request()->routeIs('home') ? 'active' : '' }}"
            >
                Home
            </a>

            <a
                href="{{ route('about') }}"
                class="{{ request()->routeIs('about') ? 'active' : '' }}"
            >
                About
            </a>

            <a
                href="{{ route('doctors') }}"
                class="{{ request()->routeIs('doctors*') ? 'active' : '' }}"
            >
                Doctors
            </a>

            <a
                href="{{ route('departments') }}"
                class="{{ request()->routeIs('departments*') ? 'active' : '' }}"
            >
                Departments
            </a>

            <a
                href="{{ route('services') }}"
                class="{{ request()->routeIs('services*') ? 'active' : '' }}"
            >
                Services
            </a>

            <a
                href="{{ route('contact') }}"
                class="{{ request()->routeIs('contact') ? 'active' : '' }}"
            >
                Contact
            </a>

        </nav>

        <!-- LIGHT / DARK MODE TOGGLE -->
        <button
            type="button"
            class="medicare-theme-toggle"
            id="medicareThemeToggle"
            aria-label="Switch to dark mode"
            aria-pressed="false"
            title="Switch theme"
        >
            <svg
                class="theme-moon-icon"
                width="20"
                height="20"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round"
                aria-hidden="true"
            >
                <path
                    d="M20.985 12.486A9 9 0 0 1 11.514 3.015
                       9 9 0 1 0 20.985 12.486Z"
                />
            </svg>

            <svg
                class="theme-sun-icon"
                width="20"
                height="20"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round"
                aria-hidden="true"
            >
                <circle cx="12" cy="12" r="4" />
                <path
                    d="M12 2v2m0 16v2
                       M4.93 4.93l1.42 1.42
                       m11.3 11.3 1.42 1.42
                       M2 12h2m16 0h2
                       M4.93 19.07l1.42-1.42
                       M17.65 6.35l1.42-1.42"
                />
            </svg>
        </button>

        <!-- APPOINTMENT BUTTON -->
        <a
            href="{{ route('appointment.create') }}"
            class="appointment-btn"
        >
            Book Appointment
        </a>

        <!-- MOBILE MENU -->
        <button
            type="button"
            class="menu-btn"
            id="menuBtn"
            aria-label="Open menu"
        >
            ☰
        </button>

    </div>
</header>
