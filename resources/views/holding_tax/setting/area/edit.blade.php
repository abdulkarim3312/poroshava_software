@extends('layouts.app')

@section('title')
    এলাকা পরিবর্তন
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">এলাকার তথ্য</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ route('holding.area.edit', ['area' => $area->id]) }}">
                    @csrf

                    <div class="card-body">
                        <div class="form-group row {{ $errors->has('road_no') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">মহল্লা নং </label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="মহল্লার নাম"
                                       name="road_no" value="{{ empty(old('road_no')) ? ($errors->has('road_no') ? '' : $area->road_no) : old('road_no') }}">

                                @error('road_no')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('road_name') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">মহল্লা নাম *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="মহল্লার কোড"
                                       name="road_name" value="{{ empty(old('road_name')) ? ($errors->has('road_name') ? '' : $area->road_name) : old('road_name') }}">

                                @error('road_name')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('ward_id') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">ওয়ার্ড নং *</label>

                            <div class="col-sm-10">
                                <select class="form-control" name="ward_id" id="ward_id" required>
                                    <option value="">Select Ward</option>
                                    @foreach($wordInfos as $wordInfo)
                                        <option value="{{ $wordInfo->id }}" {{ $area->ward_id==$wordInfo->id?'selected':'' }}>{{ $wordInfo->ward_no }}</option>
                                    @endforeach
                                </select>

                                @error('ward_id')
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
