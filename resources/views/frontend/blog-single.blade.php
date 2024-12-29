@extends('layouts.app')

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
                    @switch(true)
                        @case(Route::is('frontend.blog_single'))
                            {{ __('panel.blog_single') }}
                        @break

                        @case(Route::is('frontend.news_single'))
                            {{ __('panel.news_single') }}
                        @break

                        @case(Route::is('frontend.event_single'))
                            {{ __('panel.event_single') }}
                        @break

                        @case(Route::is('frontend.blog_index'))
                            Blog Index
                        @break

                        @case(Route::is('frontend.contact'))
                            Contact Us
                        @break

                        @default
                            Default Title
                    @endswitch
                </h1>
                <ul>
                    <li>
                        <a class="active" href="{{ route('frontend.index') }}">{{ __('panel.main') }}</a>
                    </li>
                    <li>
                        {{ $post->title }}
                    </li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumbs End -->

        <!-- Blog Section Start -->
        <div class="rs-inner-blog orange-color pt-100 pb-40 md-pt-70 md-pb-70">
            <div class="container">
                <div class="blog-deatails">
                    <div class="bs-img">
                        @php
                            $defaultImg = asset('image/not_found/placeholder.jpg');
                            $post_img = $defaultImg; // Set a default image

                            switch (true) {
                                case Route::is('frontend.blog_single'):
                                    $post_img =
                                        $post->photos->first() && $post->photos->first()->file_name
                                            ? asset('assets/posts/' . $post->photos->first()->file_name)
                                            : $defaultImg;
                                    break;

                                case Route::is('frontend.news_single'):
                                    $post_img =
                                        $post->photos->first() && $post->photos->first()->file_name
                                            ? asset('assets/news/' . $post->photos->first()->file_name)
                                            : $defaultImg;
                                    break;

                                case Route::is('frontend.events'):
                                    $post_img =
                                        $post->photos->first() && $post->photos->first()->file_name
                                            ? asset('assets/events/' . $post->photos->first()->file_name)
                                            : $defaultImg;
                                    break;

                                // Add more cases as needed for other routes

                                default:
                                    $post_img = $defaultImg;
                                    break;
                            }

                            // Check if the file exists in public directory
                            if (!file_exists(public_path(parse_url($post_img, PHP_URL_PATH)))) {
                                $post_img = $defaultImg;
                            }
                        @endphp

                        <a href="#"><img style="width:100%;height:30em" src="{{ $post_img }}" alt=""></a>
                    </div>

                    <div class="blog-full">
                        <ul class="single-post-meta">
                            <li>

                                <?php
                                $date = $post->created_at;
                                $higriShortDate = Alkoumi\LaravelHijriDate\Hijri::ShortDate($date); // With optional Timestamp It will return Hijri Date of [$date] => Results "1442/05/12"
                                ?>

                                <span class="p-date">
                                    <i class="fa fa-calendar-check-o"></i>
                                    {{ $higriShortDate . ' ' . __('panel.calendar_hijri') }}

                                    <span>{{ __('panel.corresponding_to') }} </span>
                                    {{ $post->created_at->isoFormat('YYYY/MM/DD') . ' ' . __('panel.calendar_gregorian') }}
                                </span>
                            </li>
                            {{-- <li>
                                <span class="p-date">
                                    <i class="fa fa-user-o"></i>
                                    {{ $post->users && $post->users->isNotEmpty() ? $post->users->first()->full_name : __('panel.admin') }}
                                </span>
                            </li> --}}

                        </ul>
                        <div class="blog-desc">
                            <p>
                                {!! $post->content !!}
                            </p>
                        </div>



                    </div>
                </div>
            </div>
        </div>
        <!-- Blog Section End -->

        <!-- Blog section Start -->
        <div class="rs-inner-blog orange-color pt-40 pb-100 md-pt-70 md-pb-70">
            <div class="container">
                <div class="row">
                    @foreach ($post->photos->skip(1) as $photo)
                        <div class="col-lg-3">
                            @php
                                $defaultImg = asset('image/not_found/placeholder.jpg');
                                $photo_img = $defaultImg; // Set a default image

                                switch (true) {
                                    case Route::is('frontend.blog_single'):
                                        $photo_img =
                                            $photo && $photo->file_name
                                                ? asset('assets/posts/' . $photo->file_name)
                                                : $defaultImg;
                                        break;

                                    case Route::is('frontend.news_single'):
                                        $photo_img =
                                            $photo && $photo->file_name
                                                ? asset('assets/news/' . $photo->file_name)
                                                : $defaultImg;
                                        break;

                                    case Route::is('frontend.events'):
                                        $photo_img =
                                            $photo && $photo->file_name
                                                ? asset('assets/events/' . $photo->file_name)
                                                : $defaultImg;
                                        break;

                                    default:
                                        $photo_img = $defaultImg;
                                        break;
                                }

                                // Check if the file exists in public directory
                                if (!file_exists(public_path(parse_url($photo_img, PHP_URL_PATH)))) {
                                    $photo_img = $defaultImg;
                                }
                            @endphp

                            <img src="{{ $photo_img }}" alt="not found">
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
        <!-- Blog section End -->

    </div>
    <!-- Main content End -->
@endsection
