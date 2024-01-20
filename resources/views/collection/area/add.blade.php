@extends('layouts.app')
@section('title','মহল্লা যুক্ত করুন')
@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">মহল্লার তথ্য</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form enctype="multipart/form-data" action="{{ route('collection_area.add') }}" class="form-horizontal" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row {{ $errors->has('area_name') ? 'has-error' :'' }}">
                            <label for="area_name" class="col-sm-2 col-form-label">মহল্লার নাম <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ old('area_name') }}" name="area_name" class="form-control" id="area_name" placeholder="মহল্লার নাম">
                                @error('area_name')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('area_code') ? 'has-error' :'' }}">
                            <label for="area_code" class="col-sm-2 col-form-label">মহল্লার কোড</label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ old('area_code') }}" name="area_code" class="form-control" id="area_code" placeholder="মহল্লার কোড">

                                @error('area_code')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('status') ? 'has-error' :'' }}">
                            <label class="col-sm-2 col-form-label">অবস্থা <span class="text-danger">*</span></label>

                            <div class="col-sm-10">

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
                        <button type="submit" class="btn btn-success bg-gradient-success">সংরক্ষণ</button>
                        <a href="{{ route('collection_area.all') }}" class="btn btn-default float-right">বাতিল</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
            <!-- /.card -->
        </div>
        <!--/.col (left) -->
    </div>
@endsection
