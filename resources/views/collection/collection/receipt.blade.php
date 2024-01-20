<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $collection->receipt_no }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="{{ asset('themes/backend/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>

        span.under-dott {
            position: relative;
            display: block;
        }

        span.under-dott:before {
            position: absolute;
            bottom: 0;
            height: 2px;
            border-bottom: 2px dashed #000;
            content: "";
        }
        span.dott-1:before{
            width: 85%;
            left: 9%;
        }
        span.dott-2:before{
            width: 80%;
            left: 14%;
        }
        span.dott-3:before{
            width: 83%;
            left: 11%;
        }
        span.dott-4:before{
            width: 71%;
            left: 23%;
        }
        span.dott-5:before{
            width: 82%;
            left: 12%;
        }

        .water-marks {
            position: absolute;
            right: 29%;
            top: 6%;
            opacity: 0.2;
        }
        .water-marks2 {
            position: absolute;
            right: 63%;
            top: 6%;
            opacity: 0.2;
        }

        .water-marks img {
            width: 100px;
        }
        .water-marks2 img {
            width: 100px;
        }
        .middle-dotted {
            position: absolute;
            right: 14.5%;
            width: 100%;
            height: 100%;
            content: "";
            border-top: 2px dashed #000;
            transform: rotate(90deg);
        }
        .middle-dotted2 {
            position: absolute;
            right: 48.7%;
            width: 100%;
            height: 100%;
            content: "";
            border-top: 2px dashed #000;
            transform: rotate(90deg);
        }
    </style>
</head>
<body>
<?php
    $en = [0,1,2,3,4,5,6,7,8,9];
    $bn = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];

?>
<div class="container-fluid" style="position: relative;overflow: hidden">
    <div class="water-marks2">
        <img src="{{ asset('img/dohar_logo.jpg') }}" alt="">
    </div>
    <div class="water-marks">
        <img src="{{ asset('img/dohar_logo.jpg') }}" alt="">
    </div>
    <div class="middle-dotted2"></div>
    <div class="middle-dotted"></div>
    <div class="row" style="margin-top: 20px">
        <div class="col-4 pl-0">
            <div class="heading">
                <h1 class="text-center"><img height="70px" src="{{ asset('img/dohar_logo.jpg') }}" alt=""></h1>
                <h5 class="text-center"><b>{{ config('app.name') }}, ফরিদপুর।</b></h5>
                <span style="font-size: 13px;display: block"><b>{{ bn_number($collection->id) }} নং ফর্ম</b></span>
                <span style="font-size: 13px;display: block"><b> [৯৮ ও ১১১ বিধানগুলি দেখুন]</b></span>
                <h2 class="text-center" style="margin-top: 5px;"><b>বিবিধ রশিদ</b></h2>
            </div>
            <div class="body-content">
                <div class="row">
                    <div class="col-6" style="font-size: 15px">ক্রমিক নং {{ str_replace($en,$bn,$collection->receipt_no) }}</div>
                    <div class="col-6" style="font-size: 15px">তারিখঃ {{ str_replace($en,$bn,\Carbon\Carbon::parse($collection->date)->format('d-m-Y')) }}</div>
                </div>
                <div class="row">
                    <div class="col-12" style="padding-bottom: 8px;font-size: 17px;"><span  class="under-dott dott-1">নামঃ {{ $collection->name }}</span></div>
                    <div class="col-12" style="padding-bottom: 8px;font-size: 17px;"><span  class="under-dott dott-4">মোবাইল নম্বরঃ {{ $collection->mobile_no }}</span></div>
                    <div class="col-12" style="padding-bottom: 8px;font-size: 17px;"><span  class="under-dott dott-4">হোল্ডিং নম্বরঃ {{ $collection->holding_no }}</span></div>
                    <div class="col-12" style="padding-bottom: 8px;font-size: 17px"><span class="under-dott dott-2">ঠিকানাঃ {{ $collection->area->area_name ?? '' }}</span></div>
                    <div class="col-12" style="padding-bottom: 8px;font-size: 17px"><span class="under-dott dott-3">বাবদঃ {{ $collection->subType->name ?? '' }}</span></div>
                    <div class="col-12" style="padding-bottom: 8px;font-size: 17px"><span class="under-dott dott-4">টাকাঃ(অংকে) {{ str_replace($en,$bn,number_format($collection->grand_total,2)) }}</div>
                    <div class="col-12" style="padding-bottom: 8px;font-size: 17px"><span class="under-dott dott-5">কথায়ঃ {{ $collection->bangla_fees }} টাকা মাত্র।</span></div>
                </div>

            </div>
            <div class="row">
                <div class="col-6">
                    <h6 class="text-center" style="font-size: 11px;">
                        <img height="70px" src="{{ asset('img/meyor.png') }}" alt=""><br>
                        মেয়র<br>{{ config('app.name') }}
                    </h6>
                </div>
                <div class="col-6 ">
                    <h6 class="text-center" style="font-size: 11px;">
                        <img height="70px" src="{{ asset('img/ceo.png') }}" alt=""><br>
                        প্রধান নির্বাহী কর্মকর্তা <br>{{ config('app.name') }}
                    </h6>
                </div>

            </div>
            <div class="row" style="margin-top: 5px;">
                <div class="col-6">
                    <h6 class="text-center" style="font-size: 11px;">
                        <img class="text-center" height="70px" src="{{ asset('img/accounts.png') }}" alt=""><br>
                        হিসাবরক্ষক<br>{{ config('app.name') }}</h6>
                </div>
                <div class="col-6">
                    <h6 class="text-center" style="font-size: 11px;margin-top: 70px">
                        আদায়কারীর সাক্ষর<br>{{ config('app.name') }}</h6>
                </div>
            </div>
        </div>
        <div class="col-4 pl-0">
            <div class="heading">
                 <h1 class="text-center"><img height="70px" src="{{ asset('img/dohar_logo.jpg') }}" alt=""></h1>
                <h5 class="text-center"><b>{{ config('app.name') }}, ফরিদপুর।</b></h5>
                <span style="font-size: 13px;display: block"><b>{{ bn_number($collection->id) }} নং ফর্ম</b></span>
                <span style="font-size: 13px;display: block"><b> [৯৮ ও ১১১ বিধানগুলি দেখুন]</b></span>
                <h2 class="text-center" style="margin-top: 5px;"><b>বিবিধ রশিদ</b></h2>
            </div>
            <div class="body-content">
                <div class="row">
                    <div class="col-6" style="font-size: 15px">ক্রমিক নং {{ str_replace($en,$bn,$collection->receipt_no) }}</div>
                    <div class="col-6" style="font-size: 15px">তারিখঃ {{ str_replace($en,$bn,\Carbon\Carbon::parse($collection->date)->format('d-m-Y')) }}</div>
                </div>
                <div class="row">
                    <div class="col-12" style="padding-bottom: 8px;font-size: 17px;"><span  class="under-dott dott-1">নামঃ {{ $collection->name }}</span></div>
                    <div class="col-12" style="padding-bottom: 8px;font-size: 17px;"><span  class="under-dott dott-4">মোবাইল নম্বরঃ {{ $collection->mobile_no }}</span></div>
                    <div class="col-12" style="padding-bottom: 8px;font-size: 17px;"><span  class="under-dott dott-4">হোল্ডিং নম্বরঃ {{ $collection->holding_no }}</span></div>
                    <div class="col-12" style="padding-bottom: 8px;font-size: 17px"><span class="under-dott dott-2">ঠিকানাঃ {{ $collection->area->area_name ?? '' }}</span></div>
                    <div class="col-12" style="padding-bottom: 8px;font-size: 17px"><span class="under-dott dott-3">বাবদঃ {{ $collection->subType->name ?? '' }}</span></div>
                    <div class="col-12" style="padding-bottom: 8px;font-size: 17px"><span class="under-dott dott-4">টাকাঃ(অংকে) {{ str_replace($en,$bn,number_format($collection->grand_total,2)) }}</div>
                    <div class="col-12" style="padding-bottom: 8px;font-size: 17px"><span class="under-dott dott-5">কথায়ঃ {{ $collection->bangla_fees }} টাকা মাত্র।</span></div>
                </div>

            </div>
            <div class="row">
                <div class="col-6">
                    <h6 class="text-center" style="font-size: 11px;">
                        <img height="70px" src="{{ asset('img/meyor.png') }}" alt=""><br>
                        মেয়র<br>{{ config('app.name') }}
                    </h6>
                </div>
                <div class="col-6 ">
                    <h6 class="text-center" style="font-size: 11px;">
                        <img height="70px" src="{{ asset('img/ceo.png') }}" alt=""><br>
                        প্রধান নির্বাহী কর্মকর্তা <br>{{ config('app.name') }}
                    </h6>
                </div>

            </div>
            <div class="row" style="margin-top: 5px;">
                <div class="col-6">
                    <h6 class="text-center" style="font-size: 11px;">
                        <img class="text-center" height="70px" src="{{ asset('img/accounts.png') }}" alt=""><br>
                        হিসাবরক্ষক<br>{{ config('app.name') }}</h6>
                </div>
                <div class="col-6">
                    <h6 class="text-center" style="font-size: 11px;margin-top: 70px">
                        আদায়কারীর সাক্ষর<br>{{ config('app.name') }}</h6>
                </div>
            </div>
        </div>
        <div class="col-4 pl-0">
            <div class="heading">
                 <h1 class="text-center"><img height="70px" src="{{ asset('img/dohar_logo.jpg') }}" alt=""></h1>
                <h5 class="text-center"><b>{{ config('app.name') }}, ফরিদপুর।</b></h5>
                <span style="font-size: 13px;display: block"><b>{{ bn_number($collection->id) }} নং ফর্ম</b></span>
                <span style="font-size: 13px;display: block"><b> [৯৮ ও ১১১ বিধানগুলি দেখুন]</b></span>
                <h2 class="text-center" style="margin-top: 5px;"><b>বিবিধ রশিদ</b></h2>
            </div>
            <div class="body-content">
                <div class="row">
                    <div class="col-6" style="font-size: 15px">ক্রমিক নং {{ str_replace($en,$bn,$collection->receipt_no) }}</div>
                    <div class="col-6" style="font-size: 15px">তারিখঃ {{ str_replace($en,$bn,\Carbon\Carbon::parse($collection->date)->format('d-m-Y')) }}</div>
                </div>
                <div class="row">
                    <div class="col-12" style="padding-bottom: 8px;font-size: 17px;"><span  class="under-dott dott-1">নামঃ {{ $collection->name }}</span></div>
                    <div class="col-12" style="padding-bottom: 8px;font-size: 17px;"><span  class="under-dott dott-4">মোবাইল নম্বরঃ {{ $collection->mobile_no }}</span></div>
                    <div class="col-12" style="padding-bottom: 8px;font-size: 17px;"><span  class="under-dott dott-4">হোল্ডিং নম্বরঃ {{ $collection->holding_no }}</span></div>
                    <div class="col-12" style="padding-bottom: 8px;font-size: 17px"><span class="under-dott dott-2">ঠিকানাঃ {{ $collection->area->area_name ?? '' }}</span></div>
                    <div class="col-12" style="padding-bottom: 8px;font-size: 17px"><span class="under-dott dott-3">বাবদঃ {{ $collection->subType->name ?? '' }}</span></div>
                    <div class="col-12" style="padding-bottom: 8px;font-size: 17px"><span class="under-dott dott-4">টাকাঃ(অংকে) {{ str_replace($en,$bn,number_format($collection->grand_total,2)) }}</div>
                    <div class="col-12" style="padding-bottom: 8px;font-size: 17px"><span class="under-dott dott-5">কথায়ঃ {{ $collection->bangla_fees }} টাকা মাত্র।</span></div>
                </div>

            </div>
            <div class="row">
                <div class="col-6">
                    <h6 class="text-center" style="font-size: 11px;">
                        <img height="70px" src="{{ asset('img/meyor.png') }}" alt=""><br>
                        মেয়র<br>{{ config('app.name') }}
                    </h6>
                </div>
                <div class="col-6 ">
                    <h6 class="text-center" style="font-size: 11px;">
                        <img height="70px" src="{{ asset('img/ceo.png') }}" alt=""><br>
                        প্রধান নির্বাহী কর্মকর্তা <br>{{ config('app.name') }}
                    </h6>
                </div>

            </div>
            <div class="row" style="margin-top: 5px;">
                <div class="col-6">
                    <h6 class="text-center" style="font-size: 11px;">
                        <img class="text-center" height="70px" src="{{ asset('img/accounts.png') }}" alt=""><br>
                        হিসাবরক্ষক<br>{{ config('app.name') }}</h6>
                </div>
                <div class="col-6">
                    <h6 class="text-center" style="font-size: 11px;margin-top: 70px">
                        আদায়কারীর সাক্ষর<br>{{ config('app.name') }}</h6>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
     window.print();
     window.onafterprint = function(){ window.close()};
</script>
</body>
</html>
