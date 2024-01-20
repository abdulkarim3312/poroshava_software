@extends('layouts.app')

@section('title')
    করদাতা যুক্ত
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">করদাতার তথ্য সমূহ প্রদান করুন</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ route('holding.tax_payer.add') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">

                        <div class="form-group row {{ $errors->has('name') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">করদাতার  নাম *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="করদাতার নাম" name="name" value="{{ old('name') }}">

                                @error('name')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('father_husband_name') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">পিতা/ স্বামীর নাম <span class="text-danger">*</span></label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="পিতা/ স্বামীর নাম"
                                       name="father_husband_name" value="{{ old('father_husband_name') }}">

                                @error('father_husband_name')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('mother_name') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">মাতার নাম <span class="text-danger">*</span></label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="মাতার নাম"
                                       name="mother_name" value="{{ old('mother_name') }}">

                                @error('mother_name')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('contact_no') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">মোবাইল নম্বর <span class="text-danger">*</span></label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="মোবাইল নম্বর"
                                       name="contact_no" value="{{ old('contact_no') }}">

                                @error('contact_no')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('national_id') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">জাতীয় পরিচয় পত্ৰ/ জন্ম নিবন্ধন নম্বরঃ *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="জাতীয় পরিচয় পত্ৰ/ জন্ম নিবন্ধন নম্বরঃ"
                                       name="national_id" value="{{ old('national_id') }}">

                                @error('national_id')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('email') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">ই-মেইল</label>

                            <div class="col-sm-10">
                                <input type="email" class="form-control" name="email" placeholder="email@gmail.com" value="{{ old('email') }}">
                                @error('email')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row {{ $errors->has('address') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">ঠিকানা <span class="text-danger">*</span></label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="ঠিকানা" name="address" value="{{ old('address') }}">

                                @error('address')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('status') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">স্ট্যাটাস <span class="text-danger">*</span></label>
                            <div class="col-sm-10" style="margin-top: 6px !important">
                                <div class="icheck-success d-inline">
                                    <input checked type="radio" id="active" name="status" value="1" {{ old('status') == '1' ? 'checked' : '' }}>
                                    <label for="active">
                                        সক্রিয়
                                    </label>
                                </div>

                                <div class="icheck-danger d-inline">
                                    <input type="radio" id="inactive" name="status" value="0" {{ old('status') == '0' ? 'checked' : '' }}>
                                    <label for="inactive">
                                        নিষ্ক্রিয়
                                    </label>
                                </div>

                                @error('status')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success bg-gradient-success">সংরক্ষণ করুন</button>
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
