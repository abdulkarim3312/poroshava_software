@extends('layouts.app')

@section('title')
    হোল্ডিং স্থাপনার ধরন পরিবর্তন
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">হোল্ডিং স্থাপনার ধরন তথ্য</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ route('holding.structure_type.edit', ['structureType' => $structureType->id]) }}">
                    @csrf

                    <div class="card-body">
                        <div class="form-group row {{ $errors->has('community') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">হোল্ডিং স্থাপনার ধরন*</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="হোল্ডিং স্থাপনার ধরন"
                                       name="name" value="{{ empty(old('name')) ? ($errors->has('name') ? '' : $structureType->name) : old('name') }}">

                                @error('name')
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
