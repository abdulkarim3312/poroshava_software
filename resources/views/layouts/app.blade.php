<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @yield('title') | {{ config('app.name') }}
    </title>
    @include('layouts.partial.__favicon')
    @include('layouts.partial.__style')
    @yield('style')
    <style>
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
<body class="sidebar-mini layout-fixed layout-footer-fixed">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <h3 class="nav-link font-weight-bold active"
                    style="font-size: 22px;margin: 0;color: #48b461">
                    {{ auth()->user()->sisterConcern->name ?? '' }}, {{ config('app.name') }}
                </h3>
            </li>
        </ul>
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
            @if(auth()->user()->role == \App\Enumeration\Role::$TRADE_LICENSE)
                @php
                    $applicationList = tradeLicenseApplicationList();
                    $loop = count($applicationList) > 2 ? 2: count($applicationList);
                @endphp
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="far fa-bell"></i>
                        @if(count($applicationList) > 0)
                            <span class="badge badge-danger navbar-badge">
                                {{ count($applicationList) > 99 ? '99+' : count($applicationList)  }}
                            </span>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right notification-area-custom">
                        <span class="dropdown-item dropdown-header"><a href="{{ route('notification') }}">{{ enNumberToBn(count($applicationList)) }} টি ট্রেড লাইসেন্স বিজ্ঞপ্তি</a></span>
                        <div class="dropdown-divider"></div>
                        @for($i=0; $i < $loop; $i++)
                            <a href="#"
                               class="dropdown-item">

                                <i class="fas fa-envelope mr-2"></i>
                               {{ $applicationList[$i]->organization_name }}
                                <span class="float-right text-muted"
                                      style="font-size: 11px !important;"></span>
                                <p style="font-size: 12px;">{{ $applicationList[$i]->name }}</p>
                            </a>
                            <div class="dropdown-divider"></div>
                        @endfor
                        @if(count($applicationList) <= 1)
                            <div class="dropdown-divider"></div>
                        @endif
                        <a href="{{ route('trade_license_pending_list') }}" class="dropdown-item dropdown-footer">সবগুলো দেখুন</a>
                    </div>
                </li>
            @else
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
            @endif
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
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-success elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('dashboard') }}" class="brand-link">
            <img src="{{ asset('img/logo.png') }}" alt="Logo"
                 class="brand-image img-circle rotate elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">
                <b>অ্যাডমিন </b>প্যানেল
                </span>
        </a>

        <!-- Sidebar -->
        <div
            class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition">

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column nav-compact nav-child-indent" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-item">
                        <a href="{{ route('dashboard',['role_permission'=>request('role_permission')]) }}"
                           class="nav-link {{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>ড্যাশবোর্ড</p>
                        </a>
                    </li>
                    @if(auth()->user()->is_super_admin == \App\Enumeration\Role::$IS_SUPER_ADMIN)

                        <li class="nav-item">
                            <a href="{{ route('module') }}"
                               class="nav-link {{ Route::currentRouteName() == 'module' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>মডিউল</p>
                            </a>
                        </li>
                        <?php
                        $subMenu = [
                            'user', 'user.add', 'user.edit'
                        ];
                        ?>
                        <li class="nav-item">
                            <a href="{{ route('user') }}"
                               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>ইউজার</p>
                            </a>
                        </li>
                    @endif
                    @if(in_array(auth()->user()->role,[2]))
                        <?php
                        $subMenu = [
                            'section', 'section.create', 'section.edit'
                        ];
                        ?>
                        <li class="nav-item">
                            <a href="{{ route('section') }}"
                               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-list-ol"></i>
                                <p>উপাংশ </p>
                            </a>
                        </li>
                    @endif
                    @if(in_array(auth()->user()->role,[2,5]))
                        @includeIf('layouts.partial.__common_menus')
                    @endif
                    @if(in_array(auth()->user()->role,[2]))
                        @includeIf('layouts.partial.__account_menus')
                    @endif
                    @if(in_array(auth()->user()->role,[3]))
                        @includeIf('layouts.partial.__hr_payroll_menus')
                    @endif
                    @if(in_array(auth()->user()->role,[4]))
                        @includeIf('layouts.partial.__sweeper_bill_menus')
                    @endif
                    @if(in_array(auth()->user()->role,[5]))
                        @includeIf('layouts.partial.__cashbook_menus')
                    @endif
                    @if(in_array(auth()->user()->role,[6]))
                        @includeIf('layouts.partial.__holding_tax_menus')
                    @endif
                    @if(in_array(auth()->user()->role,[7]))
                        @includeIf('layouts.partial.__trade_license_menus')
                    @endif
                    @if(in_array(auth()->user()->role,[8]))
                        @includeIf('layouts.partial.__collection_menus')
                    @endif
                    @if(in_array(auth()->user()->role,[9]))
                        @includeIf('layouts.partial.__auto_rickshaw_menus')
                    @endif
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="min-height: 90vh !important;">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1 class="m-0"> @yield('title') </h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>

    <!-- Main Footer -->
    <footer class="main-footer text-sm">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
            Design & Developed By <a target="_blank" href="https://2aitlimited.com">2A IT LIMITED</a>
        </div>
        <!-- Default to the left -->
        <strong>
            Copyright &copy; 2022-{{ date('Y') }} <a
                href="{{ route('dashboard') }}">{{ config('app.name') }}</a>.</strong> All rights reserved.
    </footer>
</div>
<!-- ./wrapper -->
<!-- REQUIRED SCRIPTS -->
@include('layouts.partial.__script')
<script>
    $(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var message = '{{ session('message') }}';
        var error = '{{ session('error') }}';

        if (!window.performance || window.performance.navigation.type != window.performance.navigation.TYPE_BACK_FORWARD) {
            if (message != '')
                $(document).Toasts('create', {
                    icon: 'fas fa-envelope fa-lg',
                    class: 'bg-success',
                    title: 'Success',
                    autohide: true,
                    delay: 2000,
                    body: message
                })

            if (error != '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: error,
                })

                $(document).Toasts('create', {
                    icon: 'fas fa-envelope fa-lg',
                    class: 'bg-danger',
                    title: 'Error',
                    autohide: true,
                    delay: 2000,
                    body: error
                })
            }

        }
    });
</script>

<script>
    $(function () {

//Date picker
        $(".date-picker").datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
        });
//Date picker

        $('.month-picker').MonthPicker({
            Button: false,
        });
        $("#financial_year").change(function () {
            let FYear = $(this).val();
            if (FYear !== '') {
                fiscalYearDateRange(FYear)
                $('.date-picker-fiscal-year').prop('readonly', false);
                $('.date-picker-fiscal-year').attr("placeholder", "Enter Date");
            } else {
                $('.date-picker-fiscal-year').prop('readonly', true);
                $('.date-picker-fiscal-year').val(" ");
                $('.date-picker-fiscal-year').attr("placeholder", "Enter Date");
            }
        })
        $("#financial_year").trigger('change');

//Bootstrap Duallistbox
        $('.duallistbox').bootstrapDualListbox()
//Colorpicker
        $('.my-colorpicker1').colorpicker()
//color picker with addon
        $('.my-colorpicker2').colorpicker()
        $('.my-colorpicker2').on('colorpickerChange', function (event) {
            $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
        })
        $("input[data-bootstrap-switch]").each(function () {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        })

    })

    function fiscalYearDateRange(year) {

        $(".date-picker-fiscal-year").datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
            minDate: '01-07-' + year,
            maxDate: '30-06-' + (parseFloat(year) + 1)
        });
    }

    function jsNumberFormat(yourNumber) {
//Seperates the components of the number
        var n = yourNumber.toString().split(".");
//Comma-fies the first part
        n[0] = n[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
//Combines the two sections
        return n.join(".");
    }

    function formSubmitConfirm(btnIdName) {
        $('body').on('click', '#' + btnIdName, function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure to save?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#343a40',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Save It!'

            }).then((result) => {
                if (result.isConfirmed) {
                    $('form').submit();
                }
            })

        });
    }

    function customDateInit() {
        $(".date-picker").datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
        });
    }

    function customSelect2Init() {
        $('.select2').select2();
    }

    function jqueryFormatDate(dateString) {
        var formattedDate = moment(dateString).format('DD-MM-YYYY');
        return formattedDate;
    }

    function replaceNumbersWithBengali(selector) {
// Map of English to Bengali numbers
        var numberMap = {
            '0': '০',
            '1': '১',
            '2': '২',
            '3': '৩',
            '4': '৪',
            '5': '৫',
            '6': '৬',
            '7': '৭',
            '8': '৮',
            '9': '৯'
        };

// Get all elements matching the selector
        var elements = $(selector);

// Iterate through each element
        elements.each(function () {
            var text = $(this).text(); // Get the current element's text content

// Replace English numbers with Bengali numbers
            for (var i = 0; i < text.length; i++) {
                var char = text[i];
                if (numberMap.hasOwnProperty(char)) {
                    text = text.replace(char, numberMap[char]);
                }
            }

// Set the updated text content
            $(this).text(text);
        });
    }

    $(document).ready(function () {
        $('.select2').select2();
    });
</script>
@yield('script')
<!-- AdminLTE App -->
<script src="{{ asset('themes/backend/dist/js/adminlte.min.js') }}"></script>
</body>
</html>

