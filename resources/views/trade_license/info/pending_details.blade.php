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
            font-size: 12px !important;
        }

        .table-bordered-modal td, .table-bordered-modal th {
            border: 1px solid #dee2e6 !important;
        }
        .table1{
            border: 1px dotted #000 !important;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-default">
                <div class="card-header">
                    <a href="#" onclick="getprint('printArea')" class="btn btn-success bg-gradient-success btn-sm"><i
                            class="fa fa-print"></i></a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div id="printArea" style="border: 1px dotted #000;">
                        <div class="row mb-2 mt-2" style="border-bottom: 1px solid #000; margin: 0 0px;">
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
                            </div>
                            <div class="col-3 text-right">
                                <span><img src="{{ asset('img/dohar_logo.jpg') }}" width="70"/></span>
                            </div>
                        </div>
                        <div class="row mb-2" style="padding: 0 10px;">
                            <div class="col-12 text-center" style="color: green;">
                                <h4><strong>ট্রেড লাইসেন্স আবেদন ফরম</strong></h4>
                            </div>
                        </div>
                        <div class="row mb-3" style="padding: 0 10px;">
                            <div class="col-12 text-center" style="border: 1px solid #000;">
                                <strong>ব্যবসা প্রতিষ্ঠান সংক্রান্ত তথ্য</strong>
                            </div>
                        </div>
                        <div class="row mb-2" style="padding: 0 10px;">
                            <table class="table table-bordered table1" style="font-size: 15px;">
                                  <tbody>
                                     <tr>
                                         <th width="5%">১.০</th>
                                         <th width="30%">ব্যবসা প্রতিষ্ঠানের নাম</th>
                                         <th width="3%">:</th>
                                         <td>{{ $tradeUser->organization_name }}</td>
                                     </tr>
                                     <tr>
                                         <th width="5%">২.০</th>
                                         <th width="30%">মালিকের নাম</th>
                                         <th width="3%">:</th>
                                         <td>{{ $tradeUser->name }}</td>
                                     </tr>
                                     <tr>
                                         <th width="5%">৩.০</th>
                                         <th width="30%">ব্যবসার ধরন</th>
                                         <th width="3%">:</th>
                                         <td>কনফেকশনারী</td>
                                     </tr>
                                     <tr>
                                         <th width="5%">৪.০</th>
                                         <th width="30%">ব্যবসার মূলধন</th>
                                         <th width="3%">:</th>
                                         <td>টাকা</td>
                                     </tr>
                                     <tr>
                                         <th width="5%">৫.০</th>
                                         <th width="30%">ব্যবসা শুরুর তারিখ</th>
                                         <th width="3%">:</th>
                                         <td>{{ enNumberToBn(date('d-m-Y', strtotime($tradeUser->org_start_date))) }}</td>
                                     </tr>
                                  </tbody>
                            </table>
                        </div>

                        <div class="row mb-2" style="padding: 0 10px;">
                            <table class="table table-bordered table1">
                                <tbody>
                                <tr>
                                    <th width="5%">৬.০</th>
                                    <th width="20%">ব্যবসা প্রতিষ্ঠানের ঠিকানা</th>
                                    <th width="3%">:</th>
                                    <td colspan="5">{{ $tradeUser->organization_address }}</td>
                                </tr>
                                <tr>
                                    <th width="5%">৬.১</th>
                                    <th width="20%">হোল্ডিং নং</th>
                                    <th width="3%">:</th>
                                    <td width="22%">{{ enNumberToBn($tradeUser->holding_no) }}</td>
                                    <th width="5%">৬.২</th>
                                    <th width="20%">দোকান নং</th>
                                    <th width="3%">:</th>
                                    <td width="22%">{{ enNumberToBn($tradeUser->shop_no) }}</td>
                                </tr>
                                <tr>
                                    <th width="5%">৬.৩</th>
                                    <th width="20%">মহল্লা/সার্কেল/রাস্তার নাম</th>
                                    <th width="3%">:</th>
                                    <td width="22%">{{ $tradeUser->areaInfo->road_name??'' }}</td>
                                    <th width="5%">৬.৪</th>
                                    <th width="20%">ওয়ার্ড নং</th>
                                    <th width="3%">:</th>
                                    <td width="22%">{{ enNumberToBn($tradeUser->wardInfo->ward_no??'') }} নং ওয়ার্ড</td>
                                </tr>
                                <tr>
                                    <th width="5%">৬.৫</th>
                                    <th width="20%">উপজেলা</th>
                                    <th width="3%">:</th>
                                    <td width="22%">{{ $tradeUser->upazila->bn_name??'' }}</td>
                                    <th width="5%">৬.৬</th>
                                    <th width="20%">জেলা</th>
                                    <th width="3%">:</th>
                                    <td width="22%">{{ $tradeUser->district->bn_name??'' }}</td>
                                </tr>
                                <tr>
                                    <th width="5%">৭.১</th>
                                    <th width="20%">আয় কর দেয়া হয় কিনা</th>
                                    <th width="3%">:</th>
                                    <td width="22%">
                                        @if($tradeUser->income_tax==1)
                                            হ্যাঁ
                                        @else
                                            না
                                        @endif
                                    </td>
                                    <th width="5%">৭.২</th>
                                    <th width="20%">টিআইএন নাম্বার(যদি থাকে)</th>
                                    <th width="3%">:</th>
                                    <td width="22%">
                                        @if($tradeUser->tin_no)
                                            আছে
                                        @else
                                            নাই
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th width="5%">৮.১</th>
                                    <th width="20%">বিআইএন/ভ্যাট রেজিসট্রেসন আছে কিনা</th>
                                    <th width="3%">:</th>
                                    <td width="22%">
                                        @if($tradeUser->bin_vat==1)
                                            হ্যাঁ
                                        @else
                                            না
                                        @endif
                                    </td>
                                    <th width="5%">৮.২</th>
                                    <th width="20%">বিআইএন/ভ্যাট নাম্বার(যদি থাকে)</th>
                                    <th width="3%">:</th>
                                    <td width="22%">
                                        @if($tradeUser->bin_vat_no)
                                            আছে
                                        @else
                                            নাই
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th width="5%">৯.১</th>
                                    <th width="20%">সাইন বোর্ডের ধরন</th>
                                    <th width="3%">:</th>
                                    <td width="22%">{{ $tradeUser->signBoard->sign_board_type??'' }}</td>
                                    <th width="5%">৯.২</th>
                                    <th width="20%">সাইন বোর্ডের সাইজ</th>
                                    <th width="3%">:</th>
                                    <td width="22%">{{ enNumberToBn($tradeUser->signboard_size) }}</td>
                                </tr>
                                <tr>
                                    <th width="5%">১০.১</th>
                                    <th width="20%">টেলিফোন নাম্বার</th>
                                    <th width="3%">:</th>
                                    <td width="22%">{{ enNumberToBn($tradeUser->org_telephone_no) }}</td>
                                    <th width="5%">১০.২</th>
                                    <th width="20%">মোবাইল নাম্বার</th>
                                    <th width="3%">:</th>
                                    <td width="22%">{{ enNumberToBn($tradeUser->org_contact_no) }}</td>
                                </tr>
                                <tr>
                                    <th width="5%">১১.১</th>
                                    <th width="20%">ইমেইল</th>
                                    <th width="3%">:</th>
                                    <td width="22%">{{ $tradeUser->org_email }}</td>
                                    <th width="5%">১১.২</th>
                                    <th width="20%">ওয়েব সাইটের ঠিকানা</th>
                                    <th width="3%">:</th>
                                    <td width="22%">{{ $tradeUser->org_web_site }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="row mb-2 mb-3" style="padding: 0 10px;">
                            <div class="col-12 text-center" style="border: 1px solid #000;">
                                <strong>মালিকের/ব্যবস্থাপনা পরিচালকের/চেয়ারম্যানের বাক্তিগত নাগরিকত্ব সংক্রান্ত তথ্য</strong>
                            </div>
                        </div>

                        <div class="row mb-2" style="padding: 0 10px;">
                            <table class="table table-bordered table1">
                                <tbody>
                                <tr>
                                    <th width="5%">১২.০</th>
                                    <th width="20%">মালিকের নাম</th>
                                    <th width="3%">:</th>
                                    <td colspan="5">{{ $tradeUser->name }}</td>
                                </tr>
                                <tr>
                                    <th width="5%">১৩.১</th>
                                    <th width="20%">জাতীয়তা</th>
                                    <th width="3%">:</th>
                                    <td width="22%">{{ $tradeUser->nationality }}</td>
                                    <th width="5%">১৩.২</th>
                                    <th width="20%">জন্ম তারিখ</th>
                                    <th width="3%">:</th>
                                    <td width="22%">{{ enNumberToBn(date('d-m-Y', strtotime($tradeUser->date_of_birth))) }}</td>
                                </tr>
                                <tr>
                                    <th width="5%">১৪.১</th>
                                    <th width="20%">বৈবাহিক অবস্তা</th>
                                    <th width="3%">:</th>
                                    <td width="22%">{{ $tradeUser->marital_status }}</td>
                                    <th width="5%">১৪.২</th>
                                    <th width="20%">জাতীয় পরিচয় পত্র নং/জন্ম সনদ পত্র নং</th>
                                    <th width="3%">:</th>
                                    <td width="22%">{{ enNumberToBn($tradeUser->nid_no) }}</td>
                                </tr>
                                <tr>
                                    <th width="5%">১৬.০</th>
                                    <th width="20%">টিআইএন নাম্বার(যদি থাকে)</th>
                                    <th width="3%">:</th>
                                    <td colspan="5">
                                        @if($tradeUser->personal_tin_no)
                                            আছে
                                        @else
                                            নাই
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th width="5%">১৭.১</th>
                                    <th width="20%">পিতার নাম</th>
                                    <th width="3%">:</th>
                                    <td colspan="5">{{ $tradeUser->father_husband_name }}</td>
                                </tr>
                                <tr>
                                    <th width="5%">১৭.২</th>
                                    <th width="20%">মাতার নাম</th>
                                    <th width="3%">:</th>
                                    <td width="22%">{{ $tradeUser->mother_name }}</td>
                                    <th width="5%">১৭.৩</th>
                                    <th width="20%">স্বামী/স্ত্রী-র নাম</th>
                                    <th width="3%">:</th>
                                    <td width="22%">{{ $tradeUser->husband_name }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="row mb-2" style="padding: 0 10px;">
                            <table class="table table-bordered table1">
                                <tbody>
                                <tr>
                                    <th width="5%">১৮.১</th>
                                    <th width="20%">মালিকের বর্তমান ঠিকানা</th>
                                    <th width="3%">:</th>
                                    <td colspan="5">{{ $tradeUser->present_address }}</td>
                                </tr>
                                <tr>
                                    <th width="5%">১৮.২</th>
                                    <th width="20%">মালিকের স্থায়ী ঠিকানা</th>
                                    <th width="3%">:</th>
                                    <td colspan="5">{{ $tradeUser->permanent_address }}</td>
                                </tr>
                                <tr>
                                    <th width="5%">১৮.৩</th>
                                    <th width="20%">মোবাইল নাম্বার</th>
                                    <th width="3%">:</th>
                                    <td width="22%">{{ enNumberToBn($tradeUser->mobile_no) }}</td>
                                    <th width="5%">১৮.৪</th>
                                    <th width="20%">ইমেইল</th>
                                    <th width="3%">:</th>
                                    <td width="22%">{{ $tradeUser->email }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="row mb-2 mb-4" style="padding: 0 10px;">
                            <div class="col-12 text-center" style="border: 1px solid #000;">
                                <strong>মালিকের/ব্যবস্থাপনা পরিচালকের/চেয়ারম্যানের বাক্তিগত নাগরিকত্ব সংক্রান্ত তথ্য</strong>
                            </div>
                        </div>

                        <div class="row mb-2 mb-4" style="padding: 0 10px;">
                            <div class="col-12 text-center" style="border: 1px solid #000;">
                                <strong>অঙ্গিকার নামা</strong>
                            </div>
                        </div>

                        <div class="row mb-2" style="padding: 0 10px;">
                            <table class="table table-bordered table1">
                                <tbody>
                                <tr>
                                    <th width="5%">১</th>
                                    <th>আমি ঘোষনা করছি যে, আবেদনপত্রে প্রদত্ত সকল তথ্য সত্য ও নির্ভুল ।</th>
                                </tr>
                                <tr>
                                    <th width="5%">২</th>
                                    <th>	আমি আরও ঘোষনা করছি যে, আবেদনপত্রে প্রদত্ত সকল তথ্য অসত্য ও ভুল গোচরীস্তত হলে, লাইসেন্স বাতিল সহ আমার বিরুদ্ধে পৌর কর্তিপক্ষ আইন অনুযায়ী ব্যবস্থা গ্রহন করতে পারবে ।</th>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row mb-5" style="padding: 0 10px;">
                            <table class="table table-bordered table1">
                                <tbody>
                                <tr>
                                    <th scope="row" width="50%" height="100px" style="vertical-align: bottom !important;">তারিখঃ {{ enNumberToBn(date('d-m-Y', strtotime($tradeUser->created_at))) }}</th>
                                    <th width="50%" height="100px" class="text-center" style="vertical-align: bottom !important;">
                                        মোঃ মনির হোসেন<br>
                                        মালিকের/ব্যবস্থাপনা পরিচালকের/চেয়ারম্যানের নাম ও স্বাক্ষর
                                    </th>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row mb-2 extra_column">
                            <div class="col-md-12 text-center">
                                <div class="d-block w-100">
                                    <button class="btn btn-sm btn-danger" style="font-size: 15px; font-weight: 900;" data-toggle="modal" data-target="#tradeLicenseModalApprove">রিপোর্ট</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Two Structure Add-->
    <div class="modal fade" id="tradeLicenseModalApprove" tabindex="-1" aria-labelledby="tradeLicenseModalApproveLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #0e5b44;color: #fff;">
                    <h5 class="modal-title" id="tradeLicenseModalApproveLabel">লাইসেন্স পরিদর্শকের পরিদর্শন প্রতিবেদন</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form style="font-size: 12px;" enctype="multipart/form-data" id="tradeLicenseApproveForm">
                    <input type="hidden" name="trade_user_id" value="{{ $tradeUser->id }}">
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">প্রতিষ্ঠানের নাম<span style="color: red;">*</span></label>
                                <div class="col-sm-4  radio radio-inline mt-2">
                                    <label class="form-check form-check-inline">
                                        <input type="radio" name="org_name" value="1" id="org_correct" required>
                                        &nbsp;ঠিক আছে
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input type="radio" name="org_name" value="2" id="org_incorrect" required>
                                        &nbsp;ঠিক নাই
                                    </label>
                                </div>
                                <label for="correct_org_name" class="col-sm-2 col-form-label">সঠিক নাম</label>
                                <div class="col-sm-4">
                                    <input type="text" name="correct_org_name" id="correct_org_name" class="form-control" placeholder="" disabled="disabled">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">মালিকের/ব্যবস্থাপনা পরিচালকের/চেয়ারম্যানের নাম<span style="color: red;">*</span></label>
                                <div class="col-sm-4  radio radio-inline mt-2">
                                    <label class="form-check form-check-inline">
                                        <input type="radio" name="owner_name" value="1" id="owner_correct" required>
                                        &nbsp;ঠিক আছে
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input type="radio" name="owner_name" value="2" id="owner_incorrect" required>
                                        &nbsp;ঠিক নাই
                                    </label>
                                </div>
                                <label for="correct_org_name" class="col-sm-2 col-form-label">সঠিক নাম</label>
                                <div class="col-sm-4">
                                    <input type="text" name="correct_owner_name" id="correct_owner_name" class="form-control" placeholder="" disabled="disabled">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">ব্যবসার ধরন<span style="color: red;">*</span></label>
                                <div class="col-sm-4  radio radio-inline mt-2">
                                    <label class="form-check form-check-inline">
                                        <input type="radio" name="business_type" value="1" id="business_correct" required>
                                        &nbsp;ঠিক আছে
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input type="radio" name="business_type" value="2" id="business_incorrect" required>
                                        &nbsp;ঠিক নাই
                                    </label>
                                </div>
                                <label for="correct_business_type" class="col-sm-2 col-form-label">সঠিক ব্যবসার ধরন</label>
                                <div class="col-sm-4">
                                    <input type="text" name="correct_business_type" id="correct_business_type" class="form-control" placeholder="" disabled="disabled">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">ব্যবসা শুরুর তারিখ<span style="color: red;">*</span></label>
                                <div class="col-sm-4  radio radio-inline mt-2">
                                    <label class="form-check form-check-inline">
                                        <input type="radio" name="business_start_date" value="1" id="business_start_date_correct" required>
                                        &nbsp;ঠিক আছে
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input type="radio" name="business_start_date" value="2" id="business_start_date_incorrect" required>
                                        &nbsp;ঠিক নাই
                                    </label>
                                </div>
                                <label for="correct_org_name" class="col-sm-2 col-form-label">সঠিক তারিখ</label>
                                <div class="col-sm-4">
                                    <input type="text" name="correct_business_start_date" id="correct_business_start_date" class="form-control date-picker" placeholder="সঠিক তারিখ" disabled="disabled">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">ব্যবসার মূলধন<span style="color: red;">*</span></label>
                                <div class="col-sm-4  radio radio-inline mt-2">
                                    <label class="form-check form-check-inline">
                                        <input type="radio" name="business_capital" value="1" id="business_capital_correct" required>
                                        &nbsp;ঠিক আছে
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input type="radio" name="business_capital" value="2" id="business_capital_incorrect" required>
                                        &nbsp;ঠিক নাই
                                    </label>
                                </div>
                                <label for="correct_business_capital" class="col-sm-2 col-form-label">সঠিক মূলধন</label>
                                <div class="col-sm-4">
                                    <input type="text" name="correct_business_capital" id="correct_business_capital" class="form-control" placeholder="" disabled="disabled">
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">ব্যবসা প্রতিষ্ঠানের ঠিকানা<span style="color: red;">*</span></label>
                                <div class="col-sm-4  radio radio-inline mt-2">
                                    <label class="form-check form-check-inline">
                                        <input type="radio" name="org_address" value="1" id="org_address_correct" required>
                                        &nbsp;ঠিক আছে
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input type="radio" name="org_address" value="2" id="org_address_incorrect" required>
                                        &nbsp;ঠিক নাই
                                    </label>
                                </div>
                                <label for="correct_org_name" class="col-sm-2 col-form-label">সঠিক ঠিকানা</label>
                                <div class="col-sm-4">
                                    <textarea name="correct_org_address" id="correct_org_address" class="form-control" disabled="disabled"></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="correct_holding_no" class="col-sm-2 col-form-label">হোল্ডিং নং</label>
                                <div class="col-sm-4">
                                    <input type="text" name="correct_holding_no" id="correct_holding_no" class="form-control" placeholder="" disabled="disabled">
                                </div>
                                <label for="correct_shop_no" class="col-sm-2 col-form-label">দোকান নং</label>
                                <div class="col-sm-4">
                                    <input type="text" name="correct_shop_no" id="correct_shop_no" class="form-control" placeholder="" disabled="disabled">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="correct_ward_id" class="col-sm-2 col-form-label">ওয়ার্ড নং</label>
                                <div class="col-sm-4">
                                    <select class="form-control ward" name="correct_ward_id" id="correct_ward_id" disabled="disabled">
                                        <option value="">নির্বাচন করুন</option>
                                        @foreach($wardInfos as $wardInfo)
                                            <option value="{{ $wardInfo->id }}">{{ enNumberToBn($wardInfo->ward_no) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="correct_road_id" class="col-sm-2 col-form-label">মহল্লা/সার্কেল/রাস্তার নাম</label>
                                <div class="col-sm-4">
                                    <select class="form-control road" name="correct_road_id" id="correct_road_id" disabled="disabled">
                                        <option value="">নির্বাচন করুন</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="correct_district_id" class="col-sm-2 col-form-label">জেলা</label>
                                <div class="col-sm-4">
                                    <select class="form-control district" name="correct_district_id" id="correct_district_id" disabled="disabled">
                                        <option value="">নির্বাচন করুন</option>
                                        @foreach($districts as $district)
                                            <option value="{{ $district->id }}">{{ $district->bn_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="correct_upazila_id" class="col-sm-2 col-form-label">উপজেলা</label>
                                <div class="col-sm-4">
                                    <select class="form-control upazila" name="correct_upazila_id" id="correct_upazila_id" disabled="disabled">
                                        <option value="">নির্বাচন করুন</option>
                                    </select>
                                </div>
                            </div>
                            <hr>

                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">সাইনবোর্ডের ধরন<span style="color: red;">*</span></label>
                                <div class="col-sm-4  radio radio-inline mt-2">
                                    <label class="form-check form-check-inline">
                                        <input type="radio" name="sign_board_type" value="1" id="sign_board_type_correct" required>
                                        &nbsp;ঠিক আছে
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input type="radio" name="sign_board_type" value="2" id="sign_board_type_incorrect" required>
                                        &nbsp;ঠিক নাই
                                    </label>
                                </div>
                                <label for="correct_business_capital" class="col-sm-2 col-form-label">সঠিক সাইনবোর্ডের ধরন</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="correct_sign_board_type" id="correct_sign_board_type" disabled="disabled">
                                        <option value="">নির্বাচন করুন</option>
                                        @foreach($signBoards as $signBoard)
                                            <option value="{{ $signBoard->id }}">{{ $signBoard->sign_board_type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">সাইন বোর্ডের সাইজ<span style="color: red;">*</span></label>
                                <div class="col-sm-4  radio radio-inline mt-2">
                                    <label class="form-check form-check-inline">
                                        <input type="radio" name="sign_board_size" value="1" id="sign_board_size_correct" required>
                                        &nbsp;ঠিক আছে
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input type="radio" name="sign_board_size" value="2" id="sign_board_size_incorrect" required>
                                        &nbsp;ঠিক নাই
                                    </label>
                                </div>
                                <label for="correct_business_capital" class="col-sm-2 col-form-label">সঠিক সাইন বোর্ডের সাইজ</label>
                                <div class="col-sm-4">
                                    <input type="text" name="correct_sign_board_size" id="correct_sign_board_size" class="form-control" placeholder="" disabled="disabled">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-sm-6 col-form-label">আবেদনকারীর অনুকূলে ট্রেড লাইসেন্স প্রদান করা যায়/যায় না<span style="color: red;">*</span></label>
                                <div class="col-sm-6  radio radio-inline mt-2">
                                    <label class="form-check form-check-inline">
                                        <input type="radio" name="approved_application" value="1" required>
                                        &nbsp;যায়
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input type="radio" name="approved_application" value="0" required>
                                        &nbsp;যায় না
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">বন্ধ</button>
                        <button type="submit" style="float: left;" class="btn btn-primary" id="taxPayerModalTwoSubmit">সংরক্ষণ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function (){

            let oldRoadID ="{{ old('road_id') ? old('road_id') : 0 }}";
            $('.ward').change(function () {
                let wardID = $(this).val();

                $('.road').html('<option value="">নির্বাচন করুন</option>');
                if (wardID != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('trade_license_get_moholla') }}",
                        data: { wardID: wardID }
                    }).done(function(response) {
                        // console.log(response);
                        $.each(response, function( index, item ) {
                            if(item.id==oldRoadID){
                                $('.road').append('<option value="'+item.id+'" selected>'+item.road_name+'</option>');
                            }else{
                                $('.road').append('<option value="'+item.id+'">'+item.road_name+'</option>');
                            }
                        });
                    });
                }
            });
            $('.ward').trigger('change');

            let oldUpazilaID ="{{ old('upazila_id') ? old('upazila_id') : 0 }}";
            $('.district').change(function () {
                let districtID = $(this).val();

                $('.upazila').html('<option value="">নির্বাচন করুন</option>');
                if (districtID != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('trade_license_get_upazila') }}",
                        data: { districtID: districtID }
                    }).done(function(response) {
                        // console.log(response);
                        $.each(response, function( index, item ) {
                            if(item.id==oldUpazilaID){
                                $('.upazila').append('<option value="'+item.id+'" selected>'+item.bn_name+'</option>');
                            }else{
                                $('.upazila').append('<option value="'+item.id+'">'+item.bn_name+'</option>');
                            }
                        });
                    });
                }
            });
            $('.district').trigger("change");

            $('#org_correct').click(function () {
                $('#correct_org_name').attr('disabled','disabled');
            });
            $('#org_incorrect').click(function () {
                $('#correct_org_name').removeAttr('disabled');
            });

            $('#owner_correct').click(function () {
                $('#correct_owner_name').attr('disabled','disabled');
            });
            $('#owner_incorrect').click(function () {
                $('#correct_owner_name').removeAttr('disabled');
            });

            $('#business_correct').click(function () {
                $('#correct_business_type').attr('disabled','disabled');
            });
            $('#business_incorrect').click(function () {
                $('#correct_business_type').removeAttr('disabled');
            });

            $('#business_start_date_correct').click(function () {
                $('#correct_business_start_date').attr('disabled','disabled');
            });
            $('#business_start_date_incorrect').click(function () {
                $('#correct_business_start_date').removeAttr('disabled');
            });

            $('#business_capital_correct').click(function () {
                $('#correct_business_capital').attr('disabled','disabled');
            });
            $('#business_capital_incorrect').click(function () {
                $('#correct_business_capital').removeAttr('disabled');
            });

            $('#org_address_correct').click(function () {
                $('#correct_org_address').attr('disabled','disabled');
                $('#correct_holding_no').attr('disabled','disabled');
                $('#correct_shop_no').attr('disabled','disabled');
                $('#correct_ward_id').attr('disabled','disabled');
                $('#correct_road_id').attr('disabled','disabled');
                $('#correct_district_id').attr('disabled','disabled');
                $('#correct_upazila_id').attr('disabled','disabled');
            });
            $('#org_address_incorrect').click(function () {
                $('#correct_org_address').removeAttr('disabled');
                $('#correct_holding_no').removeAttr('disabled');
                $('#correct_shop_no').removeAttr('disabled');
                $('#correct_ward_id').removeAttr('disabled');
                $('#correct_road_id').removeAttr('disabled');
                $('#correct_district_id').removeAttr('disabled');
                $('#correct_upazila_id').removeAttr('disabled');
            });

            $('#sign_board_type_correct').click(function () {
                $('#correct_sign_board_type').attr('disabled','disabled');
            });
            $('#sign_board_type_incorrect').click(function () {
                $('#correct_sign_board_type').removeAttr('disabled');
            });

            $('#sign_board_size_correct').click(function () {
                $('#correct_sign_board_size').attr('disabled','disabled');
            });
            $('#sign_board_size_incorrect').click(function () {
                $('#correct_sign_board_size').removeAttr('disabled');
            });
            //Trade License Approve Form
            $('body').on('submit', 'form#tradeLicenseApproveForm', function (e) {
                e.preventDefault();
                let formData = new FormData($('#tradeLicenseApproveForm')[0]);
                Swal.fire({
                    title: 'আপনি কি সংরক্ষণ/আপডেট করতে চান?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#343a40',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'হ্যাঁ, আপডেট করুন!',
                    cancelButtonText:'না'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: "POST",
                            url: "{{ route('trade_license_pending_update') }}",
                            data: formData,
                            processData: false,
                            contentType: false,
                        }).done(function(response) {
                            if(response.success){
                                $('#taxPayerModalOne').modal('hide');
                                Swal.fire(
                                    'আপডেটেড',
                                    response.message,
                                    'আপডেট হয়েছে।'
                                ).then((result)=>{
                                    // location.reload();
                                    window.location.href= response.redirectUrl;
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'উফ...',
                                    text: response.message
                                })
                            }
                        });
                    }
                })
            });
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
