<div class="rs-degree rs-college-institute style1 modify gray-bg pt-100 pb-100 md-pt-70 md-pb-70 bg2">
    <div class="container">
        <div class="row y-middle">
            <div class="col-lg-10 col-md-12 mb-30">
                <div class="rs-carousel owl-carousel" data-loop="true" data-items="3" data-margin="30" data-autoplay="true"
                    data-hoverpause="true" data-autoplay-timeout="5000" data-smart-speed="800" data-dots="false"
                    data-nav="false" data-nav-speed="false" data-center-mode="false" data-mobile-device="1"
                    data-mobile-device-nav="false" data-mobile-device-dots="false" data-ipad-device="2"
                    data-ipad-device-nav="false" data-ipad-device-dots="false" data-ipad-device2="1"
                    data-ipad-device-nav2="false" data-ipad-device-dots2="false" data-md-device="3"
                    data-md-device-nav="false" data-md-device-dots="false">
                    @foreach ($web_menus->where('section', 2) as $academic_program_menu)
                        <div class="blog-item">
                            <div class="degree-wrap">
                                @php
                                    if (
                                        $academic_program_menu->photos->first() != null &&
                                        $academic_program_menu->photos->first()->file_name != null
                                    ) {
                                        $academic_program_menu_img = asset(
                                            'assets/academic_program_menus/' .
                                                $academic_program_menu->photos->first()->file_name,
                                        );

                                        if (
                                            !file_exists(
                                                public_path(
                                                    'assets/academic_program_menus/' .
                                                        $academic_program_menu->photos->first()->file_name,
                                                ),
                                            )
                                        ) {
                                            $academic_program_menu_img = asset('images/not_found/placeholder.jpg');
                                        }
                                    } else {
                                        $academic_program_menu_img = asset('image/not_found/placeholder.jpg');
                                    }
                                @endphp

                                <img src="{{ $academic_program_menu_img }}" alt="">
                                <div class="title-part">
                                    <h4 class="title">{{ $academic_program_menu->title }}</h4>
                                </div>
                                <div class="content-part">
                                    <h4 class="title"><a href="#">{{ $academic_program_menu->title }}</a></h4>
                                    <p class="desc">
                                        {!! $academic_program_menu->description !!}
                                    </p>
                                    <div class="btn-part">
                                        <a href="#">{{ __('panel.read_more') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
            <div class="col-lg-2 col-md-12 mb-30">
                <div class="sec-title wow fadeInUp text-center " data-wow-delay="300ms" data-wow-duration="2000ms">
                    <h3 class="title mb-0 header-colleges">{{ __('panel.colleges_and_institutes') }}</h3>
                    <div class=" primary header-college-subtitle">{{ __('panel.introductory_tour') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
