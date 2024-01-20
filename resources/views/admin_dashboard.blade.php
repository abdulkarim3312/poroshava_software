<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>
        মডিউল ড্যাশবোর্ড| {{ config('app.name') }}
    </title>
    @include('layouts.partial.__favicon')
    @include('layouts.partial.__style')
    <style>
        .module-box {
            min-width: 300px;
            padding: 48px 26px;
            /*background-color: #000;*/
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            animation: slide-up 0.5s ease-out forwards;
            height: 176px;
        }

        @keyframes slide-up {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .card-body {
            text-align: center;
        }
        .cashbook{
            background-image: url("img/image-4.jpeg") !important;
        }
        .cashbook h2{
            color: black !important;
        }
        .holding,.account,.trade{
            background-image: url("img/image-3.jpeg") !important;
        }
        .holding h2,.account h2,.trade h2{
            color: black !important;
        }

        .rotate{
            animation: rotation 5s infinite linear;
        }
        @keyframes rotation {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(359deg);
            }
        }
    </style>
</head>
<body class="layout-top-nav layout-footer-fixed" style="height: auto;">
<div class="wrapper">

    <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
        <div class="container">
            <a href="{{ route('dashboard') }}" class="navbar-brand">
                <img src="{{ asset('img/logo.png') }}"  alt="AdminLTE Logo"
                     class="brand-image img-circle elevation-3 rotate" style="opacity: .8">
            </a>
            <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse order-3" id="navbarCollapse">

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a role="button" style="font-size: 22px;color: #48b461" class="nav-link"> {{ config('app.name') }}</a>
                    </li>
                </ul>

            </div>

            <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">

                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="far fa-bell"></i>
                        @if(count(auth()->user()->unreadNotifications) > 0)
                            <span class="badge badge-danger navbar-badge">
                        {{ count(auth()->user()->unreadNotifications) > 99 ? '99+' : count(auth()->user()->unreadNotifications)  }}
                    </span>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right notification-area-custom">
                        <span class="dropdown-item dropdown-header"><a href="{{ route('notification') }}">{{ count(auth()->user()->unreadNotifications) }} Notifications</a></span>
                        <div class="dropdown-divider"></div>
                        @foreach (auth()->user()->unreadNotifications->take(50) as $notification)
                            <a href="{{ $notification->data['link'] }}?notification_id={{ $notification->id }}"
                               class="dropdown-item">

                                <i class="fas fa-envelope mr-2 {{ $notification->read_at ? 'text-black' : 'text-blue' }}"></i>
                                {{ $notification->data['title'] }}
                                <span class="float-right text-muted {{ $notification->read_at ? ' ' : 'text-blue' }}"
                                      style="font-size: 11px !important;">{{ $notification->created_at->diffForHumans() }}</span>
                                <p style="font-size: 12px;">{{ $notification->data['text'] }}</p>
                            </a>
                            <div class="dropdown-divider"></div>
                        @endforeach
                        @if(count(auth()->user()->unreadNotifications) <= 1)
                            <div class="dropdown-divider"></div>
                        @endif
                        <a href="{{ route('notification') }}" class="dropdown-item dropdown-footer">See All
                            Notifications</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fa fa-database"></i>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                        <img height="30" class="img-circle" src="{{ asset('themes/backend/dist/img/avatar.png') }}"
                             alt=""> {{ auth()->user()->name }} <i class="fa fa-angle-down"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            <i class="fas fa-user mr-2"></i> প্রোফাইল
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                <i class="fas fa-sign-out-alt mr-2"></i> সাইন আউট
                            </a>
                        </form>

                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="content-wrapper" style="min-height: 495.667px; background-color: #48b461;">
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0" style="color: #fff;"> মডিউল ড্যাশবোর্ড</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                @foreach($sisterConcerns as $sisterConcern)
                    <div class="col-lg-4 col-6">
                        <a href="{{ route('dashboard',['role_permission'=>$sisterConcern->role]) }}">
                        <div class="small-box {{$sisterConcern->id == 1?'bg-gradient-red':''}}{{ $sisterConcern->id == 4?'bg-gradient-blue':'' }}{{ $sisterConcern->id == 5?'bg-gradient-info':'' }}{{ $sisterConcern->id == 6?'bg-gradient-pink':'' }}{{ $sisterConcern->id == 7?'bg-gradient-purple':'' }}{{ $sisterConcern->id == 8?'bg-gradient-orange':'' }}">
                            <div class="inner">
                                <h3 style="color: white !important; padding: 10px !important">{{ $sisterConcern->name }}</h3>
                                <br/><br/>
                            </div>
                            <div class="icon">
                                <i class="fas fa-receipt"></i>
                            </div>
                            <a href="{{ route('dashboard',['role_permission'=>$sisterConcern->role]) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                        </a>
                    </div>
                @endforeach
            </div>
{{--            <div class="row  justify-content-center">--}}
{{--                @foreach($sisterConcerns as $sisterConcern)--}}
{{--                    <a href="{{ route('dashboard',['role_permission'=>$sisterConcern->role]) }}" class="col-md-4 col-12">--}}
{{--                        <div class="card module-box {{$sisterConcern->id == 1?'account':''}}{{ $sisterConcern->id == 4?'cashbook':'' }}{{ $sisterConcern->id == 5?'holding':'' }}{{ $sisterConcern->id == 6?'trade':'' }}" style="background-image: url('img/image-1.jpeg')">--}}
{{--                            <div class="card-body">--}}
{{--                                <h2 class="animate-text" style="font-size:1.8rem;font-weight: bold;color: #fff;">{{ $sisterConcern->name }}</h2>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                @endforeach--}}
{{--            </div>--}}
        </div>
    </div>
    <footer class="main-footer">

        <div class="float-right d-none d-sm-inline">
            Design & Developed By <a target="_blank" href="https://2aitlimited.com">2A IT LIMITED</a>
        </div>

        <strong>
            Copyright &copy; 2022-{{ date('Y') }} <a
                href="{{ route('dashboard') }}">{{ config('app.name') }}</a>.</strong> All rights reserved.
    </footer>
</div>
@include('layouts.partial.__script')
</body>
</html>
