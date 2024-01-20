@extends('layouts.app')

@section('title')
    হোল্ডিং মালিকানার ধরন যুক্ত
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">হোল্ডিং মালিকানার ধরন তথ্য</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ route('holding.holding_category.add') }}">
                    @csrf

                    <div class="card-body">
                        <div class="form-group row {{ $errors->has('name') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">মালিকানার ধরন *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="মালিকানার ধরন"
                                       name="name" value="{{ old('name') }}">

                                @error('name')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('taxable') ? 'has-error' :'' }}">
                          <label class="col-sm-2 control-label">কর যোগ্য *</label>
                            <div class="col-sm-10" style="margin-top: 6px !important">
                                <div class="icheck-success d-inline">
                                    <input checked type="radio" id="active" name="taxable" value="1" {{ old('taxable') == '1' ? 'checked' : '' }}>
                                    <label for="active">
                                        হ্যা
                                    </label>
                                </div>

                                <div class="icheck-danger d-inline">
                                    <input type="radio" id="inactive" name="taxable" value="0" {{ old('taxable') == '0' ? 'checked' : '' }}>
                                    <label for="inactive">
                                        না
                                    </label>
                                </div>

                                @error('taxable')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('tax_rate') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">করের হার</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="করের হার(%)"
                                       name="tax_rate" value="{{ old('tax_rate') }}">

                                @error('tax_rate')
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
