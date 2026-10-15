
/* ==========================================
   MEDICARE+ - COMPLETE JAVASCRIPT
========================================== */


/* ===== 1. MOBILE NAVBAR ===== */

const menuBtn = document.getElementById('menuBtn');
const navLinks = document.getElementById('navLinks');

if (menuBtn && navLinks) {

    menuBtn.addEventListener('click', function () {

        navLinks.classList.toggle('active');

        if (navLinks.classList.contains('active')) {
            menuBtn.textContent = '✕';
            menuBtn.setAttribute('aria-label', 'Close menu');
        } else {
            menuBtn.textContent = '☰';
            menuBtn.setAttribute('aria-label', 'Open menu');
        }
    });

    const navItems = navLinks.querySelectorAll('a');

    navItems.forEach(function (link) {

        link.addEventListener('click', function () {
            navLinks.classList.remove('active');
            menuBtn.textContent = '☰';
            menuBtn.setAttribute('aria-label', 'Open menu');
        });

    });
}


/* ===== 2. APPOINTMENT ELEMENTS ===== */

const appointmentForm = document.getElementById('appointmentForm');
const appointmentDate = document.getElementById('appointmentDate');
const appointmentTimeInput = document.getElementById('appointmentTime');

/* ===== 3. DEPARTMENT WISE DOCTORS ===== */

// Doctor selection is handled dynamically by
// resources/views/appointment/create.blade.php.
//
// Doctor and department data comes from the Laravel
// database rather than a hardcoded JavaScript list.

/* ===== 3. DEPARTMENT WISE DOCTORS ===== */

/*
 | Doctor dropdown is managed dynamically inside:
 | resources/views/appointment/create.blade.php
 |
 | Departments and doctors are loaded from the database.
 | No duplicate dropdown logic is required here.
 */


/* ===== 4. APPOINTMENT DATE & TIME VALIDATION ===== */

function getLocalDateTime() {

    const now = new Date();

    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const day = String(now.getDate()).padStart(2, '0');

    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');

    return {
        date: `${year}-${month}-${day}`,
        time: `${hours}:${minutes}`
    };
}

function validateAppointmentDateTime() {

    if (!appointmentDate || !appointmentTimeInput) {
        return true;
    }

    const current = getLocalDateTime();

    const selectedDate = appointmentDate.value;
    const selectedTime = appointmentTimeInput.value;

    // Hospital working hours
    const openingTime = '09:00';
    const closingTime = '17:00';

    appointmentDate.min = current.date;
    appointmentTimeInput.min = openingTime;
    appointmentTimeInput.max = closingTime;

    // Clear previous errors
    appointmentDate.setCustomValidity('');
    appointmentTimeInput.setCustomValidity('');

    // Check whether date is selected
    if (!selectedDate) {
        return appointmentDate.checkValidity();
    }

    // Prevent past dates
    if (selectedDate < current.date) {

        appointmentDate.setCustomValidity(
            'Please select today or a future date.'
        );

        return false;
    }

    // Sunday closed
    const selectedDay = new Date(
        selectedDate + 'T12:00:00'
    ).getDay();

    if (selectedDay === 0) {

        appointmentDate.setCustomValidity(
            'Appointments are not available on Sundays.'
        );

        return false;
    }

    // Wait until time is selected
    if (!selectedTime) {
        return appointmentTimeInput.checkValidity();
    }

    // Check hospital hours
    if (
        selectedTime < openingTime ||
        selectedTime > closingTime
    ) {

        appointmentTimeInput.setCustomValidity(
            'Please select a time between 9:00 AM and 5:00 PM.'
        );

        return false;
    }

    // Prevent past times on today's date
    if (
        selectedDate === current.date &&
        selectedTime <= current.time
    ) {

        appointmentTimeInput.setCustomValidity(
            'Please select a future appointment time.'
        );

        return false;
    }

    return true;
}


/* ===== 5. DATE & TIME EVENT LISTENERS ===== */

if (appointmentDate && appointmentTimeInput) {

    appointmentDate.addEventListener(
        'change',
        validateAppointmentDateTime
    );

    appointmentDate.addEventListener(
        'input',
        validateAppointmentDateTime
    );

    appointmentTimeInput.addEventListener(
        'change',
        validateAppointmentDateTime
    );

    appointmentTimeInput.addEventListener(
        'input',
        validateAppointmentDateTime
    );

    validateAppointmentDateTime();
}


/* ===== 6. APPOINTMENT FORM SUBMISSION ===== */

if (appointmentForm) {

    let isSubmitting = false;

    appointmentForm.addEventListener('submit', function (event) {

        // Validate date and time before submission
        const validDateTime = validateAppointmentDateTime();

        if (!validDateTime || !appointmentForm.checkValidity()) {

            event.preventDefault();
            appointmentForm.reportValidity();

            return;
        }

        // Prevent duplicate form submission
        if (isSubmitting) {
            event.preventDefault();
            return;
        }

        isSubmitting = true;

        // Loading button
        const submitButton = appointmentForm.querySelector(
            'button[type="submit"]'
        );

        if (submitButton) {

            submitButton.disabled = true;
            submitButton.textContent = 'Booking Appointment...';
        }

        // Normal Laravel POST submission
    });
}


/* ===== 7. COPY BOOKING REFERENCE ===== */

document.addEventListener('click', function (event) {

    const button = event.target.closest('#copyBookingReference');

    if (!button) {
        return;
    }

    const referenceElement = document.getElementById(
        'bookingReference'
    );

    if (!referenceElement) {
        return;
    }

    const reference = referenceElement.textContent.trim();

    if (!reference) {
        return;
    }

    const originalText = 'Copy Reference';

    function showCopyResult(message) {

        button.textContent = message;

        if (button.copyResetTimer) {
            clearTimeout(button.copyResetTimer);
        }

        button.copyResetTimer = setTimeout(function () {
            button.textContent = originalText;
        }, 2500);
    }

    // Fallback clipboard method
    function fallbackCopy() {

        const textArea = document.createElement('textarea');

        textArea.value = reference;
        textArea.setAttribute('readonly', '');

        textArea.style.position = 'fixed';
        textArea.style.top = '0';
        textArea.style.left = '0';
        textArea.style.opacity = '0';

        document.body.appendChild(textArea);

        textArea.focus();
        textArea.select();

        let copied = false;

        try {
            copied = document.execCommand('copy');
        } catch (error) {
            console.error('Fallback clipboard error:', error);
        }

        textArea.remove();

        return copied;
    }

    // Try copy during the real button click
    if (fallbackCopy()) {

        showCopyResult('Copied!');
        return;
    }

    // Modern Clipboard API
    if (navigator.clipboard && window.isSecureContext) {

        navigator.clipboard.writeText(reference)
            .then(function () {

                showCopyResult('Copied!');

            })
            .catch(function (error) {

                console.error('Clipboard error:', error);

                showCopyResult('Select & Copy');

                // Let user copy manually
                const selection = window.getSelection();
                const range = document.createRange();

                range.selectNodeContents(referenceElement);

                selection.removeAllRanges();
                selection.addRange(range);
            });

    } else {

        showCopyResult('Select & Copy');

        const selection = window.getSelection();
        const range = document.createRange();

        range.selectNodeContents(referenceElement);

        selection.removeAllRanges();
        selection.addRange(range);
    }
});

/* ==========================================
   MEDICARE+ HERO & STATS COUNTER ANIMATION
========================================== */

(function () {

    const counters = document.querySelectorAll(
        '.hero-feature strong, .stats-section .stat-card h3'
    );

    if (!counters.length) return;

    const reduceMotion = window.matchMedia(
        '(prefers-reduced-motion: reduce)'
    ).matches;

    function animateCounter(element) {

        if (element.dataset.counted === 'true') return;

        const original = element.textContent.trim();

        // 24/7 jaisay non-numeric labels skip karo
        if (!/^[\d,]+\+?$/.test(original)) return;

        const target = Number(
            element.dataset.count ||
            original.replace(/[,+]/g, '')
        );

        if (!Number.isFinite(target)) return;

        element.dataset.counted = 'true';

        const suffix = original.endsWith('+') ? '+' : '';
        const useCommas = original.includes(',');
        const format = value =>
            (useCommas
                ? Math.round(value).toLocaleString('en-US')
                : String(Math.round(value))) + suffix;

        if (reduceMotion) {
            element.textContent = format(target);
            return;
        }

        const duration = 1800;
        let startTime = null;

        function update(timestamp) {

            if (startTime === null) startTime = timestamp;

            const progress = Math.min(
                (timestamp - startTime) / duration,
                1
            );

            const eased = 1 - Math.pow(1 - progress, 3);

            element.textContent = format(target * eased);

            if (progress < 1) {
                requestAnimationFrame(update);
            } else {
                element.textContent = original;
            }
        }

        requestAnimationFrame(update);
    }

    if ('IntersectionObserver' in window) {

        const observer = new IntersectionObserver(entries => {

            entries.forEach(entry => {

                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    observer.unobserve(entry.target);
                }

            });

        }, { threshold: 0.2 });

        counters.forEach(counter => observer.observe(counter));

    } else {
        counters.forEach(animateCounter);
    }

})();

/* ===== MEDICARE+ AUTO HERO IMAGE SLIDER ===== */

(function () {

    const slider = document.getElementById('heroSlider');

    if (!slider) return;

    const slides = slider.querySelectorAll(
        '.hero-background-image'
    );

    if (slides.length < 2) return;

    let currentSlide = 0;
    const slideDuration = 5000;

    const reduceMotion = window.matchMedia(
        '(prefers-reduced-motion: reduce)'
    ).matches;

    if (reduceMotion) return;

    setInterval(function () {

        slides[currentSlide].classList.remove('active');

        currentSlide = (currentSlide + 1) % slides.length;

        slides[currentSlide].classList.add('active');

    }, slideDuration);

})();

/* ==========================================
   MEDICARE+ HEARTBEAT PAGE LOADER
   STEP 28.14.4
========================================== */

(function () {
    "use strict";

    const loader = document.getElementById("medicarePageLoader");

    if (!loader) return;

    const SHOW_DELAY = 180;
    let loaderTimer = null;
    let navigationStarted = false;

    function showLoader() {
        loader.classList.add("is-active");
        loader.removeAttribute("inert");
        loader.setAttribute("aria-hidden", "false");
    }

    function hideLoader() {
        clearTimeout(loaderTimer);
        loaderTimer = null;
        navigationStarted = false;

        loader.classList.remove("is-active");
        loader.setAttribute("aria-hidden", "true");
        loader.setAttribute("inert", "");
    }

    function scheduleLoader() {
        if (navigationStarted) return;

        navigationStarted = true;

        loaderTimer = setTimeout(function () {
            if (navigationStarted) {
                showLoader();
            }
        }, SHOW_DELAY);
    }

    // Initially keep loader hidden.
    hideLoader();

    // Show loader for normal internal page navigation.
    document.addEventListener("click", function (event) {
        const link = event.target.closest("a[href]");

        if (!link || event.defaultPrevented) return;

        // Ignore modified clicks and non-left-clicks.
        if (
            event.button !== 0 ||
            event.ctrlKey ||
            event.metaKey ||
            event.shiftKey ||
            event.altKey
        ) {
            return;
        }

        // Ignore downloads and links opening new tabs.
        if (
            link.hasAttribute("download") ||
            (link.target && link.target !== "_self")
        ) {
            return;
        }

        const href = link.getAttribute("href");

        if (!href || href.startsWith("#")) return;

        let destination;

        try {
            destination = new URL(href, window.location.href);
        } catch (error) {
            return;
        }

        // Only handle HTTP/HTTPS links within the same website.
        if (
            !["http:", "https:"].includes(destination.protocol) ||
            destination.origin !== window.location.origin
        ) {
            return;
        }

        // Ignore links that only change the page fragment.
        if (
            destination.pathname === window.location.pathname &&
            destination.search === window.location.search
        ) {
            return;
        }

        scheduleLoader();
    });

    // If navigation completes before the delay, no flash occurs.
    window.addEventListener("pageshow", function () {
        hideLoader();
    });

    // Hide when the browser restores the current document.
    window.addEventListener("pagehide", function () {
        hideLoader();
    });

    // Handle cases where another script cancels navigation.
    window.addEventListener("focus", function () {
        if (!navigationStarted) return;

        // Do not keep a visible overlay for a cancelled navigation.
        if (document.visibilityState === "visible") {
            clearTimeout(loaderTimer);

            loaderTimer = setTimeout(function () {
                hideLoader();
            }, 1200);
        }
    });

})();

/* ==========================================
   MEDICARE+ LIGHT / DARK MODE
========================================== */

(function () {
    const storageKey = 'medicare-theme';
    const root = document.documentElement;

    function getSavedTheme() {
        try {
            return localStorage.getItem(storageKey);
        } catch (error) {
            return null;
        }
    }

    function saveTheme(theme) {
        try {
            localStorage.setItem(storageKey, theme);
        } catch (error) {
            // Theme still works if storage is unavailable.
        }
    }

    function applyTheme(theme) {
        const isDark = theme === 'dark';

        root.setAttribute('data-theme', isDark ? 'dark' : 'light');
        root.style.colorScheme = isDark ? 'dark' : 'light';

        const toggle = document.getElementById('medicareThemeToggle');

        if (toggle) {
            toggle.setAttribute('aria-pressed', String(isDark));
            toggle.setAttribute(
                'aria-label',
                isDark ? 'Switch to light mode' : 'Switch to dark mode'
            );
            toggle.title = isDark ? 'Light mode' : 'Dark mode';
        }
    }

    const savedTheme = getSavedTheme();
    applyTheme(savedTheme === 'dark' ? 'dark' : 'light');

    document.addEventListener('DOMContentLoaded', function () {
        applyTheme(root.getAttribute('data-theme'));

        const toggle = document.getElementById('medicareThemeToggle');

        if (!toggle) {
            return;
        }

        toggle.addEventListener('click', function () {
            const nextTheme =
                root.getAttribute('data-theme') === 'dark'
                    ? 'light'
                    : 'dark';

            applyTheme(nextTheme);
            saveTheme(nextTheme);
        });
    });
})();
