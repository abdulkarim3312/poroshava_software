@extends('layouts.app')

@section('title')
    পরিচ্ছন্ন কর্মী যুক্ত
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">পরিচ্ছন্ন কর্মীর তথ্য</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ route('cleaner.add') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">
                        <div class="form-group row {{ $errors->has('cleaner_id') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">পরিচ্ছন্ন কর্মীর আইডি *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="পরিচ্ছন্ন কর্মীর আইডি"
                                       name="cleaner_id" value="{{ $cleanerId }}" readonly>

                                @error('cleaner_id')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('religion') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">ধর্ম  *</label>

                            <div class="col-sm-10">
                                <select style="width: 100%" name="religion" id="religion" class="form-control">
                                    <option value="">ধর্ম নির্ধারণ</option>
                                    <option {{ old('religion') == 1 ? 'selected' : ''  }} value="1">ইসলাম</option>
                                    <option {{ old('religion') == 2 ? 'selected' : ''  }} value="2">হিন্দু</option>
                                </select>

                                @error('religion')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('community') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">কমিউনিটি / এলাকা *</label>

                            <div class="col-sm-10">
                                <select style="width: 100%" name="community" id="community" class="form-control select2">
                                    <option value="">কমিউনিটি / এলাকা</option>
                                    @foreach($areas as $area)
                                    <option {{ old('community') == $area->id ? 'selected' : ''  }} value="{{ $area->id }}">{{ $area->community }}</option>
                                    @endforeach
                                </select>

                                @error('community')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('team_name') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">দলের নাম *</label>

                            <div class="col-sm-10">
                                <select style="width: 100%" name="team_name" id="team_name" class="form-control select2">
                                    <option value="">দলের নাম</option>
                                </select>

                                @error('team_name')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('type') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">ধরণ *</label>

                            <div class="col-sm-10">
                                <select style="width: 100%" name="type" id="" class="form-control select2">
                                    <option value="">ধরণ</option>
                                    @foreach($types as $type)
                                        <option {{ old('type') == $type->id ? 'selected' : ''  }} value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>

                                @error('type')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('name') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">পরিচ্ছন্ন কর্মীর নাম *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="পরিচ্ছন্ন কর্মীর নাম"
                                       name="name" value="{{ old('name') }}">

                                @error('name')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('father_name') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">পিতা/ স্বামীর নাম *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="পিতা/ স্বামীর নাম"
                                       name="father_name" value="{{ old('father_name') }}">

                                @error('father_name')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('national_nid') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">জাতীয় পরিচয় পত্ৰ/ জন্ম নিবন্ধন নম্বরঃ *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="জাতীয় পরিচয় পত্ৰ/ জন্ম নিবন্ধন নম্বরঃ"
                                       name="national_nid" value="{{ old('national_nid') }}">

                                @error('national_nid')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('mobile_no') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">মোবাইল নম্বর *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="মোবাইল নম্বর"
                                       name="mobile_no" value="{{ old('mobile_no') }}">

                                @error('mobile_no')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('address') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">ঠিকানা *</label>

                            <div class="col-sm-10">
                                <textarea name="address" placeholder="ঠিকানা" class="form-control">{{ old('address') }}</textarea>
                                @error('address')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('daily_salary') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">দৈনিক বেতন *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="দৈনিক বেতন"
                                       name="daily_salary" value="{{ old('daily_salary') }}">

                                @error('daily_salary')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('bonus') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">বোনাস *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="বোনাস"
                                       name="bonus" value="{{ old('bonus') }}">
                                @error('bonus')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('others_salary') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">অন্যান্য</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="অন্যান্য"
                                       name="others_salary" value="{{ old('others_salary') }}">

                                @error('others_salary')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('deduction_day') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">বেতন কর্তনের দিন </label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="বেতন কর্তনের দিন"
                                       name="deduction_day" value="{{ old('deduction_day') }}">

                                @error('deduction_day')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('photo') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">ছবি *</label>

                            <div class="col-sm-10">
                                <input type="file" name="photo" class="form-control">
                                @error('photo')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('status') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">অবস্থান *</label>

                            <div class="col-sm-10">

                                <div class="radio" style="display: inline">
                                    <label>
                                        <input type="radio" name="status" checked value="1" {{ old('status') == '1' ? 'checked' : '' }}>
                                        সক্রিয়
                                    </label>
                                </div>

                                <div class="radio" style="display: inline">
                                    <label>
                                        <input type="radio" name="status" value="0" {{ old('status') == '0' ? 'checked' : '' }}>
                                        নিষ্ক্রিয়
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
                        <button type="submit" class="btn btn-success bg-gradient-success">সংরক্ষণ করুন</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function () {

            var teamNameSelected = '{{ old('team_name') }}';

            $('#community').change(function () {

                var communityID = $(this).val();

                $('#team_name').html('<option value="">দলের নাম</option>');

                if (communityID != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_team') }}",
                        data: { communityID: communityID }
                    }).done(function( data ) {
                        $.each(data, function( index, item ) {
                            if (teamNameSelected == item.id)
                                $('#team_name').append('<option value="'+item.id+'" selected>'+item.name+'</option>');
                            else
                                $('#team_name').append('<option value="'+item.id+'">'+item.name+'</option>');
                        });
                    });
                }
            });

            $('#community').trigger('change');
        });
    </script>
@endsection
