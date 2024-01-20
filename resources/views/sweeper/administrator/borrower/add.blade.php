@extends('layouts.app')

@section('style')
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ asset('themes/backend/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('title')
    ঋণ গ্রহীতা যুক্ত
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
                <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="{{ route('borrower.add') }}">
                    @csrf

                    <div class="card-body">
                        <div class="form-group row {{ $errors->has('id') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">আইডি *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="আইডি"
                                       name="id" value="{{ $memberId }}" readonly>

                                @error('id')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('area') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">কমিউনিটি / এলাকা *</label>

                            <div class="col-sm-10">
                                <select class="form-control" name="area" id="area">
                                    <option value="">কমিউনিটি / এলাকা নির্ধারন</option>

                                    @foreach($areas as $area)
                                        <option value="{{ $area->id }}" {{ old('area') == $area->id ? 'selected' : '' }}>{{ $area->community }}</option>
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
                                       name="name" value="{{ old('name') }}">

                                @error('name')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('father_name') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">পিতার/স্বামীর নাম *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="পিতার/স্বামীর নাম"
                                       name="father_name" value="{{ old('father_name') }}">

                                @error('father_name')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('mother_name') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">মাতার নাম *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="মাতার নাম"
                                       name="mother_name" value="{{ old('mother_name') }}">

                                @error('mother_name')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('nid') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">জাতীয় পরিচয়পত্র নম্বর / জন্ম নিবন্ধন নং *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="জাতীয় পরিচয়পত্র নম্বর / জন্ম নিবন্ধন নং"
                                       name="nid" value="{{ old('nid') }}">

                                @error('nid')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('loan_type') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">ঋণের ধরণ *</label>

                            <div class="col-sm-10">
                                <select class="form-control" name="loan_type">
                                    <option value="">ঋণের ধরণ নির্ধারন</option>
                                    <option value="1" {{ old('loan_type') == '1' ? 'selected' : '' }}>ব্যাবসা</option>
                                    <option value="2" {{ old('loan_type') == '2' ? 'selected' : '' }}>অন্যান্য</option>
                                </select>

                                @error('loan_type')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('loan_date') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">ঋণ প্রদানের তারিখ *</label>

                            <div class="col-sm-10">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" id="date" name="loan_date" value="{{ old('loan_date') }}" autocomplete="off">
                                </div>
                                <!-- /.input group -->

                                @error('loan_date')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('loan_amount') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">ঋণের পরিমান *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="ঋণের পরিমান"
                                       name="loan_amount" value="{{ old('loan_amount') }}">

                                @error('loan_amount')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('installment_count') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">কিস্তি সংখ্যা *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="কিস্তি সংখ্যা"
                                       name="installment_count" value="{{ old('installment_count') }}">

                                @error('installment_count')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('initial_installment_count') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">প্রদানকৃত কিস্তি সংখ্যা *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="প্রদানকৃত কিস্তি সংখ্যা"
                                       name="initial_installment_count" value="{{ old('initial_installment_count') }}">

                                @error('initial_installment_count')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('installment_amount') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">কিস্তি পরিমান *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="কিস্তি পরিমান"
                                       name="installment_amount" value="{{ old('installment_amount') }}">

                                @error('installment_amount')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('saving_amount') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">জমাকৃত সঞ্চয়ের পরিমান *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="জমাকৃত সঞ্চয়ের পরিমান"
                                       name="saving_amount" value="{{ old('saving_amount') }}">

                                @error('saving_amount')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('image') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">ছবি *</label>

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

            var teamSelected = '{{ old('team') }}';

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
