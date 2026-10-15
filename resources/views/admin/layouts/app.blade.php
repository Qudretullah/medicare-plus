
<!DOCTYPE html>
<html lang="en" data-admin-theme="light">

<head>
    <meta charset="UTF-8">

    <script>
        (function () {
            try {
                const savedTheme = localStorage.getItem('medicare_admin_theme');

                document.documentElement.setAttribute(
                    'data-admin-theme',
                    savedTheme === 'dark' ? 'dark' : 'light'
                );
            } catch (error) {
                document.documentElement.setAttribute('data-admin-theme', 'light');
            }
        })();
    </script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') | Medicare+</title>

    <link rel="stylesheet"
          href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">

    @stack('styles')
</head>

<body>

<div class="admin-layout">

    <!-- SIDEBAR -->
    <aside class="admin-sidebar" aria-label="Admin sidebar">

    
        <a href="{{ route('admin.system-backups.index') }}"
   class="sidebar-link {{ request()->routeIs('admin.system-backups.*') ? 'active' : '' }}">

    <span class="nav-icon" aria-hidden="true">↶</span>

    <span>Backup & Restore</span>

</a>

        <!-- LOGO -->
        <a href="{{ route('admin.dashboard') }}" class="admin-logo">
            <span class="admin-logo-icon" aria-hidden="true">+</span>

            <span>
                Medicare<span class="logo-plus">+</span>
                <small>ADMINISTRATION</small>
            </span>
        </a>

        <div class="sidebar-group-title">MAIN MENU</div>

        <nav class="admin-navigation" aria-label="Admin navigation">

            <!-- DASHBOARD OVERVIEW -->
            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
               @if(request()->routeIs('admin.dashboard')) aria-current="page" @endif>

                <span class="nav-icon" aria-hidden="true">▦</span>
                <span>Dashboard Overview</span>
            </a>

            <div class="sidebar-group-title">CLINIC MANAGEMENT</div>

            <!-- PENDING APPOINTMENTS COUNT -->
            @php
                $sidebarPendingAppointments = \App\Models\Appointment::query()
                    ->where('status', 'pending')
                    ->count();
            @endphp

            <!-- APPOINTMENTS -->
            <a href="{{ route('admin.appointments.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.appointments.*') ? 'active' : '' }}"
               @if(request()->routeIs('admin.appointments.*')) aria-current="page" @endif>

                <span class="nav-icon" aria-hidden="true">▤</span>
                <span>Appointments</span>

                @if($sidebarPendingAppointments > 0)
                    <span class="sidebar-appointment-count">
                        {{ $sidebarPendingAppointments > 99 ? '99+' : $sidebarPendingAppointments }}
                    </span>
                @endif
            </a>

            <!-- DOCTORS MANAGEMENT -->
            <a href="{{ route('admin.doctors.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.doctors.*') ? 'active' : '' }}"
               @if(request()->routeIs('admin.doctors.*')) aria-current="page" @endif>

                <span class="nav-icon" aria-hidden="true">♙</span>
                <span>Doctors Management</span>
            </a>

            <!-- DEPARTMENTS MANAGEMENT -->
            <a href="{{ route('admin.departments.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.departments.*') ? 'active' : '' }}"
               @if(request()->routeIs('admin.departments.*')) aria-current="page" @endif>

                <span class="nav-icon" aria-hidden="true">▧</span>
                <span>Departments</span>
            </a>

            <!-- SERVICES MANAGEMENT -->
            <a href="{{ route('admin.services.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">

                <span class="nav-icon" aria-hidden="true">✦</span>
                <span>Services</span>
            </a>

            <div class="sidebar-group-title">WEBSITE CONTENT</div>

            <!-- PAGE EDITOR -->
            <a href="{{ route('admin.website-content.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.website-content.*') ? 'active' : '' }}"
               @if(request()->routeIs('admin.website-content.*')) aria-current="page" @endif>

                <span class="nav-icon" aria-hidden="true">▣</span>
                <span>Page Editor</span>
            </a>

            
<a href="{{ route('admin.content-revisions.index') }}"
   class="sidebar-link {{ request()->routeIs('admin.content-revisions.*') ? 'active' : '' }}"
   @if(request()->routeIs('admin.content-revisions.*'))
       aria-current="page"
   @endif>

    <span class="nav-icon" aria-hidden="true">
        ↶
    </span>

    <span>Content Restore</span>

</a>


            
<!-- MEDIA LIBRARY -->
<a href="{{ route('admin.media-library.index') }}"
   class="sidebar-link {{ request()->routeIs('admin.media-library.*') ? 'active' : '' }}"
   @if(request()->routeIs('admin.media-library.*')) aria-current="page" @endif>
    <span class="nav-icon" aria-hidden="true">▥</span>
    <span>Media Library</span>
</a>

           <!-- NAVBAR & FOOTER -->
<a href="{{ route('admin.site-settings.edit') }}"
   class="sidebar-link {{ request()->routeIs('admin.site-settings.*') ? 'active' : '' }}">
    <span class="nav-icon" aria-hidden="true">☰</span>
    <span>Navbar &amp; Footer</span>
</a>

            <!-- CONTACT MESSAGES -->
            <a href="{{ route('admin.contact-messages.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.contact-messages.*') ? 'active' : '' }}"
               @if(request()->routeIs('admin.contact-messages.*')) aria-current="page" @endif>

                <span class="nav-icon" aria-hidden="true">✉</span>
                <span>Contact Messages</span>
            </a>

           
<!-- WEBSITE SETTINGS -->
<a href="{{ route('admin.website-settings.index') }}"
   class="sidebar-link {{ request()->routeIs('admin.website-settings.*') ? 'active' : '' }}">
    <span class="nav-icon" aria-hidden="true">⚙</span>
    <span>Website Settings</span>
</a>


            
<!-- ACTIVITY LOGS -->
<a href="{{ route('admin.activity-logs.index') }}"
   class="sidebar-link {{ request()->routeIs('admin.activity-logs.*') ? 'active' : '' }}"
   @if(request()->routeIs('admin.activity-logs.*')) aria-current="page" @endif>
    <span class="nav-icon" aria-hidden="true">◷</span>
    <span>Activity Logs</span>
</a>

        </nav>

        <!-- SIDEBAR FOOTER -->
        <div class="sidebar-bottom">

            <a href="{{ route('home') }}"
               target="_blank"
               rel="noopener noreferrer"
               class="sidebar-link">

                <span class="nav-icon" aria-hidden="true">↗</span>
                <span>View Website</span>
            </a>

            <!-- LOGOUT -->
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf

                <button type="submit" class="sidebar-link logout-button">
                    <span class="nav-icon" aria-hidden="true">↪</span>
                    <span>Logout</span>
                </button>
            </form>

        </div>

    </aside>

    <!-- MAIN AREA -->
    <div class="admin-main">

        <!-- HEADER -->
        <header class="admin-header">

            <div class="admin-header-copy">

                <span class="admin-header-label">MEDICARE+ CMS</span>

                <h1>
                    @yield('page-title', 'Dashboard Overview')
                </h1>

                <p>
                    @yield('page-description', 'Manage your clinic and website from one place.')
                </p>

            </div>

            <!-- ADMIN THEME TOGGLE -->
            <button
                type="button"
                class="admin-theme-toggle"
                id="adminThemeToggle"
                aria-label="Switch to dark mode"
                aria-pressed="false"
            >
                <span class="admin-theme-icon"
                      id="adminThemeIcon"
                      aria-hidden="true">☾</span>

                <span class="admin-theme-text"
                      id="adminThemeText">Dark Mode</span>
            </button>

            <!-- ADMIN PROFILE -->
            <div class="admin-profile">

                <span class="profile-avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </span>

                <div>
                    <strong>{{ auth()->user()->name ?? 'Admin' }}</strong>
                    <small>Administrator</small>
                </div>

            </div>

        </header>

        <!-- CONTENT -->
        <main class="admin-content">

            @if(session('success'))
                <div class="admin-alert success" role="status">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('warning'))
                <div class="admin-alert warning" role="status">
                    {{ session('warning') }}
                </div>
            @endif

            @if(session('error'))
                <div class="admin-alert error" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')

        </main>

    </div>

</div>

@stack('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    const toggle = document.getElementById('adminThemeToggle');
    const icon = document.getElementById('adminThemeIcon');
    const text = document.getElementById('adminThemeText');

    if (!toggle || !icon || !text) {
        return;
    }

    function updateThemeButton() {
        const isDark =
            document.documentElement.getAttribute('data-admin-theme') === 'dark';

        icon.textContent = isDark ? '☀' : '☾';
        text.textContent = isDark ? 'Light Mode' : 'Dark Mode';

        toggle.setAttribute('aria-pressed', String(isDark));

        toggle.setAttribute(
            'aria-label',
            isDark ? 'Switch to light mode' : 'Switch to dark mode'
        );
    }

    updateThemeButton();

    toggle.addEventListener('click', function () {

        const isDark =
            document.documentElement.getAttribute('data-admin-theme') === 'dark';

        const nextTheme = isDark ? 'light' : 'dark';

        document.documentElement.setAttribute(
            'data-admin-theme',
            nextTheme
        );

        try {
            localStorage.setItem('medicare_admin_theme', nextTheme);
        } catch (error) {
            // Keep the selected theme active for this page.
        }

        updateThemeButton();
    });

});
</script>

</body>
</html>
