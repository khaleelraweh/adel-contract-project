<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-7 pt-94 pb-70 md-pt-64 md-pb-70">
            <div id="rs-blog" class="rs-blog rs-news-events main-home ">
                <div class="container">
                    <div class="sec-title mb-40 md-mb-20 text-left">
                        <h2 class="title mb-0 header-news">
                            <a href="{{ route('frontend.news_list') }}">
                                {{ __('panel.university_news') }}
                            </a>
                        </h2>
                    </div>

                    <div class="rs-carousel owl-carousel" data-loop="true" data-items="2" data-margin="30"
                        data-autoplay="true" data-hoverpause="true" data-autoplay-timeout="5000" data-smart-speed="800"
                        data-dots="false" data-nav="false" data-nav-speed="false" data-center-mode="false"
                        data-mobile-device="1" data-mobile-device-nav="false" data-mobile-device-dots="false"
                        data-ipad-device="1" data-ipad-device-nav="false" data-ipad-device-dots="false"
                        data-ipad-device2="1" data-ipad-device-nav2="false" data-ipad-device-dots2="false"
                        data-md-device="2" data-md-device-nav="false" data-md-device-dots="false">
                        @foreach ($news as $news)
                            <div class="blog-item">
                                <div class="image-part">
                                    @php
                                        if (
                                            $news->photos->first() != null &&
                                            $news->photos->first()->file_name != null
                                        ) {
                                            $news_img = asset('assets/news/' . $news->photos->first()->file_name);

                                            if (
                                                !file_exists(
                                                    public_path('assets/news/' . $news->photos->first()->file_name),
                                                )
                                            ) {
                                                $news_img = asset('image/not_found/placeholder.jpg');
                                            }
                                        } else {
                                            $news_img = asset('image/not_found/placeholder.jpg');
                                        }
                                    @endphp
                                    <img src="{{ $news_img }}" alt="">
                                </div>
                                <div class="blog-content">

                                    <ul class="blog-meta">
                                        {{-- <li><i class="fa fa-user-o"></i> {{ $news->created_by }}</li> --}}
                                        <li>
                                            <?php
                                            $date = $news->created_at;
                                            $higriShortDate = Alkoumi\LaravelHijriDate\Hijri::ShortDate($date); // With optional Timestamp It will return Hijri Date of [$date] => Results "1442/05/12"
                                            ?>
                                            <i class="fa fa-calendar"></i>
                                            {{ $higriShortDate . ' ' . __('panel.calendar_hijri') }}
                                            <span>{{ __('panel.corresponding_to') }} </span>
                                            {{ $news->created_at->isoFormat('YYYY/MM/DD') . ' ' . __('panel.calendar_gregorian') }}

                                        </li>

                                    </ul>

                                    <h3 class="title">
                                        <a href="{{ route('frontend.news_single', $news->slug) }}">

                                            {!! \Illuminate\Support\Str::words($news->title, 8, '...') !!}

                                        </a>
                                    </h3>

                                    <div class="desc">
                                        {!! \Illuminate\Support\Str::words($news->content, 10, '...') !!}
                                    </div>
                                    <div class="btn-btm">
                                        <div class="cat-list">
                                            {{-- <ul class="post-categories">
                                                <li><a href="#">{{ $news->created_by }}</a></li>
                                            </ul> --}}
                                        </div>
                                        <div class="rs-view-btn">
                                            <a
                                                href="{{ route('frontend.news_single', $news->slug) }}">{{ __('panel.read_more') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-5  pt-94 pb-70 md-pt-64 md-pb-70">
            <div id="rs-blog" class="rs-blog style1 ">
                <div class="container">
                    <div class="sec-title mb-40 md-mb-20 text-left">
                        <h2 class="title mb-0 header-events main-color">
                            <a href="{{ route('frontend.events_list') }}">
                                {{ __('panel.university_activities') }}
                            </a>
                        </h2>
                    </div>
                    <div class="row bg2 event-row">
                        <div class="col-lg-12 col-md-12">
                            @foreach ($events as $index => $event)
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="events-short {{ $loop->last ? '' : 'mb-15' }}  wow fadeInUp"
                                            data-wow-delay="{{ ($index + 1) * 100 }}ms" data-wow-duration="2000ms">
                                            <div class="date-part">
                                                <span
                                                    class="month">{{ $event->created_at->translatedFormat('F Y') }}</span>
                                                <div class="date">{{ $event->created_at->format('d') }}</div>
                                            </div>
                                            <div class="content-part">
                                                <h4 class="title mb-0">
                                                    <a href="{{ route('frontend.event_single', $event->slug) }}">
                                                        {{ $event->title }}
                                                    </a>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
