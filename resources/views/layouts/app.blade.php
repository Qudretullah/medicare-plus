
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Medicare+')</title>

    <meta
        name="description"
        content="Medicare+ Clinic Appointment System"
    >

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <script src="{{ asset('js/app.js') }}" defer></script>

    <script
        src="{{ asset('js/appointment-arctic.js') }}"
        defer
    ></script>

</head>

<body>

    {{-- ===== PREMIUM HEARTBEAT PAGE LOADER ===== --}}

    <div
        id="medicarePageLoader"
        class="medicare-page-loader"
        role="status"
        aria-label="Loading page"
        aria-live="polite"
        aria-hidden="true"
        inert
    >
        <div class="medicare-loader-content">

            <div class="medicare-loader-heart">
                <svg
                    viewBox="0 0 100 100"
                    xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true"
                >
                    <path
                        d="M50 85 C40 76 10 55 10 35
                           C10 15 35 10 50 30
                           C65 10 90 15 90 35
                           C90 55 60 76 50 85 Z"
                    />
                </svg>
            </div>

            <div class="medicare-loader-ecg">
                <svg
                    viewBox="0 0 240 70"
                    xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true"
                >
                    <path
                        d="M0 35 H65 L80 35
                           L95 12 L112 60
                           L130 10 L145 35
                           H240"
                    />
                </svg>
            </div>

            <div class="medicare-loader-brand">
                Medicare<span>+</span>
            </div>

            <p class="medicare-loader-text">
                Taking care of your health...
            </p>

        </div>
    </div>


    {{-- ===== WEBSITE NAVBAR ===== --}}
    @include('partials.navbar')


    {{-- ===== PAGE CONTENT ===== --}}
    <main>
        @yield('content')
    </main>


    {{-- ===== WEBSITE FOOTER ===== --}}
    @include('partials.footer')

</body>

</html>
