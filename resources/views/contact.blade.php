@extends('layouts.app')

@section('title', 'Contact | Medicare+')

@section('content')

<section class="contact-page-hero">

    <div class="container contact-page-hero-wrapper">

        <div class="contact-page-hero-content">

            <span class="section-label">
                Contact Us
            </span>

            <h1>
                We’re Here To
                <span>Help You</span>
            </h1>

            <p>
                Have a question or need help with an appointment?
                Get in touch with the Medicare+ team and we’ll
                be happy to assist you.
            </p>

        </div>

    </div>

</section>


<section class="contact-main-section">

    <div class="container contact-main-wrapper">

        <div class="contact-info-area">

            <span class="section-label">
                Get In Touch
            </span>

            <h2>
                Contact <span>Medicare+</span>
            </h2>
            <p>
                Our team is available to help you with
                appointments, medical information and general
                healthcare questions.
            </p>


            <div class="contact-info-list">

                <div class="contact-info-card">

                    <div class="contact-info-icon">
                        📍
                    </div>

                    <div>
                        <h3>Clinic Address</h3>
                        <p>123 Medical Avenue, Lahore, Pakistan</p>
                    </div>

                </div>


                <div class="contact-info-card">

                    <div class="contact-info-icon">
                        📞
                    </div>

                    <div>
                        <h3>Phone Number</h3>
                        <p>+92 300 1234567</p>
                    </div>

                </div>


                <div class="contact-info-card">

                    <div class="contact-info-icon">
                        ✉
                    </div>

                    <div>
                        <h3>Email Address</h3>
                        <p>info@medicareplus.pk</p>
                    </div>

                </div>


                <div class="contact-info-card">

                    <div class="contact-info-icon">
                        🕒
                    </div>

                    <div>
                        <h3>Working Hours</h3>
                        <p>Monday - Saturday: 8:00 AM - 8:00 PM</p>
                    </div>

                </div>

            </div>

        </div>


        <div class="contact-form-area">

            <h2>
                Send Us A Message
            </h2>

            <p>
                Fill out the form below and our team will
                get back to you as soon as possible.
            </p>
            
            
{{-- CONTACT FORM SUCCESS MESSAGE --}}
@if(session('success'))
    <div class="contact-form-alert contact-form-alert-success"
         role="status">
        <span aria-hidden="true">✓</span>
        <span>{{ session('success') }}</span>
    </div>
@endif

{{-- CONTACT FORM VALIDATION ERRORS --}}
@if($errors->any())
    <div class="contact-form-alert contact-form-alert-error"
         role="alert">

        <strong>Please correct the following:</strong>

        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>

    </div>
                @endif


            
<form
    class="contact-form"
    id="contactForm"
    action="{{ route('contact.store') }}"
    method="POST"
>
    @csrf


                <div class="contact-form-grid">

                    <div class="contact-form-group">

                        <label for="contactName">
                            Full Name
                        </label>

                        <input
                            type="text"
                            id="contactName"
                            name="name"
                            placeholder="Enter your name"
                            required
                        >

                    </div>


                    <div class="contact-form-group">

                        <label for="contactEmail">
                            Email Address
                        </label>

                        <input
                            type="email"
                            id="contactEmail"
                            name="email"
                            placeholder="Enter your email"
                            required
                        >

                    </div>


                    <div class="contact-form-group">

                        <label for="contactPhone">
                            Phone Number
                        </label>

                        <input
                            type="tel"
                            id="contactPhone"
                            name="phone"
                            placeholder="03XXXXXXXXX"
                            required
                        >

                    </div>


                    <div class="contact-form-group">

                        <label for="contactSubject">
                            Subject
                        </label>

                        <input
                            type="text"
                            id="contactSubject"
                            name="subject"
                            placeholder="Enter subject"
                            required
                        >

                    </div>

                </div>


                <div class="contact-form-group">

                    <label for="contactMessage">
                        Message
                    </label>

                    <textarea
                        id="contactMessage"
                        name="message"
                        rows="6"
                        placeholder="Write your message"
                        required
                    ></textarea>

                </div>


                <button
                    type="submit"
                    class="contact-submit-btn"
                >
                    Send Message
                </button>

            </form>

        </div>

    </div>

</section>

@endsection