@extends('layouts.app')

@section('title')
    নির্মাণ তথ্য ফরম
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
                                                <li role="presentation" class="disabled">
                                                    <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" aria-expanded="true"><span class="round-tab">1 </span> <i>হোল্ডিং এর তথ্য</i></a>
                                                </li>
                                                <li role="presentation" class="active">
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
                        <h3 class="card-title">নির্মাণ তথ্য</h3>
                    </div>
                    <!-- /.card-header -->

                    <!-- form start -->
                    <form class="form-horizontal" style="font-size: 12px;" method="POST" action="{{ route('holding_tax_payer_construction',['holdingTaxPayer'=>$holdingTaxPayer->id]) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="container-fluid">
                            <div class="form-group row">
                                <label for="holding_info_id" class="col-sm-2 col-form-label">হোল্ডিং নং</label>
                                <div class="col-sm-4">
                                    <div class="form-group row {{ $errors->has('holding_tax_payer_id') ? 'has-error' :'' }}">

                                    <input type="hidden" name="holding_tax_payer_id" id="holding_tax_payer_id" value="{{ $holdingTaxPayer->id }}">
                                    <select type="text" name="holding_info_id" id="holding_info_id2" class="form-control select2" >
                                        <option value="">নির্বাচন করুন</option>
                                        <option {{ old('holding_info_id',$holdingTaxPayer->holdingInfo->id) == $holdingInfo->id ? 'selected' : ''  }} value="{{ $holdingInfo->id }}">{{ enNumberToBn($holdingInfo->holding_no) }}</option>
                                    </select>

                                    @error('holding_tax_payer_id')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                    </div>
                                </div>
                                <label for="construction_rate" class="col-sm-2 col-form-label">নির্মাণের হার</label>
                                <div class="col-sm-4">
                                    <div class="form-group row {{ $errors->has('construction_rate') ? 'has-error' :'' }}">
                                    <input type="text" name="construction_rate" id="construction_rate" value="{{old('construction_rate')}}" class="form-control" placeholder="" >
                                    @error('construction_rate')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="use_type_id2" class="col-sm-2 col-form-label">হোল্ডিং ব্যবহারের ধরন</label>
                                <div class="col-sm-4">
                                    <div class="form-group row {{ $errors->has('use_type_id') ? 'has-error' :'' }}">
                                    <select type="text" name="use_type_id" id="use_type_id2" class="form-control select2">
                                        <option value="">নির্বাচন করুন</option>
                                        @foreach($holdingUseTypes as $holdingUseType)
                                            <option {{ old('use_type_id',$holdingTaxPayer->holdingInfo->use_type_id) == $holdingUseType->id ? 'selected' : ''  }} value="{{ $holdingUseType->id }}">{{ $holdingUseType->name }}</option>
                                        @endforeach
                                    </select>
                                        @error('use_type_id')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <label for="structure_type_id2" class="col-sm-2 col-form-label">স্থাপনার ধরন</label>
                                <div class="col-sm-4">
                                    <div class="form-group row {{ $errors->has('structure_type_id') ? 'has-error' :'' }}">
                                    <select type="text" name="structure_type_id" id="structure_type_id2" class="form-control select2" >
                                        <option value="">নির্বাচন করুন</option>
                                        @foreach($structureTypes as $structureType)
                                            <option {{ old('structure_type_id',$holdingTaxPayer->holdingInfo->structure_type_id) == $structureType->id ? 'selected' : ''  }} value="{{ $structureType->id }}">{{ $structureType->name }}</option>
                                        @endforeach
                                    </select>
                                        @error('structure_type_id')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="total_floor" class="col-sm-2 col-form-label">মোট তলার সংখ্যা</label>
                                <div class="col-sm-4">
                                    <div class="form-group row {{ $errors->has('total_floor') ? 'has-error' :'' }}">
                                    <input type="text" name="total_floor" id="total_floor" value="{{old('total_floor',0)}}" class="form-control" placeholder="" >
                                        @error('total_floor')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <label for="unuse_floor" class="col-sm-2 col-form-label">অব্যবহৃত তলার সংখ্যা</label>
                                <div class="col-sm-4">
                                    <div class="form-group row {{ $errors->has('unuse_floor') ? 'has-error' :'' }}">
                                    <input type="text" name="unuse_floor" id="unuse_floor" value="{{old('unuse_floor',0)}}" class="form-control" placeholder="" >
                                        @error('unuse_floor')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="owner_floor" class="col-sm-2 col-form-label">মালিকের ব্যবহৃত তলার সংখ্যা</label>
                                <div class="col-sm-4">
                                    <div class="form-group row {{ $errors->has('owner_floor') ? 'has-error' :'' }}">
                                    <input type="text" name="owner_floor" id="owner_floor" value="{{old('owner_floor',0)}}" class="form-control" placeholder="" >
                                        @error('owner_floor')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <label for="rent_floor" class="col-sm-2 col-form-label">ভাড়ায় ব্যবহৃত তলার সংখ্যা</label>
                                @if($holdingTaxPayer->holdingInfo->usingHolding_id!=3)
                                    <div class="col-sm-4">
                                        <div class="form-group row {{ $errors->has('rent_floor') ? 'has-error' :'' }}">
                                        <input type="text" name="rent_floor" id="rent_floor" value="{{old('rent_floor',0)}}" class="form-control" placeholder="" >
                                            @error('rent_floor')
                                            <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group row">
                                <label for="structure_length" class="col-sm-2 col-form-label">দৈর্ঘ্য</label>
                                <div class="col-sm-4">
                                    <div class="form-group row {{ $errors->has('structure_length') ? 'has-error' :'' }}">
                                    <input type="text" name="structure_length" id="structure_length" value="{{old('structure_length')}}" class="form-control" placeholder="ft units" >
                                        @error('structure_length')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <label for="structure_width" class="col-sm-2 col-form-label">প্রস্থ</label>
                                <div class="col-sm-4">
                                    <div class="form-group row {{ $errors->has('structure_width') ? 'has-error' :'' }}">
                                    <input type="text" name="structure_width" id="structure_width" value="{{old('structure_width')}}" class="form-control" placeholder="ft units" >
                                        @error('structure_width')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="aprox_monthly_rent" class="col-sm-2 col-form-label">আনুমানিক মাসিক ভাড়া <spna class="text-danger">*</spna></label>
                                <div class="col-sm-10">
                                    <div class="form-group row {{ $errors->has('aprox_monthly_rent') ? 'has-error' :'' }}">
                                    <input type="text" name="aprox_monthly_rent" id="aprox_monthly_rent" value="{{old('aprox_monthly_rent')}}" class="form-control" placeholder="আনুমানিক মাসিক ভাড়া">
                                    @error('aprox_monthly_rent')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <!-- /.card-body -->
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-success bg-gradient-success">আরো যোগ করুন</button>
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
