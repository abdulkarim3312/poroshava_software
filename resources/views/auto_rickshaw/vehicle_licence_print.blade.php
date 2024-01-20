@extends('layouts.app')
@section('title','চালকের লাইসেন্স')
@section('style')
    <style>

        #printable{
            margin: 0 auto;
        }

        .print_area{

            width: 100%;

            background: url("{{asset('img/bimage.png')}}") no-repeat !important;
            margin: 0 auto;
            padding: 60px;
            background-size: 100% 100% !important;



        }
        .print_area .header-area{

            margin: 10px auto;
            width: 100%;


        }
        .print_area .header-area .left-header{
            width: 50%;
            float: left;
            padding: 10px;
        }
        .print_area .header-area .right-header{
            width: 50%;
            float:left;
            padding: 10px 10px;
            text-align: right;
        }
        .print_area  .heading{
            width: 95%;
            margin: 10px auto;
        }

        .print_area .cover-img {
            position: absolute;
            top: 126px;
            left: 356px;
            transform: translate(-20%, -20%);
            opacity: 0.3 !important;
            width: 300px;
            height: 300px;
            background: url({{ asset('img/dohar_logo.jpg') }}) no-repeat center/90% !important;

        }

        .print_area .print-footer
        {
            width: 100%;
            position: relative;
            height: 400px;
            top: 0;



        }
        .print_area .print-footer .footer-content1{
            position: relative;
            width: 40%;
            /* right: 30px; */
            bottom: 20px;
            float: left;


        }
        .print_area .print-footer .footer-content2{
            position: relative;
            width: 40%;
            /*left: 30px;*/
            bottom: 20px;
            float: right;

        }
        img.signature{
            position: absolute;
            margin-top: -19px;
            margin-left: 36px;
        }



        .print_area {

            width: 100%;
            height: 1050px;
        }
        .print_area .print-footer {
            top: 72px !important;
        }
        @media print {
            * {
                -webkit-print-color-adjust: exact !important;
            }
            body{
                font-size:18px;
            }
            .qr-code {
                right: -100px !important;
                top: 190px;
            }
            .print_area{

                width: 100%;
                height: 1150px;
                background: url("{{asset('img/bimage.png')}}") no-repeat;
                margin: 0px auto;
                background-size: 100% 100%;

            }
            .print_area .header-area .right-header{
                position: relative;
                right: 30px;
                font-size:18px;
            }
            .print_area .cover-img {
                position: absolute;
                top: 300px;
                left: 450px;
                transform: translate(-50%, -70%);
                -webkit-transform: translate(-50%, -70%);
                opacity: 0.1 !important;
                width: 400px;
                height: 400px;
                background: url("{{asset('img/dohar_logo.jpg')}}") no-repeat contain;
            }


            .print_area .header-area .left-header{
                position: relative;
                left: 30px;
                font-size:18px;
            }
            .print_area #pottoyon_text{ padding-left: 40px;padding-right:40px;font-size:18px !important;color:#000 !important; text-align: justify;font-weight:bold;line-height:1.7;}
            .heading .certificate-title{margin-right: 30px;font-weight:bold;font-size:22px;padding-top:5px;padding-bottom:5px;}

        }
        .driver-info p {
            font-weight: normal;
            font-size: 16px;
            margin-bottom: 0;
        }

        section.card {
            margin-top: 55px;
        }

        .qr-code {
            position: absolute;
            right: 107px;
            top: 202px;
        }
    </style>

@endsection
@section('content')
    <?php
    $bn = array('১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০');
    $en = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0');
    ?>

    <div class="row">
        <div class="col-12" style="margin-top: -54px;">
            <section class="card">
                <div class="card-header">
                    <button class="btn btn-default btn-print"  onclick="getprint('printable')">Print</button>
                </div>

                <div class="card-body">
                    <div id="printable" class="col-12">
                        <div class="print_area">
                            <div class="header-area" >
                                <div class="left-header" style="font-size: 18px;">লাইসেন্স নং :- <sapn style="border-bottom: dotted 1px black">{{ str_replace($en, $bn, $driverLicense->licenseno)}}</sapn> </div>
                                <div class="right-header" style="font-size: 18px;">ক্রমিক নং:- <sapn style="border-bottom: dotted 1px black">{{ str_replace($en, $bn,$driverLicense->slno) }}</sapn></div>
                            </div>
                            <br style="clear: both">
                            <div class="heading text-center">
                                <h1 style="margin: 0;">{{ config('app.full_name') }}</h1>
                                <img src="{{asset('img/dohar_logo.jpg')}}" style="display:block;width: 120px;margin: 5px auto">
                                <div class="certificate-title" style="border:solid 3px black;text-align: center;">
                                    {{ $driverLicense->type->name }}
                                </div>
                                <div class="qr-code">
                                    <?php
                                    $qrText = 'লাইসেন্স নং.:-'.str_replace($en, $bn, $driverLicense->licenseno).'.';
                                    $qrText .='ক্রমিক নং:-'.str_replace($en, $bn,$driverLicense->slno).'.';
                                    $qrText .='ধরণ:-'.$driverLicense->type->name.'.';
                                    $qrText .='এনইডিঃ'.str_replace($en, $bn,$driverLicense->nid).'.';
                                    $qrText .='চালকের নামঃ'.$driverLicense->name.'.';
                                    ?>

                                    {{ QrCode::size(90)->generate(utf8_encode($qrText)) }}
                                </div>
                                <h3 style="margin-bottom: 0 !important;margin-top: 10px;">অর্থ বৎসর: {{ str_replace($en, $bn, $driverLicense->year)}}</h3>
                            </div>


                            <div class="col-md-12" id="pottoyon_text" style="line-height:1.7">
                                গত ইং ২৪/০৫/২০২১ তারিখে পৌরসভার সাধারণ সভায় বিবিধ ৬ ধারার সিদ্ধান্ত  মোতাবেক নিম্ন  লিখিত ফি ধার্য হয়েছে।এই লাইসেন্স ২০২২ সালের ৩০ শে জুন পর্যন্ত বলবৎ থাকিবে।যদি না সত্তর বাতিল করা হয়।
                                <div class="row" style="margin-top: 10px!important;">
                                    <div class="col-xs-12">
                                        <div class="driver-info">
                                            <p>চালকের নামঃ {{ $driverLicense->name }}</p>
                                            <p>পিতার নামঃ {{ $driverLicense->fname }}</p>
                                            <p>স্থায়ী ঠিকানাঃ {{ $driverLicense->address }}</p>
                                            <p>বর্তমান ঠিকানাঃ {{ $driverLicense->current_address }}</p>
                                            <p>এনইডিঃ {{ str_replace($en, $bn, $driverLicense->nid)}}</p>
                                            <p>জেলাঃ {{ config('app.name') }}</p>
                                            <p>প্রদানের তারিখঃ {{ str_replace($en, $bn, date('d-m-Y',strtotime($driverLicense->delivery_date)))}}</p>
                                        </div>
                                    </div>
                                    <div class="col-8 offset-4">
                                        <div class="fees-info">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th>আইটেম </th>
                                                    <th></th>
                                                    <th>ফির পরিমান</th>
                                                </tr>
                                                <tr>
                                                    <td>লাইসেন্স ফি</td>
                                                    <td></td>
                                                    <td class="text-right">{{ str_replace($en, $bn, number_format($driverLicense->licensefee))}}</td>
                                                </tr>
                                                <tr>
                                                    <td>ভ্যাট</td>
                                                    <td class="text-center">{{ str_replace($en, $bn, 15)}}%</td>
                                                    <td class="text-right">{{ str_replace($en, $bn,number_format($driverLicense->vat))}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right" colspan="2">গৃহিত মোট টাকা</td>
                                                    <td class="text-right">{{ str_replace($en, $bn,number_format( $driverLicense->total))}}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <span class="cover-img"></span>

                            </div>

                            <div class="print-footer">
                                <div class="row">
                                    <div class="col text-center">
                                        <strong style="border-top: 1px dashed #000 !important;">লাইসেন্স পরিদর্শক</strong><br>
                                        <strong>{{ config('app.name') }}</strong>
                                    </div>
                                    <div class="col text-center">
                                        <strong style="border-top: 1px dashed #000 !important;">সচিব</strong><br>
                                        <strong>{{ config('app.name') }}</strong>
                                    </div>
                                    <div class="col text-center">
                                        <strong style="border-top: 1px dashed #000 !important;">মেয়র </strong><br>
                                        <strong>{{ config('app.name') }}</strong>
                                    </div>
                                </div>

                            </div>



                        </div>
                    </div>
                </div>

            </section>
        </div>
    </div>
@endsection
@section('script')
    <script>
        var APP_URL = '{!! url()->full()  !!}';
        function getprint(id){

            $('body').html($('#'+id).html());
            window.print();
            window.location.replace(APP_URL)
        }

    </script>
@endsection
