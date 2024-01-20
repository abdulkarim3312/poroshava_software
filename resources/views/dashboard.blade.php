@extends('layouts.app')

@section('title')
    ড্যাশবোর্ড
@endsection
@section('style')
    <style>
        .small-box.bg-gradient-success {
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    @if(auth()->user()->role == \App\Enumeration\Role::$SWEEPER_BILL)
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">

            <div onclick="changePage('{{ route('area') }}')" class="small-box bg-gradient-success">
                <div class="inner">
                    <h3>{{ $totalArea }}</h3>

                    <p>এলাকা সংখ্যা</p>
                </div>
                <div class="icon">
                    <i class="fa fa-map-o"></i>
                </div>
                <a href="{{ route('area') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div onclick="changePage('{{ route('team') }}')" class="small-box bg-gradient-success">
                <div class="inner">
                    <h3>{{ $totalTeam }}</h3>

                    <p>দল সংখ্যা</p>
                </div>
                <div class="icon">
                    <i class="fa fa-map-o"></i>
                </div>
                <a href="{{ route('team') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div onclick="changePage('{{ route('type') }}')" class="small-box bg-gradient-success">
                <div class="inner">
                    <h3>{{ $totalType }}</h3>

                    <p>ধরন সংখ্যা</p>
                </div>
                <div class="icon">
                    <i class="fa fa-map-o"></i>
                </div>
                <a href="{{ route('type') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div onclick="changePage('{{ route('cleaner') }}')" class="small-box bg-gradient-success">
                <div class="inner">
                    <h3>{{ $totalCleaner }}</h3>

                    <p>পরিচ্ছন্ন কর্মী সংখ্যা</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <a href="{{ route('cleaner') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    @elseif(auth()->user()->role == \App\Enumeration\Role::$TRADE_LICENSE)
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">

                <div class="small-box bg-gradient-success">
                    <div class="inner">
                        <h3>{{ enNumberToBn(totalTradeLincenseApplication()) }}</h3>

                        <p>মোট আবেদনের সংখ্যা</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-map-o"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="small-box bg-gradient-info">
                    <div class="inner">
                        <h3>{{ enNumberToBn(totalTradeLincenseProcessingApplication()) }}</h3>

                        <p>বিবেচনাধীন আবেদনের সংখ্যা</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-map-o"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="small-box bg-gradient-info">
                    <div class="inner">
                        <h3>{{ enNumberToBn(totalTradeLicenseCount()) }}</h3>

                        <p>লাইসেন্সধারীর সংখ্যা</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-map-o"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="small-box bg-gradient-primary">
                    <div class="inner">
                        <h3>{{ enNumberToBn(totalTradeLicenseRenewCount()) }}</h3>

                        <p>নবায়নকৃত লাইসেন্স সংখ্যা</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-map-o"></i>
                    </div>
                </div>
            </div>
        </div>
    @elseif(auth()->user()->role == \App\Enumeration\Role::$COLLECTION)
        <div class="row">
            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-gradient-success elevation-1"><span style="font-size: 43px;color: #fff;font-weight: bold">৳</span></span>
                    <div class="info-box-content">
                        <span class="info-box-text">আজকের ফিস আদায়</span>
                        <span class="info-box-number">{{ en_to_bn($collections->sum('fees')) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-gradient-success elevation-1"><span style="font-size: 43px;color: #fff;font-weight: bold">৳</span></span>
                    <div class="info-box-content">
                        <span class="info-box-text">আজকের ভ্যাট আদায়</span>
                        <span class="info-box-number">{{ en_to_bn($collections->sum('vat')) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-gradient-success elevation-1"><span style="font-size: 43px;color: #fff;font-weight: bold">৳</span></span>
                    <div class="info-box-content">
                        <span class="info-box-text">আজকের সাব টোটাল</span>
                        <span class="info-box-number">{{ en_to_bn($collections->sum('sub_total')) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-gradient-success elevation-1"><span style="font-size: 43px;color: #fff;font-weight: bold">৳</span></span>
                    <div class="info-box-content">
                        <span class="info-box-text">আজকের ডিসকাউন্ট</span>
                        <span class="info-box-number">{{ en_to_bn($collections->sum('discount')) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-gradient-success elevation-1"><span style="font-size: 43px;color: #fff;font-weight: bold">৳</span></span>
                    <div class="info-box-content">
                        <span class="info-box-text">আজকের গ্রান্ড টোটাল</span>
                        <span class="info-box-number">{{ en_to_bn($collections->sum('grand_total')) }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@section('script')
    <script>
        function changePage($link){
            console.log($link);
            window.location.href = $link;
        }
    </script>
@endsection
