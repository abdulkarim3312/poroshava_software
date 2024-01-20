@extends('layouts.app')

@section('title')
    ট্রেড লাইসেন্স নিবন্ধন ফরম
@endsection
@section('style')
    <style>
        .form-control{
            font-size: 12px !important;
            height: fit-content;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header with-border">
                    <a href="#" onclick="getprint('printArea')" class="btn btn-success bg-gradient-success btn-sm"><i
                            class="fa fa-print"></i></a>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ route('trade_license_add') }}" style="font-size: 12px;">
                    @csrf

                    <div class="card-body">
                        <div id="printArea">
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
                            <div class="row mb-3" style="background-color: #0e5b44; padding-top: 10px;border-top-right-radius: 5px;border-top-left-radius: 5px;">
                                <div class="col-12 text-center" style="color: #fff;">
                                    <h6><strong>ব্যবসা প্রতিষ্ঠান সংক্রান্ত তথ্য</strong></h6>
                                </div>
                            </div>
                            <div class="row">
                                <label for="organization_name" class="col-sm-2 col-form-label">প্রতিষ্ঠানের নাম <span style="color:red;">*</span></label>
                                <div class="col-sm-4 form-group  {{ $errors->has('organization_name') ? 'has-error' :'' }}">
                                    <input type="text" class="form-control" name="organization_name" id="organization_name" value="{{ old('organization_name') }}">

                                    @error('organization_name')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label">ব্যবসার ধরন <span style="color:red;">*</span></label>
                                <div class="col-sm-4 form-group {{ $errors->has('business_type_name') ? 'has-error' :'' }}">
                                    <input type="text" class="form-control" placeholder=""
                                           name="business_type_name" value="{{ old('business_type_name') }}">

                                    @error('business_type_name')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">নামের ধরন <span style="color:red;">*</span></label>
                                <div class="col-sm-4 form-group {{ $errors->has('name_type') ? 'has-error' :'' }}">
                                    <select id="name_type" name="name_type" class="form-control">
                                        <option value="">নির্বাচন করুন</option>
                                        <option value="মালিকের নাম" {{ old('name_type')=='মালিকের নাম'?'selected':'' }}>মালিকের নাম</option>
                                        <option value="ব্যবস্থাপনা পরিচালকের নাম" {{ old('name_type')=='ব্যবস্থাপনা পরিচালকের নাম'?'selected':'' }}>ব্যবস্থাপনা পরিচালকের নাম</option>
                                        <option value="চেয়ারম্যানের নাম" {{ old('name_type')=='চেয়ারম্যানের নাম'?'selected':'' }}>চেয়ারম্যানের নাম</option>
                                    </select>

                                    @error('name_type')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label">নাম <span style="color:red;">*</span></label>
                                <div class="col-sm-4 form-group {{ $errors->has('name') ? 'has-error' :'' }}">
                                    <input type="text" class="form-control" placeholder=""
                                           name="name" value="{{ old('name') }}">

                                    @error('name')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">অনুমোদিত/পরিশোধিত মূলধন (কেবলমাত্র সীমাবদ্ধ প্রতিষ্ঠানের জন্য প্রযোজ্য)</label>
                                <div class="col-sm-4 form-group {{ $errors->has('approved_paid_capital') ? 'has-error' :'' }}">
                                    <input type="text" class="form-control" placeholder=""
                                           name="approved_paid_capital" value="{{ old('approved_paid_capital') }}">

                                    @error('approved_paid_capital')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label">ব্যবসা (কম্পানী/কারখানা) চালু করিবার তারিখ <span style="color:red;">*</span></label>
                                <div class="col-sm-4 form-group {{ $errors->has('org_start_date') ? 'has-error' :'' }}">
                                    <input type="text" class="form-control date-picker" placeholder="তারিখ"
                                           name="org_start_date" value="{{ old('org_start_date') }}">

                                    @error('org_start_date')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">প্রতিষ্ঠানের ঠিকানা <span style="color:red;">*</span></label>
                                <div class="col-sm-10 form-group {{ $errors->has('organization_address') ? 'has-error' :'' }}">
                                    <textarea name="organization_address" class="form-control">{{ old('organization_address') }}</textarea>
                                    @error('organization_address')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">হোল্ডিং নং</label>
                                <div class="col-sm-4 form-group {{ $errors->has('holding_no') ? 'has-error' :'' }}">
                                    <input type="hidden" name="holding_no_name" class="holding_no_name">
                                    <select name="holding_no" class="form-control select2 holding_no">
                                        <option value="">নির্বাচন করুন</option>
                                        @if (old('holding_no') != '')
                                            <option value="{{ old('holding_no') }}" selected>{{ old('holding_no_name') }}</option>
                                        @endif
                                    </select>
                                    @error('holding_no')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label">দোকান নং</label>
                                <div class="col-sm-4 form-group {{ $errors->has('shop_no') ? 'has-error' :'' }}">
                                    <input type="text" class="form-control" placeholder=""
                                           name="shop_no" value="{{ old('shop_no') }}">

                                    @error('shop_no')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">ওয়ার্ড নং <span style="color:red;">*</span></label>
                                <div class="col-sm-4 form-group {{ $errors->has('ward_id') ? 'has-error' :'' }}">
                                    <select name="ward_id" class="form-control select2 ward">
                                        <option value="">নির্বাচন করুন</option>
                                        @foreach($wardInfos as $wardInfo)
                                            <option value="{{ $wardInfo->id }}" {{ old('ward_id')==$wardInfo->id?'selected':'' }}>{{ enNumberToBn($wardInfo->ward_no) }}</option>
                                        @endforeach
                                    </select>
                                    @error('ward_id')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label">মহল্লা/সার্কেল/রাস্তার নাম <span style="color:red;">*</span></label>
                                <div class="col-sm-4 form-group {{ $errors->has('road_id') ? 'has-error' :'' }}">
                                    <select name="road_id" class="form-control select2 road">
                                        <option value="">নির্বাচন করুন</option>
                                    </select>
                                    @error('road_id')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">জেলা <span style="color:red;">*</span></label>
                                <div class="col-sm-4 form-group {{ $errors->has('district_id') ? 'has-error' :'' }}">
                                    <select name="district_id" class="form-control select2 district">
                                        <option value="">নির্বাচন করুন</option>
                                        @foreach($districts as $district)
                                            <option value="{{ $district->id }}" {{ old('district_id')==$district->id?'selected':'' }}>{{ $district->bn_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('district_id')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label">উপজেলা <span style="color:red;">*</span></label>
                                <div class="col-sm-4 form-group {{ $errors->has('upazila_id') ? 'has-error' :'' }}">
                                    <select name="upazila_id" class="form-control select2 upazila">
                                        <option value="">নির্বাচন করুন</option>
                                    </select>
                                    @error('upazila_id')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">আয়কর দেয়া হয় কিনা <span style="color:red;">*</span></label>
                                <div class="col-sm-4 mt-2 form-group {{ $errors->has('income_tax') ? 'has-error' :'' }}">
                                    <label class="form-check form-check-inline">
                                        <input type="radio" name="income_tax" value="1" {{ old('income_tax')=='1'?'checked':'' }}>
                                        &nbsp;&nbsp;&nbsp;হ্যাঁ
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input type="radio" name="income_tax" value="0" {{ old('income_tax')=='0'?'checked':'' }}>
                                        &nbsp;&nbsp;&nbsp;না
                                    </label>
                                    @error('income_tax')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label">টিআইএন নাম্বার (যদি থাকে)</label>
                                <div class="col-sm-4 form-group {{ $errors->has('tin_no') ? 'has-error' :'' }}">
                                    <input type="text" class="form-control" placeholder=""
                                           name="tin_no" value="{{ old('tin_no') }}">

                                    @error('tin_no')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">বিআইএন/ভ্যাট রেজিসট্রেসন আছে কিনা <span style="color:red;">*</span></label>
                                <div class="col-sm-4 mt-2 form-group {{ $errors->has('bin_vat') ? 'has-error' :'' }}">
                                    <label class="form-check form-check-inline">
                                        <input type="radio" name="bin_vat" value="1" {{ old('bin_vat')=='1'?'checked':'' }}>
                                        &nbsp;&nbsp;&nbsp;হ্যাঁ
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input type="radio" name="bin_vat" value="0" {{ old('bin_vat')=='0'?'checked':'' }}>
                                        &nbsp;&nbsp;&nbsp;না
                                    </label>
                                    @error('bin_vat')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label">বিআইএন/ভ্যাট নাম্বার(যদি থাকে</label>
                                <div class="col-sm-4 form-group {{ $errors->has('bin_vat_no') ? 'has-error' :'' }}">
                                    <input type="text" class="form-control" placeholder=""
                                           name="bin_vat_no" value="{{ old('bin_vat_no') }}">

                                    @error('bin_vat_no')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                </div>
                                <label class="col-sm-2 col-form-label">কম্পানীর/কারখানার উৎপাদিত দ্রব্যের ধরন</label>
                                <div class="col-sm-4 form-group {{ $errors->has('product_types') ? 'has-error' :'' }}">
                                    <input type="text" class="form-control" placeholder=""
                                           name="product_types" value="{{ old('product_types') }}">

                                    @error('product_types')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">কর্মচারীর সংখ্যা</label>
                                <div class="col-sm-4 mt-2 form-group {{ $errors->has('total_employers') ? 'has-error' :'' }}">
                                    <input type="text" class="form-control" placeholder=""
                                           name="total_employers" value="{{ old('total_employers') }}">
                                    @error('total_employers')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label">কারখানা/কম্পানিতে ব্যবহার করিতে ইচ্ছুক মেশিনের বিস্তারিত বিবরণ</label>
                                <div class="col-sm-4 form-group {{ $errors->has('machine_details') ? 'has-error' :'' }}">
                                    <input type="text" class="form-control" placeholder=""
                                           name="machine_details" value="{{ old('machine_details') }}">

                                    @error('machine_details')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">ইহা বিদ্যুৎ/জেনারেটর দ্বারা পরিচালিত কিনা?</label>
                                <div class="col-sm-4 mt-2 form-group {{ $errors->has('biddut_generator') ? 'has-error' :'' }}">
                                    <label class="form-check form-check-inline">
                                        <input type="radio" name="biddut_generator" value="1" {{ old('biddut_generator')=='1'?'checked':'' }}>
                                        &nbsp;&nbsp;&nbsp;বিদ্যুৎ
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input type="radio" name="biddut_generator" value="2" {{ old('biddut_generator')=='2'?'checked':'' }}>
                                        &nbsp;&nbsp;&nbsp;জেনারেটর
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input type="radio" name="biddut_generator" value="3" {{ old('biddut_generator')=='3'?'checked':'' }}>
                                        &nbsp;&nbsp;&nbsp;উভয়
                                    </label>
                                    @error('biddut_generator')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label">মোটর দ্বারা পরিচালিত মোটরের বিস্তারিত বিবরণ</label>
                                <div class="col-sm-4 form-group {{ $errors->has('motor_details') ? 'has-error' :'' }}">
                                    <input type="text" class="form-control" placeholder=""
                                           name="motor_details" value="{{ old('motor_details') }}">

                                    @error('motor_details')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">সাইনবোর্ডের ধরন <span style="color:red;">*</span></label>
                                <div class="col-sm-4 form-group {{ $errors->has('signboard_type') ? 'has-error' :'' }}">
                                    <select name="signboard_type" class="form-control select2">
                                        <option value="">নির্বাচন করুন</option>
                                        @foreach($signBoards as $signBoard)
                                            <option value="{{ $signBoard->id }}" {{ old('signboard_type')==$signBoard->id?'selected':'' }}>{{ $signBoard->sign_board_type }}</option>
                                        @endforeach
                                    </select>
                                    @error('signboard_type')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label">সাইনবোর্ড সাইজ <span style="color:red;">*</span></label>
                                <div class="col-sm-4 form-group {{ $errors->has('signboard_size') ? 'has-error' :'' }}">
                                    <input type="text" class="form-control" placeholder="বর্গ ফুট"
                                           name="signboard_size" value="{{ old('signboard_size') }}">
                                    @error('signboard_size')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">প্রতিষ্ঠানের টেলিফোন নম্বর</label>
                                <div class="col-sm-4 form-group {{ $errors->has('org_telephone_no') ? 'has-error' :'' }}">
                                    <input type="text" class="form-control" placeholder=""
                                           name="org_telephone_no" value="{{ old('org_telephone_no') }}">
                                    @error('org_telephone_no')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label">প্রতিষ্ঠানের মোবাইল নম্বর</label>
                                <div class="col-sm-4 form-group {{ $errors->has('org_contact_no') ? 'has-error' :'' }}">
                                    <input type="text" class="form-control" placeholder=""
                                           name="org_contact_no" value="{{ old('org_contact_no') }}">
                                    @error('org_contact_no')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">প্রতিষ্ঠানের ই-মেইল (যদি থাকে)</label>
                                <div class="col-sm-4 form-group {{ $errors->has('org_email') ? 'has-error' :'' }}">
                                    <input type="text" class="form-control" placeholder=""
                                           name="org_email" value="{{ old('org_email') }}">
                                    @error('org_email')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label">প্রতিষ্ঠানের ওয়েব সাইটের ঠিকানা (যদি থাকে)</label>
                                <div class="col-sm-4 form-group {{ $errors->has('org_web_site') ? 'has-error' :'' }}">
                                    <input type="text" class="form-control" placeholder=""
                                           name="org_web_site" value="{{ old('org_web_site') }}">
                                    @error('org_web_site')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3" style="background-color: #0e5b44; padding-top: 10px;border-top-right-radius: 5px;border-top-left-radius: 5px;">
                                <div class="col-12 text-center" style="color: #fff;">
                                    <h6><strong>মালিকের/ব্যবস্থাপনা পরিচালকের/চেয়ারম্যানের বাক্তিগত নাগরিকত্ব সংক্রান্ত তথ্য</strong></h6>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">মালিকের/ব্যবস্থাপনা পরিচালকের/চেয়ারম্যানের নাম <span style="color:red;">*</span></label>
                                <div class="col-sm-4 form-group {{ $errors->has('owner_name') ? 'has-error' :'' }}">
                                    <input type="text" class="form-control" placeholder=""
                                           name="owner_name" value="{{ old('owner_name') }}">
                                    @error('owner_name')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label">পিতার নাম</label>
                                <div class="col-sm-4 form-group {{ $errors->has('father_husband_name') ? 'has-error' :'' }}">
                                    <input type="text" class="form-control" placeholder=""
                                           name="father_husband_name" value="{{ old('father_husband_name') }}">
                                    @error('father_husband_name')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">মাতার নাম <span style="color:red;">*</span></label>
                                <div class="col-sm-4 form-group {{ $errors->has('mother_name') ? 'has-error' :'' }}">
                                    <input type="text" class="form-control" placeholder=""
                                           name="mother_name" value="{{ old('mother_name') }}">
                                    @error('mother_name')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label">স্বামীর নাম</label>
                                <div class="col-sm-4 form-group {{ $errors->has('husband_name') ? 'has-error' :'' }}">
                                    <input type="text" class="form-control" placeholder=""
                                           name="husband_name" value="{{ old('husband_name') }}">
                                    @error('husband_name')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">জাতীয়তা <span style="color:red;">*</span></label>
                                <div class="col-sm-4 form-group {{ $errors->has('nationality') ? 'has-error' :'' }}">
                                    <input type="text" class="form-control" placeholder=""
                                           name="nationality" value="{{ old('nationality') }}">
                                    @error('nationality')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label">জন্ম তারিখ <span style="color:red;">*</span></label>
                                <div class="col-sm-4 form-group {{ $errors->has('date_of_birth') ? 'has-error' :'' }}">
                                    <input type="text" class="form-control date-picker" placeholder="জন্ম তারিখ"
                                           name="date_of_birth" value="{{ old('date_of_birth') }}" autocomplete="off">
                                    @error('date_of_birth')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">বৈবাহিক অবস্তা <span style="color:red;">*</span></label>
                                <div class="col-sm-4 form-group {{ $errors->has('marital_status') ? 'has-error' :'' }}">
                                    <select id="marital_status" name="marital_status" class="form-control">
                                        <option value="">নির্বাচন করুন</option>
                                        <option value="বিবাহিত" {{ old('marital_status')=='বিবাহিত'?'selected':'' }}>বিবাহিত</option>
                                        <option value="অবিবাহিত" {{ old('marital_status')=='অবিবাহিত'?'selected':'' }}>অবিবাহিত</option>
                                    </select>
                                    @error('marital_status')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label">জাতীয় পরিচয় পত্র নং/জন্ম সনদ পত্র নং <span style="color:red;">*</span></label>
                                <div class="col-sm-4 form-group {{ $errors->has('nid_no') ? 'has-error' :'' }}">
                                    <input type="text" class="form-control" placeholder=""
                                           name="nid_no" value="{{ old('nid_no') }}">
                                    @error('nid_no')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">টিআইএন নাম্বার(যদি থাকে)</label>
                                <div class="col-sm-4 form-group {{ $errors->has('personal_tin_no') ? 'has-error' :'' }}">
                                    <input type="text" class="form-control" placeholder=""
                                           name="personal_tin_no" value="{{ old('personal_tin_no') }}">
                                    @error('personal_tin_no')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">মালিকের বর্তমান ঠিকানা <span style="color:red;">*</span></label>
                                <div class="col-sm-4 form-group {{ $errors->has('present_address') ? 'has-error' :'' }}">
                                    <textarea name="present_address" class="form-control">{{ old('present_address') }}</textarea>
                                    @error('present_address')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label">মালিকের স্থায়ী ঠিকানা <span style="color:red;">*</span></label>
                                <div class="col-sm-4 form-group {{ $errors->has('permanent_address') ? 'has-error' :'' }}">
                                    <textarea name="permanent_address" class="form-control">{{ old('permanent_address') }}</textarea>

                                    @error('permanent_address')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">টেলিফোন/মোবাইল নম্বর <span style="color:red;">*</span></label>
                                <div class="col-sm-4 form-group {{ $errors->has('mobile_no') ? 'has-error' :'' }}">
                                    <input type="text" class="form-control" placeholder=""
                                           name="mobile_no" value="{{ old('mobile_no') }}">
                                    @error('mobile_no')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label">ই-মেইল (যদি থাকে)</label>
                                <div class="col-sm-4 form-group {{ $errors->has('eamil') ? 'has-error' :'' }}">
                                    <input type="text" class="form-control" placeholder=""
                                           name="eamil" value="{{ old('eamil') }}">
                                    @error('eamil')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3" style="background-color: #0e5b44; padding-top: 10px;border-top-right-radius: 5px;border-top-left-radius: 5px;">
                                <div class="col-12 text-center" style="color: #fff;">
                                    <h6><strong>আবেদনের সাথে সংযুক্ত দলিলাদি</strong></h6>
                                </div>
                            </div>
                            <div class="row">
                                <label for="nid_scan_copy" class="col-md-offset-1 col-md-10 col-sm-12 control-label pull-left">জাতীয় পরিচয় পত্রের স্ক্যানকপি/জন্ম নিবন্ধণ স্ক্যানকপি  <span style="color:red; font-size:10px;">(scan copy maximum 100kbytes)</span></label>
                                <div class="form-group {{ $errors->has('nid_scan_copy') ? 'has-error' :'' }} col-md-offset-1 col-md-10 col-sm-12">
                                    <input id="nid_scan_copy" type="file" name="nid_scan_copy" accept="image/*" class="form-control">
                                    @error('nid_scan_copy')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <label for="personal_tin_scan_copy" class="col-md-offset-1 col-md-10 col-sm-12 control-label pull-left">বাক্তিগত টিআইএন সনদের স্ক্যানকপি(যদি থাকে)<span style="color:red; font-size:10px;">(scan copy maximum 100kbytes)</span></label>
                                <div class="form-group {{ $errors->has('personal_tin_scan_copy') ? 'has-error' :'' }} col-md-offset-1 col-md-10 col-sm-12">
                                    <input id="personal_tin_scan_copy" type="file" name="personal_tin_scan_copy" accept="image/*" class="form-control">
                                    @error('personal_tin_scan_copy')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <label for="org_tin_scan_copy" class="col-md-offset-1 col-md-10 col-sm-12 control-label pull-left">প্রতিষ্ঠা টিআইএন সনদের স্ক্যানকপি(যদি থাকে)<span style="color:red; font-size:10px;">(scan copy maximum 100kbytes)</span></label>
                                <div class="form-group col-md-offset-1 col-md-10 col-sm-12">
                                    <input id="org_tin_scan_copy" type="file" name="org_tin_scan_copy" accept="image/*" class="form-control">
                                    @error('org_tin_scan_copy')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <label for="bin_vat_scan_copy" class="col-md-offset-1 col-md-10 col-sm-12 control-label pull-left">বিআইএন/ভ্যাট সনদের স্ক্যানকপি(যদি থাকে)<span style="color:red; font-size:10px;">(scan copy maximum 100kbytes)</span></label>
                                <div class="form-group {{ $errors->has('bin_vat_scan_copy') ? 'has-error' :'' }} col-md-offset-1 col-md-10 col-sm-12">
                                    <input id="bin_vat_scan_copy" type="file" name="bin_vat_scan_copy" accept="image/*" class="form-control">
                                    @error('bin_vat_scan_copy')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <label for="balance_sheet" class="col-md-offset-1 col-md-10 col-sm-12 control-label pull-left">প্রতিষ্ঠা/কারখানা/কম্পানীটি সীমাবদ্ধ (লিমিটেড) কিনা? (প্রতিষ্ঠান্টির লিমিটেড হইলে সঙ্গে মেমোরেন্ডাম অব আর্টিকেল ও ব্যালেন্স শীট দাখিল করতে হবে) <span style="color:red; font-size:10px;">(scan copy maximum 60kbytes)</span></label>
                                <div class="form-group {{ $errors->has('balance_sheet') ? 'has-error' :'' }} col-md-offset-1 col-md-10 col-sm-12">
                                    <input id="balance_sheet" type="file" name="balance_sheet" accept="image/*" class="form-control">
                                    @error('balance_sheet')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <label for="tax_tenant_copy" class="col-md-offset-1 col-md-10 col-sm-12 control-label pull-left">কারখানা/কোম্পানীর স্থানটি নিজের না ভাড়া (স্থানটি নিজের হইলে পৌর কর্পোরেশনের হালনাগাদ ত্যাক্সের রসিদ এবং ভাড়ার হইলে ভাড়ার রশিদ দাখিল করিতে হইবে)(যদি থাকে) <span style="color:red; font-size:10px;">(scan copy maximum 60kbytes)</span></label>
                                <div class="form-group {{ $errors->has('tax_tenant_copy') ? 'has-error' :'' }} col-md-offset-1 col-md-10 col-sm-12">
                                    <input id="tax_tenant_copy" type="file" name="tax_tenant_copy" accept="image/*" class="form-control">
                                    @error('tax_tenant_copy')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <label for="tax_paid_voucher_scan_copy" class="col-md-offset-1 col-md-10 col-sm-12 control-label pull-left">হালনাগাদ ট্যাক্স পরিশোদের রশিদ স্ক্যানকপি(যদি থাকে)<span style="color:red; font-size:10px;">(scan copy maximum 60kbytes)</span></label>
                                <div class="form-group {{ $errors->has('tax_paid_voucher_scan_copy') ? 'has-error' :'' }} col-md-offset-1 col-md-10 col-sm-12">
                                    <input id="tax_paid_voucher_scan_copy" type="file" name="tax_paid_voucher_scan_copy" accept="image/*" class="form-control">
                                    @error('tax_paid_voucher_scan_copy')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <label for="image" class="col-md-offset-1 col-md-10 col-sm-12 control-label pull-left">ছবি আপলোড করুন<sppan style="color:red; font-size:10px;">(passport size image maximum 30kbytes)</sppan></label>
                                <div class="form-group {{ $errors->has('image') ? 'has-error' :'' }} col-md-offset-1 col-md-10 col-sm-12">
                                    <input id="image" type="file" name="image" accept="image/*" class="form-control">
                                    @error('image')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <label for="org_drowing_paper" class="col-md-offset-1 col-md-10 col-sm-12 control-label">(ক) কারখানার নকশা (যদি থাকে)<span style="color:red; font-size:10px;">(scan copy maximum 60kbytes)</span></label>
                                <div class="form-group {{ $errors->has('org_drowing_paper') ? 'has-error' :'' }} col-md-offset-1 col-md-10 col-sm-12">
                                    <input id="org_drowing_paper" type="file" name="org_drowing_paper" accept="image/*" class="form-control">
                                    @error('org_drowing_paper')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <label for="location_drowing_paper" class="col-md-offset-1 col-md-10 col-sm-12 control-label pull-left">(খ)প্রস্তাবিত কারখানার আশেপাশে রাস্তার ও বসতবাড়ির অবস্থান দেখিয়ে নাকশা (যদি থাকে)<span style="color:red; font-size:10px;">(scan copy maximum 60kbytes)</span></label>
                                <div class="form-group {{ $errors->has('location_drowing_paper') ? 'has-error' :'' }} col-md-offset-1 col-md-10 col-sm-12">
                                    <input id="location_drowing_paper" type="file" name="location_drowing_paper" accept="image/*" class="form-control">
                                    @error('location_drowing_paper')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3" style="background-color: #0e5b44; padding-top: 10px;border-top-right-radius: 5px;border-top-left-radius: 5px;">
                                <div class="col-12 text-center" style="color: #fff;">
                                    <h6><strong>অঙ্গিকার নামা</strong></h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="has-feedback">
                                        <div class="col-md-offset-1 col-md-10 col-sm-12">
                                            <div class="form-group {{ $errors->has('check') ? 'has-error' :'' }} checkbox">
                                                <label><input type="checkbox" value="1" name="check" width="10px" {{ old('check')==1?'checked':'' }} required> <span style="color:red;">*</span></label>
                                                @error('check')
                                                   <span class="help-block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <p>১. আমি ঘোষনা করছি যে, আবেদনপত্রে প্রদত্ত সকল তথ্য সত্য ও নির্ভুল ।</p>
                                            <p>২. আমি আরও ঘোষনা করছি যে, আবেদনপত্রে প্রদত্ত সকল তথ্য অসত্য ও ভুল গোচরীস্তত হলে, লাইসেন্স বাতিল সহ আমার বিরুদ্ধে পৌর কর্তিপক্ষ আইন অনুযায়ী ব্যবস্থা গ্রহন করতে পারবে ।</p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success bg-gradient-success">সাবমিট করুন</button>
                    </div>
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

            $('.holding_no').select2({
                ajax: {
                    url: "{{ route('holding_no_json') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            searchTerm: params.term // search term
                        };
                    },
                    processResults: function (response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });
            $('.holding_no').on('select2:select', function (e) {
                let data = e.params.data;
                let index = $(".holding_no").index(this);
                $('.holding_no_name').val(data.text)
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
