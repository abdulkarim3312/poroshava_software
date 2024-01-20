@extends('layouts.app')

@section('title')
    ব্যবসার ধরন যুক্ত
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">ব্যবসার ধরন তথ্য</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ route('trade_license_business_type_add') }}">
                    @csrf

                    <div class="card-body">
                        <div class="form-group row {{ $errors->has('business_type') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">ব্যবসার ধরন *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="ব্যবসার ধরন"
                                       name="business_type" value="{{ old('business_type') }}">

                                @error('business_type')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('type_rate') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">লাইসেন্স ফি *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="লাইসেন্স ফি"
                                       name="type_rate" value="{{ old('type_rate') }}">

                                @error('type_rate')
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
