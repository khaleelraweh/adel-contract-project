<div>
    <!-- Main content Start -->
    <div class="main-content">

        <!-- Breadcrumbs Start -->
        <div class="rs-breadcrumbs breadcrumbs-overlay">
            <div class="breadcrumbs-img">
                {{-- <img src="{{ $siteSettings['site_img']->value ? asset('assets/site_settings/' . $siteSettings['site_img']->value) : asset('frontend/images/breadcrumbs/2.jpg') }}"
                    alt="{{ $siteSettings['site_name']->value }}"> --}}
                @php
                    $imagePath = public_path('assets/site_settings/' . $siteSettings['site_img']->value);
                @endphp

                <img src="{{ $siteSettings['site_img']->value && file_exists($imagePath)
                    ? asset('assets/site_settings/' . $siteSettings['site_img']->value)
                    : asset('image/not_found/placeholder2.jpg') }}"
                    alt="{{ $siteSettings['site_name']->value }}">

            </div>
            <div class="breadcrumbs-text">
                <h1 class="page-title">
                    @switch(true)
                        @case($currentRoute === 'frontend.blog_list')
                            {{ __('panel.blog_list') }}
                        @break

                        @case($currentRoute === 'frontend.news_list')
                            {{ __('panel.news_list') }}
                        @break

                        @case($currentRoute === 'frontend.events_list')
                            {{ __('panel.events_list') }}
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
                        @switch(true)
                            @case($currentRoute === 'frontend.blog_list')
                                {{ __('panel.blog_list') }}
                            @break

                            @case($currentRoute === 'frontend.news_list')
                                {{ __('panel.news_list') }}
                            @break

                            @case($currentRoute === 'frontend.events_list')
                                {{ __('panel.events_list') }}
                            @break

                            @default
                                Default Title
                        @endswitch
                    </li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumbs End -->

        <!-- Blog Section Start -->
        <div class="rs-inner-blog orange-color pt-100 pb-100 md-pt-70 md-pb-70">
            <div class="container">
                <div class="row">
                    <!-- Sidebar Start -->
                    <div class="col-lg-4 col-md-12 order-last">
                        <div class="widget-area">
                            <!-- Search Widget -->
                            <div class="search-widget mb-50">
                                <div class="search-wrap">
                                    <input type="search" wire:model="searchQuery"
                                        placeholder="{{ __('transf.search') }}..." name="s" class="search-input">
                                </div>
                            </div>

                            <!-- Recent Posts Widget -->
                            <div class="recent-posts-widget mb-50">
                                @php
                                    $titleMap = [
                                        'frontend.blog_list' => __('panel.recent_posts'),
                                        'frontend.news_list' => __('panel.recent_news'),
                                        'frontend.events_list' => __('panel.recent_events'),
                                    ];
                                    $routeMap = [
                                        'frontend.blog_list' => 'frontend.blog_single',
                                        'frontend.news_list' => 'frontend.news_single',
                                        'frontend.events_list' => 'frontend.event_single',
                                    ];
                                    $assetMap = [
                                        'frontend.blog_list' => 'assets/posts/',
                                        'frontend.news_list' => 'assets/news/',
                                        'frontend.events_list' => 'assets/events/',
                                    ];

                                    $widgetTitle = $titleMap[$currentRoute] ?? __('panel.recent_posts');
                                    $routeName = $routeMap[$currentRoute] ?? 'frontend.blog_single';
                                    $assetPath = $assetMap[$currentRoute] ?? 'assets/posts/';
                                @endphp

                                <h3 class="widget-title recent_post_title">{{ $widgetTitle }}</h3>

                                @foreach ($recent_posts as $recent_post)
                                    @php
                                        $recentImage =
                                            $recent_post->photos->first()->file_name ??
                                            'image/not_found/placeholder.jpg';
                                        $recentImgUrl = asset($assetPath . $recentImage);

                                        // Check if the image exists, otherwise fallback to default
                                        if (!file_exists(public_path(parse_url($recentImgUrl, PHP_URL_PATH)))) {
                                            $recentImgUrl = asset('image/not_found/placeholder.jpg');
                                        }
                                    @endphp

                                    <div class="show-featured">
                                        <div class="post-img">
                                            <a href="{{ route($routeName, $recent_post->slug) }}">
                                                <img src="{{ $recentImgUrl }}" alt="">
                                            </a>
                                        </div>
                                        <div class="post-desc">
                                            <a href="{{ route($routeName, $recent_post->slug) }}">
                                                {{ \Illuminate\Support\Str::words($recent_post->title, 10, '...') }}
                                            </a>
                                            <span class="date">
                                                <i class="fa fa-calendar"></i>
                                                {{ formatPostDateDash($recent_post->created_at) }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Tags Widget -->
                            <div class="recent-posts mb-50">
                                <h3 class="widget-title tags_title">{{ __('panel.tags') }}</h3>
                                <ul>
                                    @foreach ($tags as $tag)
                                        @php
                                            $tagRouteMap = [
                                                'frontend.blog_list' => 'frontend.blog_tag_list',
                                                'frontend.news_list' => 'frontend.news_tag_list',
                                                'frontend.events_list' => 'frontend.events_tag_list',
                                            ];
                                            $tagRoute = $tagRouteMap[$currentRoute] ?? 'frontend.blog_tag_list';
                                        @endphp
                                        <li>
                                            <a href="{{ route($tagRoute, $tag->slug) }}">{{ $tag->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Sidebar End -->

                    <!-- Main Content Start -->
                    <div class="col-lg-8 pr-50 md-pr-15">
                        <div class="row">
                            @foreach ($posts as $post)
                                <div class="col-lg-6 mb-70">
                                    <div class="blog-item">
                                        <div class="blog-img">
                                            @php
                                                $linkRoute = match ($currentRoute) {
                                                    'frontend.blog_list' => 'frontend.blog_single',
                                                    'frontend.news_list' => 'frontend.news_single',
                                                    'frontend.events_list' => 'frontend.event_single',
                                                    default => 'frontend.blog_single',
                                                };
                                            @endphp

                                            <x-post-link :route="$linkRoute" :slug="$post->slug">
                                                @php
                                                    $post_img = getPostImage(
                                                        $post,
                                                        $currentRoute,
                                                        asset('image/not_found/placeholder.jpg'),
                                                    );
                                                @endphp
                                                <img src="{{ $post_img }}" alt="">
                                            </x-post-link>
                                        </div>

                                        <div class="blog-content">

                                            <h3 class="blog-title">
                                                <x-post-link :route="$linkRoute" :slug="$post->slug">
                                                    {{ $post->title }}
                                                </x-post-link>
                                            </h3>
                                            <div class="blog-meta">
                                                <ul class="btm-cate">
                                                    <li>
                                                        <div class="blog-date">
                                                            <i class="fa fa-calendar-check-o"></i>
                                                            {{ formatPostDate($post->created_at) }}
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="blog-desc">
                                                {!! \Illuminate\Support\Str::words($post->content, 30, '...') !!}
                                            </div>
                                            <div class="blog-button">
                                                <!-- Button -->
                                                <x-post-link :route="$linkRoute" :slug="$post->slug" class="blog-btn">
                                                    {{ __('panel.continue_reading') }}
                                                </x-post-link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- Main Content End -->
                </div>
            </div>
        </div>
        <!-- Blog Section End -->
    </div>
    <!-- Main content End -->
</div>
