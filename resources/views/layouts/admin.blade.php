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
                            <a href="javascript:void(0);" data-toggle="sidebar" class="nav-link nav-link-lg collapse-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-align-justify">
                                    <line x1="21" y1="10" x2="3" y2="10"></line>
                                    <line x1="21" y1="6" x2="3" y2="6"></line><line x1="21" y1="14" x2="3" y2="14"></line><line x1="21" y1="18" x2="3" y2="18"></line>
                                </svg>
                            </a>
                        </li>
                        <li>
                            {{--
                            @if($authUser->role.'.dashboard' == Request::route()->getName())
                                <form class="form-inline mr-auto" method="get" id="search">
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
                                    <button class="btn" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </form>
                            @endif
                            --}}
                            @if(in_array(Request::route()->getName(), [$authUser->role.'.architects', $authUser->role.'.contractors', $authUser->role.'.workers', $authUser->role.'.sites', $authUser->role.'.managers.index', $authUser->role.'.contractors.index', $authUser->role.'.workers.index']))
                                <form class="form-inline mr-auto" method="get" id="search">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="search" placeholder="Search" aria-label="Search" data-width="200">
                                    </div>
                                    <button class="btn" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </form>
                            @endif
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
                            <a href="{{ route($authUser->role.'.show.admin')}}" class="dropdown-item has-icon">
                                <i class="far fa-user"></i> Profile
                            </a>
                            <a href=" {{ route('change.password')}} " class="dropdown-item has-icon">
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
                        @if ($authUser->role == "admin")
                            <li class="dropdown {{ 'admin.architects' == Request::route()->getName() ? 'active' : '' }}">
                                <a href="{{ route('admin.architects') }}"><i data-feather="user-check"></i><span>Main Contractor</span></a>
                            </li>
                        @endif

                        @if ($authUser->role == 'project-manager' && $authUser->status != 'Inactive')
                            <li class="dropdown {{ $authUser->role.'.managers.index' == Request::route()->getName() && Request::route('type') == 'main-manager' ? 'active' : '' }}">
                                <a href="{{ route( $authUser->role.'.managers.index',['type'=>'main-manager']) }}" ><i data-feather="user-check"></i><span>Sub Managers</span></a>
                            </li>
                            <li class="dropdown {{ $authUser->role.'.managers.index' == Request::route()->getName() && Request::route('type') == 'manager' ? 'active' : '' }}">
                                <a href="{{ route( $authUser->role.'.managers.index',['type'=>'manager']) }}" ><i data-feather="user-check"></i><span>Sub Managers (View Only)</span></a>
                            </li>

                        @endif

                        @if ($authUser->role != 'subcontractor' && $authUser->status != 'Inactive')
                            <li class="dropdown {{ $authUser->role.'.contractors' == Request::route()->getName() ? 'active' : '' }}">
                                <a href="{{ route( $authUser->role.'.contractors') }}" ><i data-feather="user"></i><span>Subcontractors</span></a>
                            </li>
                        @endif

                        @if (($authUser->role == 'subcontractor' && $authUser->status == 'Active' && !is_null($authUser->contractor) && $authUser->contractor->is_approved == 1) || ($authUser->role != 'subcontractor' && $authUser->status == 'Active'))
                            <li class="dropdown {{  $authUser->role.'.workers' == Request::route()->getName() ? 'active' : '' }}">
                                <a href="{{ route( $authUser->role.'.workers') }}" ><i data-feather="users"></i><span>Workers</span></a>
                            </li>
                        @endif
                        @if (($authUser->role == 'subcontractor' && $authUser->status == 'Active' && !is_null($authUser->contractor) && $authUser->contractor->is_approved == 1) )
                        <li class="dropdown {{  $authUser->role.'.uploaded.documents' == Request::route()->getName() ? 'active' : '' }}">
                            <a href="{{ route( 'subcontractor.uploaded.documents',[$authUser->slug]) }}" ><i data-feather="users"></i><span>Uploaded Documents</span></a>
                        </li>
                    @endif

                        @if ($authUser->role == 'admin')
                            <li class="dropdown {{ 'admin.sites' == Request::route()->getName() ? 'active' : '' }}">
                                <a href="{{ route('admin.sites') }}" ><i data-feather="command"></i><span>Site</span></a>
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
    <script src="{{ asset('assets/js/common.js') }}?ver={{ now() }}"></script>
    @stack('scripts')
    @yield('modal')
</body>

</html>
