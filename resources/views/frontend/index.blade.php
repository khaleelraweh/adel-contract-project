@extends('layouts.app')

@section('content')
    @include('frontend.home.main-slider')

    @include('frontend.home.news-events')

    @include('frontend.home.academic-programs')

    @include('frontend.home.statistics')

    @include('frontend.home.playlists')

    @include('frontend.home.albums')

    {{-- d-none --}}
    @include('frontend.home.president_speech')

    {{-- d-none --}}
    @include('frontend.home.common_questions')

    {{-- d-none --}}
    @include('frontend.home.testimonial')
@endsection
