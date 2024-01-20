@extends('layouts.app')

@section('title')
    দল পরিবর্তন
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">দলের তথ্য</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ route('team.edit', ['team' => $team->id]) }}">
                    @csrf

                    <div class="card-body">
                        <div class="form-group row {{ $errors->has('community') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">কমিউনিটি / এলাকা *</label>

                            <div class="col-sm-10">
                                <select class="form-control select2" name="community">
                                    <option value="">কমিউনিটি / এলাকা নির্ধারন</option>

                                    @foreach($areas as $area)
                                        <option value="{{ $area->id }}" {{ empty(old('community')) ? ($errors->has('community') ? '' : ($team->area_id == $area->id ? 'selected' : '')) :
                                            (old('community') == $area->id ? 'selected' : '') }}>{{ $area->community }}</option>
                                    @endforeach
                                </select>

                                @error('community')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('team_no') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">দল নং *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="দল নং"
                                       name="team_no" value="{{ empty(old('team_no')) ? ($errors->has('team_no') ? '' : $team->team_no) : old('team_no') }}">

                                @error('team_no')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('team_name') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">দলের নাম *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="দলের নাম"
                                       name="team_name" value="{{ empty(old('team_name')) ? ($errors->has('team_name') ? '' : $team->name) : old('team_name') }}">

                                @error('team_name')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('leader_name') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">দল নেতার নাম *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="দল নেতার নাম"
                                       name="leader_name" value="{{ empty(old('leader_name')) ? ($errors->has('leader_name') ? '' : $team->leader) : old('leader_name') }}">

                                @error('leader_name')
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
