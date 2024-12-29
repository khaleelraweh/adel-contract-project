<?php
$parsedUrl = parse_url($siteSettings['site_email1']->value, PHP_URL_HOST);

// Remove 'www.' if it exists
$domain = preg_replace('/^www\./', '', $parsedUrl);

?>
<!--Full width header Start-->
<div class="full-width-header header-style2">
    <!--Header Start-->
    <header id="rs-header" class="rs-header">
        <!-- Topbar Area Start -->
        <div class="topbar-area">
            <div class="container">
                <div class="row y-middle">
                    <div class="col-md-7">
                        <ul class="topbar-contact">

                            <li>
                                <i class="fa fa-map"></i>
                                {{ $siteSettings['site_address']->value }}
                            </li>

                            <li>
                                <i class="fa fa-envelope-o"></i>
                                <a
                                    href="mailto:{{ $siteSettings['site_email1']->value ?? '' }}">contact&#64;{{ $domain ?? '' }}</a>
                            </li>
                            <li>
                                <i class="fa fa-phone"></i>
                                <a href="tel:+088589-8745">{{ $siteSettings['site_mobile']->value ?? '' }}</a>
                            </li>
                            <li>
                                {{ __('panel.f_fax') }}
                                <a href="tel:+088589-8745">{{ $siteSettings['site_phone']->value ?? '' }}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-5 text-right">
                        <ul class="topbar-right">

                            @if ($siteSettings['site_facebook']->value)
                                <li>
                                    <a href="{{ $siteSettings['site_facebook']->value }}" target="_blank">
                                        <span><i class="fa fa-facebook-f topbar-link-color"></i></span>
                                    </a>
                                </li>
                            @endif

                            @if ($siteSettings['site_youtube']->value)
                                <li>
                                    <a href="{{ $siteSettings['site_youtube']->value }}" target="_blank">
                                        <span><i class="fa fa-youtube topbar-link-color"></i></span>
                                    </a>
                                </li>
                            @endif

                            @if ($siteSettings['site_twitter']->value)
                                <li>
                                    <a href="{{ $siteSettings['site_twitter']->value }}" target="_blank">
                                        <span><i class="fa fa-twitter topbar-link-color"></i></span>
                                    </a>
                                </li>
                            @endif

                            @if ($siteSettings['site_instagram']->value)
                                <li>
                                    <a href="{{ $siteSettings['site_instagram']->value }}" target="_blank">
                                        <span><i class="fa fa-instagram topbar-link-color"></i></span>
                                    </a>
                                </li>
                            @endif


                            <li>
                                <a class=" rs-search short-border" data-target=".search-modal" data-toggle="modal"
                                    href="#">
                                    <i class="fa fa-search topbar-link-color"></i>
                                </a>
                            </li>

                            @foreach (config('locales.languages') as $key => $val)
                                @if ($key != app()->getLocale())
                                    <li class="lang-item">

                                        <a href="{{ route('change.language', $key) }}" class="topbar-link-color">
                                            <span>
                                                <i class="flag-icon flag-icon-{{ $key == 'ar' ? 'ye' : 'us' }}"
                                                    title="{{ $key == 'ar' ? 'ye' : 'us' }}"
                                                    id="{{ $key == 'ar' ? 'ye' : 'us' }}"></i>
                                            </span>
                                            {{-- {{ __('transf.lang_' . $val['lang']) }} --}}
                                        </a>
                                    </li>
                                @endif
                            @endforeach

                            <div class="text-white divider d-none d-inline-block">|</div>

                            <li class="login-register">
                                <i class="fa fa-sign-in text-white"></i>
                                @if (auth()->check() && (auth()->user()->hasRole('admin') or auth()->user()->hasRole('supervisor')))
                                    <a href="{{ route('admin.index') }}">{{ __('panel.dashboard') }}</a>
                                @else
                                    <a href="{{ route('admin.login') }}">{{ __('panel.f_login') }}</a>
                                @endif

                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Topbar Area End -->

        <!-- Menu Start -->
        <div class="menu-area menu-sticky">
            <div class="container">
                <div class="row y-middle">
                    <div class="col-lg-2">
                        <div class="logo-cat-wrap">
                            {{-- <div class="logo-part pr-90"> --}}
                            <div class="logo-part ">
                                <a class="dark-logo" href="{{ route('admin.index') }}">
                                    @php
                                        if ($siteSettings['site_logo_large_dark']->value != null) {
                                            $site_logo_large_dark = asset(
                                                'assets/site_settings/' . $siteSettings['site_logo_large_dark']->value,
                                            );

                                            if (
                                                !file_exists(
                                                    public_path(
                                                        'assets/site_settings/' .
                                                            $siteSettings['site_logo_large_dark']->value,
                                                    ),
                                                )
                                            ) {
                                                $site_logo_large_dark = asset('frontend/images/logo-dark.png');
                                            }
                                        } else {
                                            $site_logo_large_dark = asset('frontend/images/logo-dark.png');
                                        }
                                    @endphp

                                    <img src="{{ $site_logo_large_dark }}"
                                        alt="{{ $siteSettings['site_name']->value }}">

                                </a>


                                <a class="light-logo" href="{{ route('admin.index') }}">
                                    @php
                                        if ($siteSettings['site_logo_large_light']->value != null) {
                                            $site_logo_large_light = asset(
                                                'assets/site_settings/' . $siteSettings['site_logo_large_light']->value,
                                            );

                                            if (
                                                !file_exists(
                                                    public_path(
                                                        'assets/site_settings/' .
                                                            $siteSettings['site_logo_large_light']->value,
                                                    ),
                                                )
                                            ) {
                                                $site_logo_large_light = asset('frontend/images/logo.png');
                                            }
                                        } else {
                                            $site_logo_large_light = asset('frontend/images/logo.png');
                                        }
                                    @endphp

                                    <img src="{{ $site_logo_large_light }}"
                                        alt="{{ $siteSettings['site_name']->value }}">
                                </a>
                            </div>


                        </div>
                    </div>
                    <div class="col-lg-8 text-center">
                        <div class="rs-menu-area">
                            <div class="main-menu ">
                                <div class="mobile-menu">
                                    <a class="rs-menu-toggle">
                                        <i class="fa fa-bars"></i>
                                    </a>
                                </div>
                                <nav class="rs-menu">
                                    <ul class="nav-menu">
                                        @foreach ($web_menus->where('section', 1) as $menu)
                                            <li
                                                class=" {{ count($menu->appearedChildren) > 0 ? 'menu-item-has-children has-children' : '' }}">
                                                <a
                                                    href="{{ count($menu->appearedChildren) > 0 ? 'javascript:void(0)' : $menu->link }}">{{ $menu->title }}</a>
                                                @if (count($menu->appearedChildren) > 0)
                                                    <ul class="sub-menu">
                                                        @foreach ($menu->appearedChildren as $sub_menu)
                                                            <li
                                                                class=" {{ count($sub_menu->appearedChildren) > 0 ? 'menu-item-has-children has-children' : '' }}">
                                                                <a
                                                                    href="{{ $sub_menu->link }}">{{ $sub_menu->title }}</a>
                                                                @if (count($sub_menu->appearedChildren) > 0)
                                                                    <ul class="sub-menu">
                                                                        @foreach ($sub_menu->appearedChildren as $sub_sub_menu)
                                                                            <li>
                                                                                <a
                                                                                    href="{{ $sub_sub_menu->link }}">{{ $sub_sub_menu->title }}</a>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul> <!-- //.nav-menu -->
                                </nav>
                            </div> <!-- //.main-menu -->


                        </div>
                    </div>
                    <div class="col-lg-2 text-right">
                        <div class="expand-btn-inner">
                            <ul>

                                <li>
                                    <a class="hidden-xs rs-search" data-target=".search-modal" data-toggle="modal"
                                        href="#">
                                        <i class="flaticon-search"></i>
                                    </a>
                                </li>
                            </ul>
                            <span>
                                <a id="nav-expander" class="nav-expander">
                                    <span class="dot1"></span>
                                    <span class="dot2"></span>
                                    <span class="dot3"></span>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Menu End -->

        <!-- Canvas Menu start -->
        <nav class="right_menu_togle hidden-md">
            <div class="close-btn">
                <div id="nav-close">
                    <div class="line">
                        <span class="line1"></span><span class="line2"></span>
                    </div>
                </div>
            </div>
            <div class="canvas-logo">
                <a href="{{ route('admin.index') }}"><img src="{{ asset('frontend/images/logo-dark.png') }}"
                        alt="logo"></a>
            </div>
            <div class="offcanvas-text">
                <p>
                    {!! $siteSettings['site_description']->value ?? '' !!}
                </p>
            </div>
            <div class="offcanvas-gallery">

                @php
                    use App\Models\SiteSetting;
                    $site_album = SiteSetting::where('key', 'site_name')->get()->first();
                @endphp

                @if ($site_album->photos()->count() > 0)
                    @foreach ($site_album->photos as $media)
                        <div class="gallery-img">
                            {{-- <a class="image-popup" href="{{ asset('assets/site_settings/' . $media->file_name) }}">
                                <img src="{{ asset('assets/site_settings/' . $media->file_name) }}"
                                    alt="{{ $media->file_name }}">
                            </a> --}}
                            @php
                                $imagePath = public_path('assets/site_settings/' . $media->file_name);
                            @endphp

                            <a class="image-popup"
                                href="{{ File::exists($imagePath) ? asset('assets/site_settings/' . $media->file_name) : asset('image/not_found/placeholder.jpg') }}">
                                <img style="width: 7.27em;height:4.8em"
                                    src="{{ File::exists($imagePath) ? asset('assets/site_settings/' . $media->file_name) : asset('image/not_found/placeholder.jpg') }}"
                                    alt="{{ $media->file_name }}">
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="map-img">
                {{-- <img src="{{ asset('frontend/images/map.jpg') }}" alt=""> --}}
                <iframe
                    src="https://maps.google.com/maps?q=Ibb%20University,%20Yemen&t=&z=15&ie=UTF8&iwloc=&output=embed"
                    frameborder="0" style="border:0;width:25.5em; height:13.5em" allowfullscreen=""
                    aria-hidden="false" tabindex="0">
                </iframe>
            </div>
            <div class="canvas-contact">
                <ul class="social">
                    @if ($siteSettings['site_facebook']->value)
                        <li>
                            <a href="{{ $siteSettings['site_facebook']->value }}" target="_blank">
                                <span><i class="fa fa-facebook"></i></span>
                            </a>
                        </li>
                    @endif
                    @if ($siteSettings['site_twitter']->value)
                        <li>
                            <a href="{{ $siteSettings['site_twitter']->value }}" target="_blank">
                                <span><i class="fa fa-twitter"></i></span>
                            </a>
                        </li>
                    @endif

                    @if ($siteSettings['site_youtube']->value)
                        <li>
                            <a href="{{ $siteSettings['site_youtube']->value }}" target="_blank">
                                <span><i class="fa fa-youtube "></i></span>
                            </a>
                        </li>
                    @endif

                    @if ($siteSettings['site_instagram']->value)
                        <li>
                            <a href="{{ $siteSettings['site_instagram']->value }}" target="_blank">
                                <span><i class="fa fa-instagram "></i></span>
                            </a>
                        </li>
                    @endif

                </ul>
            </div>
        </nav>
        <!-- Canvas Menu end -->
    </header>
    <!--Header End-->
</div>
<!--Full width header End-->
