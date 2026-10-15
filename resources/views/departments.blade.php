
@extends('layouts.app')

@section('title', 'Departments | Medicare+')

@section('content')

<section class="departments-page-hero">

    <div class="container departments-page-hero-wrapper">

        <div class="departments-page-hero-content">

            <span class="section-label">
                {{ $contentItems->get('departments_hero_label')?->value ?? 'Our Departments' }}
            </span>

            <h1>
                {{ $contentItems->get('departments_hero_heading')?->value ?? 'Specialized Care For' }}

                <span>
                    {{ $contentItems->get('departments_hero_highlight')?->value ?? 'Every Medical Need' }}
                </span>
            </h1>

            <p>
                {{ $contentItems->get('departments_hero_description')?->value ?? 'Explore our medical departments and find the right specialists, services and care for your healthcare needs.' }}
            </p>

        </div>

    </div>

</section>

<section class="departments-list-section">

    <div class="container">

        <div class="section-heading">

            <span class="section-label">
                {{ $contentItems->get('departments_list_label')?->value ?? 'Medical Specialties' }}
            </span>

            <h2>
                {{ $contentItems->get('departments_list_heading')?->value ?? 'Explore Our Departments' }}
            </h2>

            <p>
                {{ $contentItems->get('departments_list_description')?->value ?? 'Choose the right department and get care from experienced specialists.' }}
            </p>

        </div>

        <div class="departments-list-grid">

            @forelse($departments as $department)

                <div class="department-list-card">

                    <div class="department-list-icon">
                        {{ $department->icon ?: '✚' }}
                    </div>

                    <h3>
                        {{ $department->name }}
                    </h3>

                    <p>
                        {{ $department->short_description }}
                    </p>

                    {{-- Department detail pages will be connected later --}}
                    
<a href="{{ route('departments.show', $department->slug) }}"
   class="department-list-btn">
    View Department
    <span aria-hidden="true">→</span>
</a>


                </div>

            @empty

                <div class="departments-empty-state">
                    <h3>No Departments Available</h3>
                    <p>
                        Our medical departments will be
                        available here soon.
                    </p>
                </div>

            @endforelse

        </div>

    </div>

</section>

@endsection
