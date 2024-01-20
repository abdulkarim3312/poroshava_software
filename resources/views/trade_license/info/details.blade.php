@extends('layouts.app')
@section('title','দোহার পৌরসভা')
@section('style')
    <style>

        .table-bordered td, .table-bordered th {
            border: 1px solid #dee2e6;
            vertical-align: middle;
            border-bottom-width: 2px;
            /*text-align: center;*/
        }

        .table-bordered thead td, .table-bordered thead th {
            vertical-align: middle;
        }

        .table thead th {
            border-bottom: 1px solid #000000 !important;
        }

        .table-bordered td, .table-bordered th {
            border: 1px solid #000000 !important;
        }

        .table-bordered td, .table-bordered th {
            padding: 3px !important;
            font-size: 13px !important;
        }

        .table-bordered-modal td, .table-bordered-modal th {
            border: 1px solid #dee2e6 !important;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-default">
                <div class="card-header">
                    <a href="{{ route('trade_license_approve_details',['tradeUser'=>$tradeUser->id]) }}" class="btn btn-info bg-gradient-info btn-sm"><i
                            class="fa fa-edit"></i></a>
                    <a href="#" onclick="getprint('printArea')" class="btn btn-success bg-gradient-success btn-sm"><i
                            class="fa fa-print"></i></a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div id="printArea">
                        <div class="row mb-2 mt-2" style="border-bottom: 1px solid #000; padding: 0px 60px;">
                            <div class="col-3">
                                <span><img src="{{ asset('img/logo.png') }}"/></span>
                            </div>
                            <div class="col-6">
                                <h3 class="text-center m-3" style="margin-bottom: 5px !important;font-size: 18px !important;font-weight: bold">
                                    গণপ্রজাতন্ত্রী বাংলাদেশ সরকার
                                </h3>
                                <h1 class="text-center m-0" style="margin-bottom: 5px !important;font-size: 25px !important;font-weight: bold">
                                    {{ config('app.name') }}
                                </h1>
                                <h5 class="text-center" style="font-size: 15px !important;"><strong>দোহার, ঢাকা</strong></h5>
                                <h3 class="text-center" style="font-size: 17px !important;">ট্রেড/প্রফেশন লাইসেন্স</h3>
                            </div>
                            <div class="col-3 text-right">
                                <span><img src="{{ asset('img/dohar_logo.jpg') }}" width="70"/></span>
                            </div>
                        </div>
                        <div class="row mb-2" style="padding: 0px 60px;font-size: 14px;">
                            <div class="col-3">
                                <strong>লাইসেন্স নং</strong>
                                <strong style="float: right">:</strong>
                            </div>
                            <div class="col-7 ml-4">
                                <strong>{{ enNumberToBn($tradeUser->licence_no) }}</strong>
                            </div>
                        </div>
                        <div class="row mb-2" style="padding: 0px 60px;font-size: 14px;">
                            <div class="col-3">
                                <strong>লাইসেন্স আইডি</strong>
                                <strong style="float: right">:</strong>
                            </div>
                            <div class="col-7 ml-4">
                                <strong>{{ enNumberToBn($tradeUser->licence_id) }}</strong>
                            </div>
                        </div>
                        <div class="row mb-2" style="padding: 0px 60px;font-size: 14px;">
                            <div class="col-3">
                                <strong>ওয়ার্ড নং</strong>
                                <strong style="float: right">:</strong>
                            </div>
                            <div class="col-7 ml-4">
                                <strong>{{ enNumberToBn($tradeUser->wardInfo->ward_no??'') }}নং ওয়ার্ড</strong>
                            </div>
                        </div>
                        <div class="row mb-2" style="padding: 0px 60px;font-size: 14px;">
                            <div class="col-3">
                                <strong>সার্কেল/রাস্তা/মহল্লা</strong>
                                <strong style="float: right">:</strong>
                            </div>
                            <div class="col-7 ml-4">
                                <strong>{{ enNumberToBn($tradeUser->areaInfo->road_name??'') }}</strong>
                            </div>
                        </div>
                        <div class="row mb-2" style="padding: 0px 60px;font-size: 14px;">
                            <div class="col-3">
                                <strong>লাইসেন্স ইস্যুর তারিখ</strong>
                                <strong style="float: right">:</strong>
                            </div>
                            <div class="col-7 ml-4">
                                <strong>{{ enNumberToBn(date('d-m-Y',strtotime($tradeUser->licence_issue_date))) }}</strong>
                            </div>
                        </div>
                        <div class="row mb-2" style="padding: 0px 60px;font-size: 14px;">
                            <div class="col-3">
                                <strong>নবায়নের অর্থ বছর</strong>
                                <strong style="float: right">:</strong>
                            </div>
                            <div class="col-7 ml-4">
                                <strong>{{ enNumberToBn($tradeUser->financial_year) }}</strong>
                            </div>
                        </div>
                        <div class="row mb-4" style="padding: 0px 60px;font-size: 14px;">
                            <div class="col-3">
                                <strong>নবায়নের তারিখ</strong>
                                <strong style="float: right">:</strong>
                            </div>
                            <div class="col-7 ml-4">
                                <strong>{{ enNumberToBn(date('d-m-Y',strtotime($tradeUser->renewal_date))) }}</strong>
                            </div>
                        </div>
                        @php
                            $m = date('m');
                            $y = date('Y');
                            if ($m>6){
                               $y += 1;
                            }
                        @endphp
                        <div class="row mb-4" style="padding: 0px 40px;font-size: 14px;">
                            <div class="col-12">
                                <strong>পৌরসভা আইন-২০০৯ এর ১০২-১০৮ ধারার ৩য় তফসিল এর ৮, ১০, ১৯ ও ২২ আইটেম অনুসারে (ট্রেড, প্রফেশন, কলিং ও বিজ্ঞাপন) ব্যবসা/পেশার অনুমোদন পত্র নিম্নে ব্যক্তি/প্রতিষ্ঠানের অনুকূলে দেওয়া হইল। যাহার মেয়াদ {{ enNumberToBn($y) }} ইং সনের ৩০ জুন পর্যন্ত বলবৎ থাকিবে।</strong>
                            </div>
                        </div>
                        <div class="row mb-2" style="padding: 0px 60px;font-size: 14px;">
                            <div class="col-3">
                                <strong>১। ব্যবসা প্রতিষ্ঠানের নাম</strong>
                                <strong style="float: right">:</strong>
                            </div>
                            <div class="col-7 ml-4">
                                <strong>{{ $tradeUser->organization_name }}</strong>
                            </div>
                        </div>
                        <div class="row mb-2" style="padding: 0px 60px;font-size: 14px;">
                            <div class="col-3">
                                <strong>২। ব্যবসার ধরন</strong>
                                <strong style="float: right">:</strong>
                            </div>
                            <div class="col-7 ml-4">
                                <strong>৬(১১)(৮) চা/ পান/ সিগারেট এর দোকান</strong>
                            </div>
                        </div>
                        <div class="row mb-2" style="padding: 0px 60px;font-size: 14px;">
                            <div class="col-3">
                                <strong>৩। মালিকের নাম</strong>
                                <strong style="float: right">:</strong>
                            </div>
                            <div class="col-7 ml-4">
                                <strong>{{ $tradeUser->name }}</strong>
                            </div>
                        </div>
                        <div class="row mb-2" style="padding: 0px 60px;font-size: 14px;">
                            <div class="col-3">
                                <strong>৪। পিতা/স্বামীর নাম</strong>
                                <strong style="float: right">:</strong>
                            </div>
                            <div class="col-7 ml-4">
                                <strong>{{ $tradeUser->father_husband_name }}</strong>
                            </div>
                        </div>
                        <div class="row mb-2" style="padding: 0px 60px;font-size: 14px;">
                            <div class="col-3">
                                <strong>৫। মাতার নাম</strong>
                                <strong style="float: right">:</strong>
                            </div>
                            <div class="col-7 ml-4">
                                <strong>{{ $tradeUser->mother_name }}</strong>
                            </div>
                        </div>
                        <div class="row mb-2" style="padding: 0px 60px;font-size: 14px;">
                            <div class="col-3">
                                <strong>৬। ব্যবসা প্রতিষ্ঠানের ঠিকানা</strong>
                                <strong style="float: right">:</strong>
                            </div>
                            <div class="col-7 ml-4">
                                <strong>{{ $tradeUser->organization_address }}</strong>
                            </div>
                        </div>
                        <div class="row mb-2" style="padding: 0px 60px;font-size: 14px;">
                            <div class="col-3">
                                <strong>৭। মালিকের ঠিকানা (বর্তমান)</strong>
                                <strong style="float: right">:</strong>
                            </div>
                            <div class="col-7 ml-4">
                                <strong>{{ $tradeUser->present_address }}</strong>
                            </div>
                        </div>
                        <div class="row mb-2" style="padding: 0px 60px;font-size: 14px;">
                            <div class="col-3">
                                <strong>৮। মালিকের ঠিকানা (স্থায়ী)</strong>
                                <strong style="float: right">:</strong>
                            </div>
                            <div class="col-7 ml-4">
                                <strong>{{ $tradeUser->permanent_address }}</strong>
                            </div>
                        </div>
                        <div class="row mb-2" style="padding: 0px 60px;font-size: 14px;">
                            <div class="col-3">
                                <strong>৯। ন্যাশনাল আইডি নং</strong>
                                <strong style="float: right">:</strong>
                            </div>
                            <div class="col-7 ml-4">
                                <strong>{{ enNumberToBn($tradeUser->nid_no) }}</strong>
                            </div>
                        </div>
                        <div class="row mb-2" style="padding: 0px 60px;font-size: 14px;">
                            <div class="col-3">
                                <strong>১১। আর্থিক বিবরন</strong>
                                <strong style="float: right">:</strong>
                            </div>
                            <div class="col-7 ml-4">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <td><strong>আদায়ের বিবরন</strong></td>
                                            <td><strong>টাকা</strong></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $surcharge = round(($tradeUser->arrears*10)/100);
                                            $total = $tradeUser->licence_fee+$tradeUser->signboard_fee+$tradeUser->extra_rate+$tradeUser->arrears+$surcharge;
                                        @endphp
                                        <tr>
                                            <td><strong>ট্রেড লাইসেন্স/নবায়ন ফি</strong></td>
                                            <td><strong>{{ enNumberToBn(number_format($tradeUser->licence_fee)) }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td><strong>সাইনবোর্ড কর</strong></td>
                                            <td><strong>{{ enNumberToBn(number_format($tradeUser->signboard_fee)) }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td><strong>বিবিধ</strong></td>
                                            <td><strong>{{ enNumberToBn(number_format($tradeUser->extra_rate)) }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td><strong>বকেয়া</strong></td>
                                            <td><strong>{{ enNumberToBn(number_format($tradeUser->arrears)) }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td><strong>সারচার্জ</strong></td>
                                            <td><strong>{{ enNumberToBn(number_format($surcharge)) }}</strong></td>
                                        </tr>

                                        <tr>
                                            <td><strong>মোট</strong></td>
                                            <td><strong>{{ enNumberToBn(number_format($total)) }}</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row mb-2" style="padding: 0px 60px;font-size: 14px;">
                            <div class="col-10">
                                <strong>লাইসেন্সধারীর নিকট হইতে সকল পাওনা বাবদ মোট {{ enNumberToBn(number_format($total)) }} টাকা আদায় করা হইল।</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function (){
            {{--var projectSelected = '{{ request('project') }}'--}}
            {{--$("#contractor").change(function (){--}}
            {{--    let contractorId = $(this).val();--}}
            {{--    $('#project').html('<option value="">প্রকল্প নির্ধারণ</option>');--}}
            {{--    if(contractorId != ''){--}}
            {{--        $.ajax({--}}
            {{--            method: "GET",--}}
            {{--            url: "{{ route('get_contractor_wise_projects') }}",--}}
            {{--            data: { contractorId: contractorId }--}}
            {{--        }).done(function( data ) {--}}
            {{--            $.each(data, function( index, item ) {--}}
            {{--                if (projectSelected == item.conacc_id)--}}
            {{--                    $('#project').append('<option value="'+item.conacc_id+'" selected>'+item.project_id+'</option>');--}}
            {{--                else--}}
            {{--                    $('#project').append('<option value="'+item.conacc_id+'">'+item.project_id+'</option>');--}}
            {{--            });--}}
            {{--        });--}}
            {{--    }--}}
            {{--})--}}
            {{--// $('#contractor').trigger('change');--}}
        })
        var APP_URL = '{!! url()->full()  !!}';
        function getprint(print) {
            $('.print-heading').css('display','block');
            $('.extra_column').remove();
            $('body').html($('#' + print).html());
            window.print();
            window.location.replace(APP_URL)
        }
    </script>
@endsection
