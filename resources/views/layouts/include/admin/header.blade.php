<!DOCTYPE html>
<html lang="en">
<!-- index.html  21 Nov 2019 03:44:50 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title> @yield('title', config('app.name', 'Pablo'))</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">
  <link rel="stylesheet" href=" {{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/toaster.min.css') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Custom style CSS -->
  <!-- <link rel="stylesheet" href="assets/css/custom.css"> -->
  <link rel='shortcut icon' type='image/x-icon' href=" {{ asset('assets/img/favicon.ico') }}" />
  @stack('styles')
  <script>
    const APP_URL = '{{ url("") }}';
</script>
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
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn"> <i data-feather="align-justify"></i></a></li>
            <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                <i data-feather="maximize"></i>
              </a></li>
            <li>
              <form class="form-inline mr-auto">
                <div class="search-element">
                  <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="200">
                  <button class="btn" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </form>
            </li>
          </ul>
        </div>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown"><a href="#" data-toggle="dropdown"
              class="nav-link dropdown-toggle nav-link-lg nav-link-user"> <img alt="image" src="assets/img/user.png"
                class="user-img-radious-style"> <span class="d-sm-none d-lg-inline-block"></span></a>
            <div class="dropdown-menu dropdown-menu-right pullDown">
              <div class="dropdown-title">Hello Sarah Smith</div>
              <a href="{{ route('admin.show.admin')}}" class="dropdown-item has-icon"> <i class="far
										fa-user"></i> Profile
              </a> <a href="timeline.html" class="dropdown-item has-icon"> <i class="fas fa-bolt"></i>
                Activities
              </a> <a href="#" class="dropdown-item has-icon"> <i class="fas fa-cog"></i>
                Settings
              </a>
              <div class="dropdown-divider"></div>
              <a href="auth-login.html" class="dropdown-item has-icon text-danger"> <i class="fas fa-sign-out-alt"></i>
                Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="index.html"> <img alt="image" src="assets/img/logo.png" class="header-logo" /> <span
                class="logo-name">Otika</span>
            </a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="dropdown active">
              <a href="{{ route('admin.admin.dashboard')}}" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
            </li>
            <li class="dropdown">
              <a href="{{ route('admin.architects')}}" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="briefcase"></i><span>Architect</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('admin.architects')}}">Architects</a></li>
                <li><a class="nav-link" href="{{ route('admin.add.architect')}}"> Add Architect</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="{{ route('admin.contractors')}}" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="briefcase"></i><span>Contractor</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('admin.contractors')}}">Contractors</a></li>
                <li><a class="nav-link" href="{{ route('admin.add.contractor')}}"> Add Architect</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="briefcase"></i><span>Workers</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('admin.workers')}}">Workers</a></li> 
                <li><a class="nav-link" href="{{ route('admin.add.worker')}}"> Add Worker</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="briefcase"></i><span>Site</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('admin.sites')}}">Sites</a></li> 
                <li><a class="nav-link" href="{{ route('admin.add.site')}}"> Add Site</a></li>
              </ul>
            </li>
          </ul>
        </aside>
      </div>