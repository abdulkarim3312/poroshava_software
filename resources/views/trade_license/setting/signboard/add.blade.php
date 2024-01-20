@extends('layouts.app')

@section('title')
    সাইন বোর্ডের ধরন যুক্ত
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">সাইন বোর্ডের ধরন তথ্য</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ route('trade_license_signboard_add') }}">
                    @csrf

                    <div class="card-body">
                        <div class="form-group row {{ $errors->has('sign_board_type') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">সাইন বোর্ডের ধরন *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="সাইন বোর্ডের ধরন"
                                       name="sign_board_type" value="{{ old('sign_board_type') }}">

                                @error('sign_board_type')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('sign_board_rate') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">সাইন বোর্ড(ব.ফুট) *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="সাইন বোর্ড(ব.ফুট)"
                                       name="sign_board_rate" value="{{ old('sign_board_rate') }}">

                                @error('sign_board_rate')
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
