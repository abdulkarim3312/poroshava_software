@extends('layouts.app')

@section('title')
    পরিচ্ছন্ন কর্মী হালনাগাদ
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
                <form class="form-horizontal" method="POST" action="{{ route('cleaner.edit',['cleaner'=>$cleaner->id]) }}" enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">
                        <div class="form-group row {{ $errors->has('cleaner_id') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">পরিচ্ছন্ন কর্মীর আইডি *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="পরিচ্ছন্ন কর্মীর আইডি"
                                       name="cleaner_id" value="{{ $cleaner->cleaner_id }}" readonly>

                                @error('cleaner_id')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('religion') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">ধর্ম *</label>

                            <div class="col-sm-10">
                                <select style="width: 100%" name="religion" id="religion" class="form-control">
                                    <option value="">ধর্ম নির্ধারণ</option>
                                    <option {{ $cleaner->religion == 1 ? 'selected' : ''  }} value="1">ইসলাম</option>
                                    <option {{ $cleaner->religion == 2 ? 'selected' : ''  }} value="2">হিন্দু</option>
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
                                        <option {{ $cleaner->area_id == $area->id ? 'selected' : ''  }} value="{{ $area->id }}">{{ $area->community }}</option>
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
                                        <option {{ $cleaner->type_id == $type->id ? 'selected' : ''  }} value="{{ $type->id }}">{{ $type->name }}</option>
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
                                       name="name" value="{{ $cleaner->name }}">

                                @error('name')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('father_name') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">পিতা/ স্বামীর নাম *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="পিতা/ স্বামীর নাম"
                                       name="father_name" value="{{ $cleaner->father_name }}">

                                @error('father_name')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('national_nid') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">জাতীয় পরিচয় পত্ৰ/ জন্ম নিবন্ধন নম্বরঃ *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="জাতীয় পরিচয় পত্ৰ/ জন্ম নিবন্ধন নম্বরঃ"
                                       name="national_nid" value="{{ $cleaner->national_nid }}">

                                @error('national_nid')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('mobile_no') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">মোবাইল নম্বর *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="মোবাইল নম্বর"
                                       name="mobile_no" value="{{ $cleaner->mobile_no }}">

                                @error('mobile_no')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('address') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">ঠিকানা *</label>

                            <div class="col-sm-10">
                                <textarea name="address" placeholder="ঠিকানা" class="form-control">{{ $cleaner->address }}</textarea>
                                @error('address')
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
                                <img style="margin-top: 15px" src="{{ asset($cleaner->photo) }}" width="100px" alt="">
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('status') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">অবস্থান *</label>

                            <div class="col-sm-10">

                                <div class="radio" style="display: inline">
                                    <label>
                                        <input type="radio" name="status" value="1" {{ empty(old('status')) ? ($errors->has('status') ? '' : ($cleaner->status == '1' ? 'checked' : '')) :
                                            (old('status') == '1' ? 'checked' : '') }}>
                                        সক্রিয়
                                    </label>
                                </div>

                                <div class="radio" style="display: inline">
                                    <label>
                                        <input type="radio" name="status" value="0" {{ empty(old('status')) ? ($errors->has('status') ? '' : ($cleaner->status == '0' ? 'checked' : '')) :
                                            (old('status') == '0' ? 'checked' : '') }}>
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

            var teamNameSelected = '{{ $cleaner->team_id }}';

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
