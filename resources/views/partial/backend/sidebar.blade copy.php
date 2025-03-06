<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('admin.index') }}" class="sidebar-brand">
            {{ __('panel.university') }} <span> {{ __('panel.ibb') }}</span>
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">{{ __('panel.menu') }}</li>

            @role(['admin'])
                @foreach ($admin_side_menu as $menu)
                @permission($menu->name)
                        @if (count($menu->appearedChildren) == 0)
                            <li class="nav-item">
                                <a href="{{ route('admin.' . $menu->as) }}" class="nav-link">
                                    <i class="{{ $menu->icon != null ? $menu->icon : 'fas fa-home' }}"></i>
                                    {{-- <span class="link-title">{{ $menu->display_name }}</span> --}}

                                    <span class="link-title">
                                        {{ \Illuminate\Support\Str::limit($menu->display_name, 25) }}
                                    </span>
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="collapse" href="#{{ $menu->name }}" role="button"
                                    aria-expanded="false" aria-controls="{{ $menu->name }}">
                                    <i class="{{ $menu->icon ?? 'fas fa-home' }}"></i>
                                    <span
                                        class="link-title">{{ \Illuminate\Support\Str::limit($menu->display_name, 18) }}</span>
                                    @if (count($menu->appearedChildren))
                                        <i class="link-arrow" data-feather="chevron-down"></i>
                                    @endif
                                </a>
                                @if (count($menu->appearedChildren))
                                    <div class="collapse" id="{{ $menu->name }}">
                                        <ul class="nav sub-menu">
                                            @foreach ($menu->appearedChildren as $sub_menu)
                                                @permission($sub_menu->name)
                                                    @if (count($sub_menu->appearedChildren) == 0)
                                                        <li class="nav-item">
                                                            <a href="{{ route('admin.' . $sub_menu->as) }}" class="nav-link">
                                                                {{-- {{ $sub_menu->display_name }} --}}
                                                                {{ \Illuminate\Support\Str::limit($sub_menu->display_name, 25) }}
                                                            </a>
                                                        </li>
                                                    @else
                                                        <li class="nav-item">
                                                            <a class="nav-link" data-bs-toggle="collapse"
                                                                href="#{{ $sub_menu->name }}" role="button" aria-expanded="false"
                                                                aria-controls="{{ $sub_menu->name }}">
                                                                {{ \Illuminate\Support\Str::limit($sub_menu->display_name, 25) }}
                                                                @if (count($sub_menu->appearedChildren))
                                                                    <i class="link-arrow" data-feather="chevron-down"></i>
                                                                @endif
                                                            </a>
                                                            @if (count($sub_menu->appearedChildren))
                                                                <div class="collapse" id="{{ $sub_menu->name }}">
                                                                    <ul class="nav sub-menu">
                                                                        @foreach ($sub_menu->appearedChildren as $sub_sub_menu)
                                                                            @permission($sub_sub_menu->name)
                                                                                <li class="nav-item">
                                                                                    <a href="{{ route('admin.' . $sub_sub_menu->as) }}"
                                                                                        class="nav-link">
                                                                                        {{ \Illuminate\Support\Str::limit($sub_sub_menu->display_name, 25) }}
                                                                                    </a>
                                                                                </li>
                                                                                @endpermission
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            @endif
                                                        </li>
                                                    @endif
                                                @endpermission
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </li>
                        @endif
                    @endpermission
                @endforeach
            @endrole
            @role(['supervisor'])
                @foreach ($admin_side_menu as $menu)
                @permission($menu->name)
                        @if (count($menu->appearedChildren) == 0)
                            <li class="nav-item">
                                <a href="{{ route('admin.' . $menu->as) }}" class="nav-link">
                                    <i class="{{ $menu->icon != null ? $menu->icon : 'fas fa-home' }}"></i>
                                    {{-- <span class="link-title">{{ $menu->display_name }}</span> --}}

                                    <span class="link-title">
                                        {{ \Illuminate\Support\Str::limit($menu->display_name, 25) }}
                                    </span>
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="collapse" href="#{{ $menu->name }}" role="button"
                                    aria-expanded="false" aria-controls="{{ $menu->name }}">
                                    <i class="{{ $menu->icon ?? 'fas fa-home' }}"></i>
                                    <span
                                        class="link-title">{{ \Illuminate\Support\Str::limit($menu->display_name, 18) }}</span>
                                    @if (count($menu->appearedChildren))
                                        <i class="link-arrow" data-feather="chevron-down"></i>
                                    @endif
                                </a>
                                @if (count($menu->appearedChildren))
                                    <div class="collapse" id="{{ $menu->name }}">
                                        <ul class="nav sub-menu">
                                            @foreach ($menu->appearedChildren as $sub_menu)
                                                @permission($sub_menu->name)
                                                    @if (count($sub_menu->appearedChildren) == 0)
                                                        <li class="nav-item">
                                                            <a href="{{ route('admin.' . $sub_menu->as) }}" class="nav-link">
                                                                {{-- {{ $sub_menu->display_name }} --}}
                                                                {{ \Illuminate\Support\Str::limit($sub_menu->display_name, 25) }}
                                                            </a>
                                                        </li>
                                                    @else
                                                        <li class="nav-item">
                                                            <a class="nav-link" data-bs-toggle="collapse"
                                                                href="#{{ $sub_menu->name }}" role="button" aria-expanded="false"
                                                                aria-controls="{{ $sub_menu->name }}">
                                                                {{ \Illuminate\Support\Str::limit($sub_menu->display_name, 25) }}
                                                                @if (count($sub_menu->appearedChildren))
                                                                    <i class="link-arrow" data-feather="chevron-down"></i>
                                                                @endif
                                                            </a>
                                                            @if (count($sub_menu->appearedChildren))
                                                                <div class="collapse" id="{{ $sub_menu->name }}">
                                                                    <ul class="nav sub-menu">
                                                                        @foreach ($sub_menu->appearedChildren as $sub_sub_menu)
                                                                            @permission($sub_sub_menu->name)
                                                                                <li class="nav-item">
                                                                                    <a href="{{ route('admin.' . $sub_sub_menu->as) }}"
                                                                                        class="nav-link">
                                                                                        {{ \Illuminate\Support\Str::limit($sub_sub_menu->display_name, 25) }}
                                                                                    </a>
                                                                                </li>
                                                                                @endpermission
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            @endif
                                                        </li>
                                                    @endif
                                                @endpermission
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </li>
                        @endif
                    @endpermission
                @endforeach
            @endrole

            @role(['users'])
                @foreach ($admin_side_menu as $menu)
                @permission($menu->name)
                        @if (count($menu->appearedChildren) == 0)
                            <li class="nav-item">
                                <a href="{{ route('admin.' . $menu->as) }}" class="nav-link">
                                    <i class="{{ $menu->icon != null ? $menu->icon : 'fas fa-home' }}"></i>
                                    {{-- <span class="link-title">{{ $menu->display_name }}</span> --}}

                                    <span class="link-title">
                                        {{ \Illuminate\Support\Str::limit($menu->display_name, 25) }}
                                    </span>
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="collapse" href="#{{ $menu->name }}" role="button"
                                    aria-expanded="false" aria-controls="{{ $menu->name }}">
                                    <i class="{{ $menu->icon ?? 'fas fa-home' }}"></i>
                                    <span
                                        class="link-title">{{ \Illuminate\Support\Str::limit($menu->display_name, 18) }}</span>
                                    @if (count($menu->appearedChildren))
                                        <i class="link-arrow" data-feather="chevron-down"></i>
                                    @endif
                                </a>
                                @if (count($menu->appearedChildren))
                                    <div class="collapse" id="{{ $menu->name }}">
                                        <ul class="nav sub-menu">
                                            @foreach ($menu->appearedChildren as $sub_menu)
                                                @permission($sub_menu->name)
                                                    @if (count($sub_menu->appearedChildren) == 0)
                                                        <li class="nav-item">
                                                            <a href="{{ route('admin.' . $sub_menu->as) }}" class="nav-link">
                                                                {{-- {{ $sub_menu->display_name }} --}}
                                                                {{ \Illuminate\Support\Str::limit($sub_menu->display_name, 25) }}
                                                            </a>
                                                        </li>
                                                    @else
                                                        <li class="nav-item">
                                                            <a class="nav-link" data-bs-toggle="collapse"
                                                                href="#{{ $sub_menu->name }}" role="button" aria-expanded="false"
                                                                aria-controls="{{ $sub_menu->name }}">
                                                                {{ \Illuminate\Support\Str::limit($sub_menu->display_name, 25) }}
                                                                @if (count($sub_menu->appearedChildren))
                                                                    <i class="link-arrow" data-feather="chevron-down"></i>
                                                                @endif
                                                            </a>
                                                            @if (count($sub_menu->appearedChildren))
                                                                <div class="collapse" id="{{ $sub_menu->name }}">
                                                                    <ul class="nav sub-menu">
                                                                        @foreach ($sub_menu->appearedChildren as $sub_sub_menu)
                                                                            @permission($sub_sub_menu->name)
                                                                                <li class="nav-item">
                                                                                    <a href="{{ route('admin.' . $sub_sub_menu->as) }}"
                                                                                        class="nav-link">
                                                                                        {{ \Illuminate\Support\Str::limit($sub_sub_menu->display_name, 25) }}
                                                                                    </a>
                                                                                </li>
                                                                                @endpermission
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            @endif
                                                        </li>
                                                    @endif
                                                @endpermission
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </li>
                        @endif
                    @endpermission
                @endforeach
            @endrole
        </ul>
    </div>
</nav>
