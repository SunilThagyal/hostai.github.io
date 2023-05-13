<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> @yield('title') | {{ config('app.name', 'Teeqode') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">
    <link rel="stylesheet" href=" {{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href=" {{ asset('assets/css/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/toaster.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel='shortcut icon' type='image/x-icon' href=" {{ asset('assets/img/teeqode.png') }}" />
    <script>
        const APP_URL = '{{ url("") }}';
        const authUserRole = "{{ $authUser->role }}";
        const authUserSlug = "{{ $authUser->slug }}";
        const authUserId= "{{ $authUser->id }}";
    </script>
    @stack('styles')
    @include('validation');
</head>

<body>
    <div class="loader"></div>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar sticky">
                <div class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li>
                            <form class="form-inline mr-auto" action=""  method="get" id="search">
                                @if($authUser->role.'.dashboard' == Request::route()->getName())
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>
                                        <input type="text" name="dates" class="form-control daterange-cus">
                                    </div>
                                </div>
                                @endif
                                @if ($authUser->role.'.dashboard' != Request::route()->getName())
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="search" placeholder="Search" aria-label="Search" data-width="200">
                                    </div>
                                @endif
                                <button class="btn" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image" src="{{ !is_null($authUser->profile_url) ? asset('storage/' . $authUser->profile_url) : asset('images/profile.png') }}" class="user-img-radious-style">
                            <span class="d-sm-none d-lg-inline-block"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right pullDown">
                            <div class="dropdown-title">{{ $authUser->first_name }}</div>
                            <a href="{{ route($authUser->role.'.profile')}}" class="dropdown-item has-icon">
                                <i class="far fa-user"></i> Profile
                            </a>
                            <a href="{{ route('manager.change.password')}} " class="dropdown-item has-icon">
                                <i class="fas fa-cog"></i> Change Password
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href=" {{ route('custom.logout')}} " class="dropdown-item has-icon text-danger">
                                <i class="fas fa-sign-out-alt"></i>Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="{{ route($authUser->role.'.dashboard') }}">
                            <img alt="image" src="{{ asset('images/logo.png') }}" class="header-logo" />
                        </a>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="dropdown {{ $authUser->role.'.dashboard' == Request::route()->getName() ? 'active' : '' }}">
                            <a href="{{ route($authUser->role.'.dashboard') }}" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
                        </li>
                        @if ($authUser->status == 'Active')
                        <li class="dropdown {{ $authUser->role.'.contractors.index' == Request::route()->getName() ? 'active' : '' }}">
                            <a href="{{ route( $authUser->role.'.contractors.index') }}" ><i data-feather="briefcase"></i><span>Subcontractors</span></a>
                        </li>


                        <li class="dropdown {{  $authUser->role.'.workers.index' == Request::route()->getName() ? 'active' : '' }}">
                            <a href="{{ route( $authUser->role.'.workers.index') }}" ><i data-feather="briefcase"></i><span>Workers</span></a>
                        </li>
                        @endif
                        {{-- <li class="dropdown {{ $authUser->role.'.privacy.policy' == Request::route()->getName() ? 'active' : '' }}">
                            <a href="{{ route($authUser->role.'.privacy.policy') }}" ><i data-feather='unlock'   ></i><span>Privacy policy</span></a>
                        </li> --}}
                    </ul>
                </aside>
            </div>

            @yield('content')
            <footer class="main-footer">
                <div class="footer-left">
                    <a style="text-decoration:none" href="#">Teeqode</a></a>
                    
                    <a style="text-decoration:none;margin-left:10px" href="{{ route('privacy.policy') }}">Privacy policy</a>
                </div>
                <div class="footer-right"></div>
            </footer>
        </div>
    </div>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('assets/js/toaster.min.js') }}"></script>
    <script src="{{ asset('assets/js/validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/additional_method.min.js') }}"></script>
    <script src="{{ asset('assets/js/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/js/common.js')}} ?ver={{ now() }} }}"></script>
    @stack('scripts')
    @yield('modal')
</body>

</html>
