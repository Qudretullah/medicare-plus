@extends('layouts.app')

@section('title', 'Home | Medicare+')

@section('content')

    @include('partials.home.hero')

    @include('partials.home.stats')

    @include('partials.home.about')

    @include('partials.home.departments')

    @include('partials.home.doctors')

    @include('partials.home.testimonials')

    @include('partials.home.appointment-cta')

@endsection