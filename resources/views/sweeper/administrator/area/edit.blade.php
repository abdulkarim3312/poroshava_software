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
                <form class="form-horizontal" method="POST" action="{{ route('area.edit', ['area' => $area->id]) }}">
                    @csrf

                    <div class="card-body">
                        <div class="form-group row {{ $errors->has('community') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">কমিউনিটি / এলাকা *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="কমিউনিটি / এলাকা"
                                       name="community" value="{{ empty(old('community')) ? ($errors->has('community') ? '' : $area->community) : old('community') }}">

                                @error('community')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('president') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">এস আই সি সভাপতি *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="এস আই সি সভাপতি"
                                       name="president" value="{{ empty(old('president')) ? ($errors->has('president') ? '' : $area->president) : old('president') }}">

                                @error('president')
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
