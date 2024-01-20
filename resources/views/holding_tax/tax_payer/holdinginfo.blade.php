@extends('layouts.app')

@section('title')
    হোল্ডিং এর তথ্য ফরম
@endsection

@section('style')
    <style>
        * {
            margin: 0;
            padding: 0;
        }
        i {
            margin-right: 10px;
        }
        .justify-content-center{
            justify-content: center;
        }
        .align-items-center{
            align-items: center;
        }

        /*---------signup-step-------------*/
        .bg-color{
            background-color: #333;
        }
        .signup-step-container{
            padding: 10px 0px;
            padding-bottom: 30px;
        }

        .wizard .nav-tabs {
            position: relative;
            margin-bottom: 0;
            border-bottom-color: transparent;
        }

        .wizard > div.wizard-inner {
            position: relative;
            margin-bottom: 10px;
            text-align: center;
        }

        .connecting-line {
            height: 2px;
            background: #e0e0e0;
            position: absolute;
            width: 100%;
            margin: 0 auto;
            left: 0;
            right: 0;
            top: 15px;
            z-index: 1;
        }

        .wizard .nav-tabs > li.active > a, .wizard .nav-tabs > li.active > a:hover, .wizard .nav-tabs > li.active > a:focus {
            color: #555555;
            cursor: default;
            border: 0;
            border-bottom-color: transparent;
        }

        span.round-tab {
            width: 30px;
            height: 30px;
            line-height: 30px;
            display: inline-block;
            border-radius: 50%;
            background: #fff;
            z-index: 2;
            position: absolute;
            left: 0;
            text-align: center;
            font-size: 16px;
            color: #0e214b;
            font-weight: 500;
            border: 1px solid #ddd;
        }
        span.round-tab i{
            color:#555555;
        }
        .wizard li.active span.round-tab {
            background: #0db02b;
            color: #fff;
            border-color: #0db02b;
        }
        .wizard li.active span.round-tab i{
            color: #5bc0de;
        }
        .wizard .nav-tabs > li.active > a i{
            color: #0db02b;
        }

        .wizard .nav-tabs > li {
            width: 33.33%;
        }
        .wizard li:after {
            content: " ";
            position: absolute;
            left: 46%;
            opacity: 0;
            margin: 0 auto;
            bottom: 0px;
            border: 5px solid transparent;
            border-bottom-color: red;
            transition: 0.1s ease-in-out;
        }
        .wizard .nav-tabs > li a {
            width: 30px;
            height: 30px;
            margin: 20px auto;
            border-radius: 100%;
            padding: 0;
            background-color: transparent;
            position: relative;
            top: 0;
        }
        .wizard .nav-tabs > li a i{
            position: absolute;
            top: -15px;
            font-style: normal;
            white-space: nowrap;
            left: 15px;
            transform: translate(-50%, -50%);
            font-size: 15px;
            font-weight: 700;
            color: #000;
        }

        .wizard .nav-tabs > li a:hover {
            background: transparent;
        }

        .wizard .tab-pane {
            position: relative;
            padding-top: 20px;
        }
        .form-control{
            font-size: 12px !important;
            height: fit-content;
        }
        .wizard h3 {
            margin-top: 0;
        }
        .card-footer {
             padding: 0;
             background-color: white;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <section class="signup-step-container">
                        <div class="container">
                            <div class="row d-flex justify-content-center">
                                <div class="col-md-12 mt-3">
                                    <div class="wizard">
                                        <div class="wizard-inner">
                                            <div class="connecting-line"></div>
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li role="presentation" class="active">
                                                    <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" aria-expanded="true"><span class="round-tab">1 </span> <i>হোল্ডিং এর তথ্য</i></a>
                                                </li>
                                                <li role="presentation" class="disabled">
                                                    <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" aria-expanded="false"><span class="round-tab">2</span> <i>নির্মাণ তথ্য</i></a>
                                                </li>
                                                <li role="presentation" class="disabled">
                                                    <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab"><span class="round-tab">3</span> <i>ভাড়াটিয়ার তথ্য</i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                <div class="card-header with-border mb-4" style="background-color: #006552; color: white;">
                    <h3 class="card-title">হোল্ডিং এর তথ্য</h3>
                </div>
                <!-- /.card-header -->

                <!-- form start -->
                <form class="form-horizontal" style="font-size: 12px;" method="POST" action="{{ route('holding_tax_payer_holdinginfo',['holdingTaxPayer'=>$holdingTaxPayer->id]) }}" enctype="multipart/form-data">
                    @csrf
                        <div class="container-fluid">
                            <div class="form-group row">
                                <label for="holding_no" class="col-sm-2 col-form-label">হোল্ডিং নং</label>
                                <div class="col-sm-4">
                                    <div class="form-group row {{ $errors->has('client_no') ? 'has-error' :'' }}">
                                    <input type="hidden" name="client_no" id="holdingTaxPayerId" value="" >
                                    <input type="text" name="holding_no" id="holding_no" value="{{old('holding_no')}}" class="form-control" placeholder="হোল্ডিং নং" >
                                    @error('client_no')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                    </div>
                                </div>
                                <label for="old_holding_no" class="col-sm-2 col-form-label">পুরাতন হোল্ডিং নং(যদি থাকে)</label>
                                <div class="col-sm-4">
                                    <div class="form-group row {{ $errors->has('old_holding_no') ? 'has-error' :'' }}">
                                    <input type="text" name="old_holding_no" id="old_holding_no"  class="form-control" value="{{old('old_holding_no')}}" placeholder="পুরাতন হোল্ডিং নং" >

                                    @error('old_holding_no')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label for="moholla_name" class="col-sm-2 col-form-label">রাস্তার নাম</label>
                                <div class="col-sm-4">
                                    <div class="form-group row {{ $errors->has('moholla_name') ? 'has-error' :'' }}">
                                    <input type="text" name="moholla_name" id="moholla_name" class="form-control" value="{{old('moholla_name')}}" placeholder="মালিকানার ধরন" >
                                    @error('moholla_name')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                    </div>
                                </div>
                                <label for="category_id" class="col-sm-2 col-form-label">মালিকানার ধরন</label>
                                <div class="col-sm-4">
                                    <div class="form-group row {{ $errors->has('category_id') ? 'has-error' :'' }}">
                                    <select type="text" name="category_id" id="category_id" class="form-control select2" >
                                        <option value="">নির্বাচন করুন</option>
                                        @foreach($holdingCategories as $holdingCategory)
                                            <option {{ old('category_id') == $holdingCategory->id ? 'selected' : ''  }} value="{{ $holdingCategory->id }}">{{ $holdingCategory->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="ward_id" class="col-sm-2 col-form-label">ওয়ার্ড নং</label>
                                <div class="col-sm-4">
                                    <div class="form-group row {{ $errors->has('ward_id') ? 'has-error' :'' }}">
                                    <select type="text" name="ward_id" id="ward_id" class="form-control select2" >
                                        <option value="">নির্বাচন করুন</option>
                                        @foreach($wardInfos as $wardInfo)
                                            <option {{ old('ward_id') == $wardInfo->id ? 'selected' : ''  }} value="{{ $wardInfo->id }}">{{ $wardInfo->ward_no }}</option>
                                        @endforeach
                                    </select>
                                    @error('ward_id')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                    </div>
                                </div>
                                <label for="road_id" class="col-sm-2 col-form-label">মহল্লা নাম</label>
                                <div class="col-sm-4">
                                    <div class="form-group row {{ $errors->has('road_id') ? 'has-error' :'' }}">
                                    <select type="text" name="road_id" id="road_id" class="form-control select2" >
                                        <option value="">নির্বাচন করুন</option>
                                        @foreach($holdingAreas as $holdingArea)
                                            <option {{ old('road_id') == $holdingArea->id ? 'selected' : ''  }} value="{{ $holdingArea->id }}">{{ $holdingArea->road_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('road_id')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="loan_deduct" class="col-sm-2 col-form-label">বাৎসরিক ঋনের পরিমাণ</label>
                                <div class="col-sm-4">
                                    <div class="form-group row {{ $errors->has('loan_deduct') ? 'has-error' :'' }}">
                                    <input type="text" name="loan_deduct" id="loan_deduct" class="form-control" value="{{old('loan_deduct',$holdingInfo->loan_deduct ?? '0')}}" placeholder="">
                                    @error('loan_deduct')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                    </div>
                                </div>
                                <label for="holding_facility_id" class="col-sm-2 col-form-label">হোল্ডিং সুবিধা</label>
                                <div class="col-sm-4">
                                    <div class="form-group row {{ $errors->has('holding_facility_id') ? 'has-error' :'' }}">
                                    <select type="text" name="holding_facility_id" id="holding_facility_id" class="form-control select2" >
                                        <option value="">নির্বাচন করুন</option>
                                        @foreach($holdingFacilities as $holdingFacilitie)
                                            <option {{ old('holding_facility_id') == $holdingFacilitie->id ? 'selected' : ''  }} value="{{ $holdingFacilitie->id }}">{{ $holdingFacilitie->facility_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('holding_facility_id')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="structure_type_id" class="col-sm-2 col-form-label">হোল্ডিং এর ধরন</label>
                                <div class="col-sm-4">
                                    <div class="form-group row {{ $errors->has('structure_type_id') ? 'has-error' :'' }}">
                                    <select type="text" name="structure_type_id" id="structure_type_id" class="form-control select2" >
                                        <option value="">নির্বাচন করুন</option>
                                        @foreach($structureTypes as $structureType)
                                            <option {{ old('structure_type_id') == $structureType->id ? 'selected' : ''  }} value="{{ $structureType->id }}">{{ $structureType->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('structure_type_id')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                    </div>
                                </div>

                                <label for="use_type_id" class="col-sm-2 col-form-label">হোল্ডিং ব্যবহারের ধরন</label>
                                <div class="col-sm-4">
                                    <div class="form-group row {{ $errors->has('use_type_id') ? 'has-error' :'' }}">
                                    <select type="text" name="use_type_id" id="use_type_id" class="form-control select2" >
                                        <option value="">নির্বাচন করুন</option>
                                        @foreach($holdingUseTypes as $holdingUseType)
                                            <option {{ old('use_type_id') == $holdingUseType->id ? 'selected' : ''  }} value="{{ $holdingUseType->id }}">{{ $holdingUseType->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('use_type_id')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label for="" class="col-sm-2 form-check">ইমারত ব্যবহারের ধরন</label>
                                <div class="col-sm-10" style="margin-left: -35px !important">
                                    <div class="form-group row {{ $errors->has('usingHolding_id') ? 'has-error' :'' }}">
                                        <div class="icheck-success d-inline">
                                        <label class="form-check form-check-inline">
                                        <input type="radio" name="usingHolding_id" value="1" {{  old('usingHolding_id') == '1' ? 'checked' : ''}} >
                                        &nbsp;সম্পূর্ণ ভাড়া দেয়া গৃহ
                                    </label>
                                        </div>
                                        <div class="icheck-success d-inline" style="margin-left: -30px !important">
                                    <label class="form-check form-check-inline">
                                        <input type="radio" name="usingHolding_id" value="2" {{ old('usingHolding_id') == '2' ? 'checked' : '' }} >
                                        &nbsp;ঋনসহ সম্পূর্ণ ভাড়া দেয়া গৃহ
                                    </label>
                                        </div>
                                        <div class="icheck-success d-inline" style="margin-left: -30px !important">
                                    <label class="form-check form-check-inline">
                                        <input type="radio" name="usingHolding_id" value="3" {{ old('usingHolding_id') == '3' ? 'checked' : ''}} >
                                        &nbsp;মালিক নিজে বসবাস করেন
                                    </label>
                                        </div>
                                        <div class="icheck-success d-inline" style="margin-left: -30px !important">
                                    <label class="form-check form-check-inline">
                                        <input type="radio" name="usingHolding_id" value="4" {{ old('usingHolding_id') == '4' ? 'checked' : '' }} >
                                        &nbsp;নিজে বসবাস ও আংশিক ভাড়া
                                    </label>
                                        </div>
                                        @error('usingHolding_id')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>

                            </div>
                        </div>
                    <hr/>
                    <!-- /.card-body -->
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-success bg-gradient-success">পরবর্তী</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function () {


        });
    </script>
@endsection
