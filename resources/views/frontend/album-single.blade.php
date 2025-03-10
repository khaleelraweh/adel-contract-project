@extends('layouts.app')

@section('style')
    <style>
        .gallery-img {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
@endsection

@section('content')
    <!-- Main content Start -->
    <div class="main-content">
        <!-- Breadcrumbs Start -->
        <div class="rs-breadcrumbs breadcrumbs-overlay">
            <div class="breadcrumbs-img">
                @php
                    $imagePath = public_path('assets/site_settings/' . $siteSettings['site_img']->value);
                @endphp

                <img src="{{ $siteSettings['site_img']->value && file_exists($imagePath)
                    ? asset('assets/site_settings/' . $siteSettings['site_img']->value)
                    : asset('image/not_found/placeholder2.jpg') }}"
                    alt="{{ $siteSettings['site_name']->value }}">

            </div>
            <div class="breadcrumbs-text ">
                <h1 class="page-title">
                    {{ __('panel.photo_album') }}
                </h1>
                <ul>
                    <li>
                        <a class="active" href="{{ route('frontend.index') }}">{{ __('panel.main') }}</a>
                    </li>
                    <li>
                        {{ $albums->title }}
                    </li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumbs End -->



        <!-- Events Section Start -->
        <div class="rs-gallery style4 px-4 py-4">
            <div class="row ">
                @if ($albums->photos)
                    @foreach ($albums->photos as $media)
                        <div class="col-lg-4 mb-3 col-sm-6">
                            <div class="gallery-part">
                                <div class="gallery-img">
                                    <a class="image-popup" href="{{ asset('assets/albums/' . $media->file_name) }}"><img
                                            src="{{ asset('assets/albums/' . $media->file_name) }}" alt=""></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
        <!-- Events Section End -->
    </div>
    <!-- Main content End -->
@endsection
