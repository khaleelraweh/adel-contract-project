 <!-- Footer Start -->
 <style>
     .rs-menu.footer {
         float: none;
     }

     .menu-item-has-children.footer {
         padding: 0 !important;
     }

     .item-link.footer {
         padding: 0 !important;
         display: inline-block;
         text-decoration: none !important;
         outline: none !important;
     }

     .sub-menu.footer {
         top: -200%;
     }

     .rs-footer.home9-style.main-home .footer-bottom .copy-right-menu li.lang-item:before {
         display: none !important;
     }
 </style>
 <footer id="rs-footer" class="rs-footer home9-style main-home">
     <div class="footer-top">
         <div class="container">
             <div class="row">
                 <div class="col-lg-3 col-md-12 col-sm-12 footer-widget md-mb-50">
                     <div class="footer-logo mb-30">
                         {{-- <a href="index.html"><img src="{{ asset('frontend/images/lite-logo.png') }}" alt=""></a>
                             --}}
                         <a href="{{ route('admin.index') }}">
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

                             <img src="{{ $site_logo_large_light }}" alt="{{ $siteSettings['site_name']->value }}">
                         </a>
                     </div>

                     <ul class="address-widget">
                         <li>
                             <i class="flaticon-location text-white"></i>
                             <div class="desc">{{ $siteSettings['site_address']->value ?? '' }}</div>
                         </li>
                         <li>
                             <i class="flaticon-call"></i>
                             <div class="desc">
                                 <a
                                     href="tel:(+04){{ $siteSettings['site_mobile']->value ?? '' }}">(+04){{ $siteSettings['site_mobile']->value ?? '' }}</a>
                             </div>
                         </li>
                         <li>
                             <i class="flaticon-email"></i>
                             <div class="desc">
                                 <?php
                                 $parsedUrl = parse_url($siteSettings['site_email1']->value, PHP_URL_HOST);
                                 
                                 // Remove 'www.' if it exists
                                 $domain = preg_replace('/^www\./', '', $parsedUrl);
                                 
                                 ?>
                                 <a
                                     href="mailto:{{ $siteSettings['site_email1']->value ?? '' }}">contact&#64;{{ $domain ?? '' }}</a>
                             </div>
                         </li>
                     </ul>
                 </div>
                 <div class="col-lg-3 col-md-12 col-sm-12 footer-widget md-mb-50">
                     <h3 class="widget-title">{{ __('panel.f_address') }}</h3>
                     <ul class="address-widget">
                         <li>

                             <div class="desc desc-title">{{ $siteSettings['site_address']->value ?? '' }}</div>
                         </li>
                         <li>
                             <div class="desc desc-title">
                                 <a
                                     href="tel:(+04){{ $siteSettings['site_mobile']->value ?? '' }}">(+04){{ $siteSettings['site_mobile']->value ?? '' }}</a>
                             </div>
                         </li>
                         <li>
                             <div class="desc desc-title">
                                 <?php
                                 $parsedUrl = parse_url($siteSettings['site_email1']->value, PHP_URL_HOST);
                                 
                                 // Remove 'www.' if it exists
                                 $domain = preg_replace('/^www\./', '', $parsedUrl);
                                 
                                 ?>
                                 <a
                                     href="mailto:{{ $siteSettings['site_email1']->value ?? '' }}">contact&#64;{{ $domain ?? '' }}</a>
                             </div>
                         </li>
                     </ul>
                 </div>
                 <div class="col-lg-3 col-md-12 col-sm-12 pl-50 md-pl-15 footer-widget md-mb-50">
                     <h3 class="widget-title">{{ __('panel.links_that_interest_you') }}</h3>
                     <ul class="site-map">

                         @foreach ($web_menus->where('section', 7) as $important_link_menu)
                             <li><a href="{{ $important_link_menu->link }}">{{ $important_link_menu->title }}</a></li>
                         @endforeach

                     </ul>
                 </div>
                 <div class="col-lg-3 col-md-12 col-sm-12 ">
                     <h3 class="widget-title">{{ __('panel.applications_and_social_media') }}</h3>
                     <div class="row mb-4">
                         <div class="col-lg-6 col-md-6 col-sm-6 footer-widget">
                             <div class="counter-item text-center">
                                 <img class="image" src="{{ asset('frontend/images/waleed/google.png') }}"
                                     alt="">

                             </div>
                         </div>
                         <div class="col-lg-6 col-md-6 col-sm-6 footer-widget">
                             <div class="counter-item text-center">
                                 <img class="image" src="{{ asset('frontend/images/waleed/apple.png') }}"
                                     alt="">

                             </div>
                         </div>
                     </div>


                     <ul class="footer_social counter-item text-center">
                         <li>
                             <a href="#" target="_blank"><span><i style="font-size: 1.5rem;"
                                         class="fa fa-facebook fa-1x"></i></span></a>
                         </li>
                         <li>
                             <a href="# " target="_blank"><span><i style="font-size: 1.5rem;"
                                         class="fa fa-twitter fa-1x"></i></span></a>
                         </li>

                         <li>
                             <a href="# " target="_blank"><span><i style="font-size: 1.5rem;"
                                         class="fa fa-pinterest-p fa-1x"></i></span></a>
                         </li>
                         <li>
                             <a href="# " target="_blank"><span><i style="font-size: 1.5rem;"
                                         class="fa fa-google-plus-square "></i></span></a>
                         </li>
                         <li>
                             <a href="# " target="_blank"><span><i style="font-size: 1.5rem;"
                                         class="fa fa-snapchat fa-1x"></i></span></a>
                         </li>
                         <li>
                             <a href="# " target="_blank"><span><i style="font-size: 1.5rem;"
                                         class="fa fa-telegram fa-1x"></i></span></a>
                         </li>
                         <li>
                             <a href="# " target="_blank"><span><i style="font-size: 1.5rem;"
                                         class="fa fa-instagram fa-"></i></span></a>
                         </li>

                     </ul>
                 </div>
             </div>
         </div>
     </div>
     <div class="footer-bottom">
         <div class="container">
             <div class="row y-middle">
                 <div class="col-lg-6 md-mb-20">
                     <div class="copyright">
                         <p> {{ $siteSettings['site_name']->value }} , &copy; {{ date('Y') }}
                             {{ __('panel.all_rights_reserved') }}.
                         </p>
                     </div>
                 </div>
                 <div class="col-lg-6 text-right md-text-left">
                     <ul class="copy-right-menu">
                         @foreach ($web_menus->where('section', 9) as $PoliciesPrivacy)
                             <li><a href="{{ $PoliciesPrivacy->link }}">{{ $PoliciesPrivacy->title }}</a></li>
                         @endforeach

                         {{-- <li><a href="#">Blog</a></li>
                             <li><a href="#">Contact</a></li> --}}
                     </ul>
                 </div>
             </div>
         </div>
     </div>
 </footer>
 <!-- Footer End -->
