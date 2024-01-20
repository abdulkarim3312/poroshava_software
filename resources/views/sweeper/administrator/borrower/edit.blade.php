@extends('layouts.app')
@section('title')
    ঋণ গ্রহীতা পরিবর্তন
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">ঋণ গ্রহীতার তথ্য</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="{{ route('borrower.edit', ['borrower' => $borrower->id]) }}">
                    @csrf

                    <div class="card-body">
                        <div class="form-group row {{ $errors->has('area') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">কমিউনিটি / এলাকা *</label>

                            <div class="col-sm-10">
                                <select class="form-control" name="area" id="area">
                                    <option value="">কমিউনিটি / এলাকা নির্ধারন</option>

                                    @foreach($areas as $area)
                                        <option value="{{ $area->id }}" {{ empty(old('area')) ? ($errors->has('area') ? '' : ($borrower->area_id == $area->id ? 'selected' : '')) :
                                            (old('area') == $area->id ? 'selected' : '') }}>{{ $area->community }}</option>
                                    @endforeach
                                </select>

                                @error('area')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('team') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">দল *</label>

                            <div class="col-sm-10">
                                <select class="form-control" name="team" id="team">
                                    <option value="">দল নির্ধারন</option>
                                </select>

                                @error('team')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('name') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">ঋণ গ্রহিতার নাম *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="ঋণ গ্রহিতার নাম"
                                       name="name" value="{{ empty(old('name')) ? ($errors->has('name') ? '' : $borrower->name) : old('name') }}">

                                @error('name')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('father_name') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">পিতার/স্বামীর নাম *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="পিতার/স্বামীর নাম"
                                       name="father_name" value="{{ empty(old('father_name')) ? ($errors->has('father_name') ? '' : $borrower->father_name) : old('father_name') }}">

                                @error('father_name')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('mother_name') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">মাতার নাম *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="মাতার নাম"
                                       name="mother_name" value="{{ empty(old('mother_name')) ? ($errors->has('mother_name') ? '' : $borrower->mother_name) : old('mother_name') }}">

                                @error('mother_name')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('nid') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">জাতীয় পরিচয়পত্র নম্বর / জন্ম নিবন্ধন নং *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="জাতীয় পরিচয়পত্র নম্বর / জন্ম নিবন্ধন নং"
                                       name="nid" value="{{ empty(old('nid')) ? ($errors->has('nid') ? '' : $borrower->nid) : old('nid') }}">

                                @error('nid')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('image') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">ছবি</label>

                            <div class="col-sm-10">
                                <input type="file" class="form-control"
                                       name="image">

                                @error('image')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- bootstrap datepicker -->
    <script src="{{ asset('themes/backend/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $(function () {
            //Date picker
            $('#date').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });

            var teamSelected = '{{ empty(old('team')) ? ($errors->has('team') ? '' : $borrower->team_id) : old('team') }}';

            $('#area').change(function () {
                var areaId = $(this).val();

                $('#team').html('<option value="">দল নির্ধারন</option>');

                if (areaId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_team') }}",
                        data: { areaId: areaId }
                    }).done(function( data ) {
                        $.each(data, function( index, item ) {
                            if (teamSelected == item.id)
                                $('#team').append('<option value="'+item.id+'" selected>'+item.name+'</option>');
                            else
                                $('#team').append('<option value="'+item.id+'">'+item.name+'</option>');
                        });
                    });
                }
            });

            $('#area').trigger('change');
        });
    </script>
@endsection
