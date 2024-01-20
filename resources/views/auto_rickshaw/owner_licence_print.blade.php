@extends('layouts.app')
@section('style')
    <style>

        #printable{
            margin: 0px auto;
        }

        .print_area{
            width: 100%;
            height: 1100px;
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
            transform: translate(-30%, -50%);
            opacity: 0.3 !important;
            width: 300px;
            height: 300px;
            background: url({{ asset('img/dohar_logo.jpg') }}) no-repeat center/90% !important;

        }

        .print_area .print-footer
        {
            width: 100%;
            position: relative;
            height: 0px;
            top: 0px;
        }
        .print_area .print-footer .footer-content1{
            position: relative;
            width: 40%;
            /* right: 30px; */
            bottom: 24px;
            float: left;


        }
        .print_area .print-footer .footer-content2{
            position: relative;
            width: 40%;
            /*left: 30px;*/
            bottom: 20px;
            float: right;

        }




        @media print {
            * {
                -webkit-print-color-adjust: exact !important;
            }
            body{
                font-size:18px;
            }
            .print_area{

                width: 100%;
                height: 1340px;
                background: url("{{asset('img/bimage.png')}}") no-repeat;
                margin: 0 auto;
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
                transform: translate(-50%, -50%);
                -webkit-transform: translate(-50%, -70%);
                opacity: 0.1 !important;
                width: 400px;
                height: 400px;

                background: url("{{asset('/')}}public/logo.png") no-repeat contain;
            }


            .print_area .header-area .left-header{
                position: relative;
                left: 30px;
                font-size:18px;
            }
            .print_area #pottoyon_text{ padding-left: 40px;padding-right:40px;font-size:18px !important;color:#000 !important; text-align: justify;font-weight:bold;line-height:1.7;}
            .heading .certificate-title{margin-right: 30px;font-weight:bold;font-size:22px;padding-top:5px;padding-bottom:5px;}
            .print_area .print-footer{margin-top:110px;}


            .qr-code {
                right: -100px !important;
                top: 196px !important;
            }
        }
        .driver-info p {
            font-weight: normal;
            font-size: 16px;
            margin-bottom: 0;
        }
        .print_area .print-footer {
            top: 89px !important;
        }
        section.card {
            margin-top: 55px;
        }
        .table thead > tr > th, .table tbody > tr > th, .table tfoot > tr > th, .table thead > tr > td, .table tbody > tr > td, .table tfoot > tr > td {
            padding: 3px;
        }

        .qr-code {
            position: absolute;
            right: 107px;
            top: 202px;
        }

    </style>
@endsection
@section('title','মালিকের লাইসেন্স')
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
                                <div class="left-header" style="font-size: 18px;">লাইসেন্স নং :- <sapn style="border-bottom: dotted 1px black">{{ str_replace($en, $bn, $ownerLicense->licenseno)}}</sapn></div>
                                <div class="right-header" style="font-size: 18px;">প্লেট নং :- <sapn style="border-bottom: dotted 1px black">{{ str_replace($en, $bn,$ownerLicense->plate_no) }}</sapn></div>
                            </div>
                            <br style="clear: both">
                            <div class="heading text-center">
                                <h1 style="margin: 0;">{{ config('app.full_name') }}</h1>
                                <img src="{{ asset('img/dohar_logo.jpg') }}" style="display:block;width: 120px;margin: 5px auto">
                                <div class="certificate-title" style="border:solid 3px black;text-align: center;">
                                    {{ $ownerLicense->type->name }}
                                </div>

                                <div class="qr-code">
                                    <?php
                                    $qrText = 'লাইসেন্স নং.:-'.str_replace($en, $bn, $ownerLicense->licenseno).'.';
                                    $qrText .='ক্রমিক নং:-'.str_replace($en, $bn,$ownerLicense->slno).'.';
                                    $qrText .='ধরণ:-'.$ownerLicense->type->name.'.';
                                    $qrText .='এনইডিঃ'.str_replace($en, $bn,$ownerLicense->nid).'.';
                                    $qrText .='মালিকের নাম নামঃ'.$ownerLicense->name.'.';
                                    ?>
                                    {{ QrCode::size(90)->generate(utf8_encode($qrText)) }}
                                </div>
                                <h3 style="margin-bottom: 0 !important;margin-top: 10px;">অর্থ বৎসর: {{ str_replace($en, $bn, $ownerLicense->year)}}</h3>
                            </div>


                            <div class="col-md-12" id="pottoyon_text" style="line-height:1.7">
                                গত ইং ২৪/০৫/২০২১ তারিখে পৌরসভার সাধারণ সভায় বিবিধ ৬ ধারার সিদ্ধান্ত  মোতাবেক নিম্ন  লিখিত ফি ধার্য হয়েছে।এই লাইসেন্স ২০২৩ সালের ৩০ শে জুন পর্যন্ত বলবৎ থাকিবে।যদি না সত্তর বাতিল করা হয়।
                                <div class="row" style="margin-top: 10px!important;">
                                    <div class="col-12">
                                        <div class="driver-info">
                                            <p>মালিকের নামঃ {{ $ownerLicense->name }}</p>
                                            <p>পিতার নামঃ {{ $ownerLicense->fname }}</p>
                                            <p>স্থায়ী ঠিকানাঃ {{ $ownerLicense->address }}</p>
                                            <p>বর্তমান ঠিকানাঃ {{ $ownerLicense->current_address }}</p>
                                            <p>এনইডিঃ {{ str_replace($en, $bn, $ownerLicense->nid)}}</p>
                                            <p>জেলাঃ {{ config('app.name') }}</p>
                                            <p>প্রদানের তারিখঃ {{ str_replace($en, $bn, date('d-m-Y',strtotime($ownerLicense->delivery_date)))}}</p>
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
                                                    <td class="text-right">{{ str_replace($en, $bn, number_format($ownerLicense->licensefee))}}</td>
                                                </tr>
                                                <tr>
                                                    <td>ভ্যাট</td>
                                                    <td class="text-center">{{ str_replace($en, $bn, 15)}}%</td>
                                                    <td class="text-right">{{ str_replace($en, $bn, number_format($ownerLicense->vat))}}</td>
                                                </tr>
                                                <tr>
                                                    <td>টিনপ্লেট</td>
                                                    <td class="text-center">প্রতিটি</td>
                                                    <td class="text-right">{{ str_replace($en, $bn, number_format($ownerLicense->tinplate))}}</td>
                                                </tr>
                                                <tr>
                                                    <td>নাম পরিবর্তন</td>
                                                    <td></td>
                                                    <td class="text-right">{{ str_replace($en, $bn, number_format($ownerLicense->name_change_fees))}}</td>
                                                </tr>
                                                <tr>
                                                    <td>অন্যান্য</td>
                                                    <td></td>
                                                    <td class="text-right">{{ str_replace($en, $bn, number_format($ownerLicense->others))}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right" colspan="2">গৃহিত মোট টাকা</td>
                                                    <td class="text-right">{{ str_replace($en, $bn, number_format($ownerLicense->total + $ownerLicense->name_change_fees + $ownerLicense->others))}}</td>
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
                                        <strong style="border-top: 1px dashed #000 !important;">পৌর নির্বাহী কর্মকর্তা</strong><br>
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
