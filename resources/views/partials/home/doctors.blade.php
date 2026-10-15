<section class="doctors-section">

    <div class="container">

        <div class="section-heading">

            <span class="section-label">
                Our Doctors
            </span>

            <h2>
                Meet Our Medical Specialists
            </h2>

            <p>
                Our experienced doctors are committed to
                providing professional, compassionate and
                reliable healthcare.
            </p>

        </div>


        <div class="doctors-grid">

            <div class="doctor-card">

                <div class="doctor-image-wrapper">

                    <img
                        src="{{ asset('images/doctor-1.jpg') }}"
                        alt="Dr. Sarah Ahmed"
                        class="doctor-image"
                    >

                </div>

                <div class="doctor-content">

                    <span class="doctor-speciality">
                        Cardiologist
                    </span>

                    <h3>
                        Dr. Sarah Ahmed
                    </h3>

                    <p>
                        10+ Years Experience
                    </p>

                    <a href="{{ route('doctors') }}">
                        
                       <a href="{{ route('doctors') }}" class="doctor-btn">
                            View Profile
                    </a>

                </div>

            </div>


            <div class="doctor-card">

                <div class="doctor-image-wrapper">

                    <img
                        src="{{ asset('images/doctor-2.jpg') }}"
                        alt="Dr. Ali Raza"
                        class="doctor-image"
                    >

                </div>

                <div class="doctor-content">

                    <span class="doctor-speciality">
                        Neurologist
                    </span>

                    <h3>
                        Dr. Ali Raza
                    </h3>

                    <p>
                        8+ Years Experience
                    </p>

                    <a href="{{ route('doctors') }}" class="doctor-btn">
                        View Profile
                    </a>

                </div>

            </div>


            <div class="doctor-card">

                <div class="doctor-image-wrapper">

                    <img
                        src="{{ asset('images/doctor-3.jpg') }}"
                        alt="Dr. Ayesha Khan"
                        class="doctor-image"
                    >

                </div>

                <div class="doctor-content">

                    <span class="doctor-speciality">
                        Pediatrician
                    </span>

                    <h3>
                        Dr. Ayesha Khan
                    </h3>

                    <p>
                        7+ Years Experience
                    </p>

                    <a href="{{ route('doctors') }}" class="doctor-btn">
                        View Profile
                  </a>

                </div>

            </div>


            <div class="doctor-card">

                <div class="doctor-image-wrapper">

                    <img
                        src="{{ asset('images/doctor-4.jpg') }}"
                        alt="Dr. Hamza Malik"
                        class="doctor-image"
                    >

                </div>

                <div class="doctor-content">

                    <span class="doctor-speciality">
                        Orthopedic Specialist
                    </span>

                    <h3>
                        Dr. Hamza Malik
                    </h3>

                    <p>
                        9+ Years Experience
                    </p>

                    <a href="#" class="doctor-btn">
                        View Profile
                    </a>

                </div>

            </div>

        </div>


        <div class="doctors-action">

           <a href="{{ route('doctors') }}" class="doctors-view-btn">
               View All Doctors
           </a>

        </div>

    </div>

</section>