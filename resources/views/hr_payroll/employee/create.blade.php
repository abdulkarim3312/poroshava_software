@extends('layouts.app')
@section('title','কর্মচারী সংযুক্তি')
@section('style')
    <style>
        @media (min-width: 768px){
            .col-form-label {
                text-align: left;
            }
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-default">
                <div class="card-header">
                  <div class="card-title">কর্মচারীর সংযুক্তি তথ্য</div>
                </div>
                <!-- /.card-header -->
                <form enctype="multipart/form-data" action="{{ route('employee.create') }}" class="form-horizontal"
                      method="post">
                    @csrf
                <div class="card-body">
                    <div class="form-group row {{ $errors->has('upangsho') ? 'has-error' :'' }}">
                        <label for="upangsho" class="col-sm-3 col-form-label">উপাংশ <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <select name="upangsho" class="form-control select2" id="upangsho">
                                <option value="">উপাংশ নির্ধারণ</option>
                                @foreach($sections as $section)
                                    <option
                                        {{ old('upangsho') == $section->upangsho_id ? 'selected' : '' }} value="{{ $section->upangsho_id }}">{{ $section->upangsho_name }}</option>
                                @endforeach
                            </select>
                            @error('upangsho')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('id_no') ? 'has-error' :'' }}">
                        <label for="id_no" class="col-sm-3 col-form-label">আইডি নং <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" readonly value="{{ old('id_no',enNumberToBn($idNo + 1)) }}" name="id_no" class="form-control"
                                   id="id_no" placeholder="আইডি নং">
                            @error('id_no')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('name') ? 'has-error' :'' }}">
                        <label for="name" class="col-sm-3 col-form-label">নাম <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" value="{{ old('name') }}" name="name" class="form-control"
                                   id="name" placeholder="কর্মচারী নাম">
                            @error('name')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('department') ? 'has-error' :'' }}">
                        <label for="department" class="col-sm-3 col-form-label">বিভাগ <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <select name="department" id="department" class="form-control select2">
                                <option value="">বিভাগ নির্ধারণ</option>
                                @foreach($departments as $department)
                                <option {{ old('department') == $department->id ? 'selected' : '' }} value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                            @error('department')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('section') ? 'has-error' :'' }}">
                        <label for="section" class="col-sm-3 col-form-label">শাখা <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <select name="section" id="section" class="form-control select2">
                                <option value="">শাখা নির্ধারণ</option>
                            </select>
                            @error('section')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('salary_scale') ? 'has-error' :'' }}">
                        <label for="salary_scale" class="col-sm-3 col-form-label">বেতন স্কেল <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <select name="salary_scale" id="salary_scale" class="form-control select2">
                                <option value="">বেতন স্কেল নির্ধারণ</option>
                                @foreach($salaryScales as $salaryScale)
                                    <option {{ old('salary_scale') == $salaryScale->id ? 'selected' : '' }} value="{{ $salaryScale->id }}">{{ enNumberToBn($salaryScale->name) }}</option>
                                @endforeach
                            </select>
                            @error('salary_scale')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('designation') ? 'has-error' :'' }}">
                        <label for="designation" class="col-sm-3 col-form-label">পদবী <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" value="{{ old('designation') }}" name="designation" class="form-control"
                                   id="designation" placeholder="পদবী">
                            @error('designation')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('salary') ? 'has-error' :'' }}">
                        <label for="salary" class="col-sm-3 col-form-label">মূল বেতন <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" value="{{ old('salary') }}" name="salary" class="form-control"
                                   id="salary" placeholder="মূল বেতন">
                            @error('salary')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('father_name') ? 'has-error' :'' }}">
                        <label for="father_name" class="col-sm-3 col-form-label">পিতার নাম <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" value="{{ old('father_name') }}" name="father_name" class="form-control"
                                   id="father_name" placeholder="পিতার নাম">
                            @error('father_name')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('mother_name') ? 'has-error' :'' }}">
                        <label for="mother_name" class="col-sm-3 col-form-label">মাতার নাম <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" value="{{ old('mother_name') }}" name="mother_name" class="form-control"
                                   id="mother_name" placeholder="মাতার নাম">
                            @error('mother_name')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('joining_date') ? 'has-error' :'' }}">
                        <label for="joining_date" class="col-sm-3 col-form-label">যোগদানের তারিখ <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" value="{{ old('joining_date') }}" autocomplete="off" name="joining_date" class="form-control date-picker"
                                   id="joining_date" placeholder="যোগদানের তারিখ">
                            @error('joining_date')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('joining_present_post_date') ? 'has-error' :'' }}">
                        <label for="joining_present_post_date" class="col-sm-3 col-form-label">বর্তমান পদে যোগদানের তারিখ <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" value="{{ old('joining_present_post_date') }}" autocomplete="off" name="joining_present_post_date" class="form-control date-picker"
                                   id="joining_present_post_date" placeholder="বর্তমান পদে যোগদানের তারিখ">
                            @error('joining_present_post_date')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('retired_date') ? 'has-error' :'' }}">
                        <label for="retired_date" class="col-sm-3 col-form-label">অবসরের তারিখ</label>
                        <div class="col-sm-9">
                            <input type="text" value="{{ old('retired_date') }}" autocomplete="off" name="retired_date" class="form-control date-picker"
                                   id="retired_date" placeholder="অবসরের তারিখ">
                            @error('retired_date')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('entertainment_allowance_date') ? 'has-error' :'' }}">
                        <label for="entertainment_allowance_date" class="col-sm-3 col-form-label">শ্রান্তি বিনোদন ভাতা প্রান্তির তারিখ</label>
                        <div class="col-sm-9">
                            <input type="text" value="{{ old('entertainment_allowance_date') }}" autocomplete="off" name="entertainment_allowance_date" class="form-control date-picker"
                                   id="entertainment_allowance_date" placeholder="শ্রান্তি বিনোদন ভাতা প্রান্তির তারিখ">
                            @error('entertainment_allowance_date')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('nid_no') ? 'has-error' :'' }}">
                        <label for="nid_no" class="col-sm-3 col-form-label">জাতীয় পরিচয় পত্র নং <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" value="{{ old('nid_no') }}" name="nid_no" class="form-control"
                                   id="nid_no" placeholder="জাতীয় পরিচয় পত্র নং">
                            @error('nid_no')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('tin_no') ? 'has-error' :'' }}">
                        <label for="tin_no" class="col-sm-3 col-form-label">টিআইএন নং</label>
                        <div class="col-sm-9">
                            <input type="text" value="{{ old('tin_no') }}" name="tin_no" class="form-control"
                                   id="tin_no" placeholder="টিআইএন নং">
                            @error('tin_no')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('birth_day') ? 'has-error' :'' }}">
                        <label for="birth_day" class="col-sm-3 col-form-label">জন্ম তারিখ <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" value="{{ old('birth_day') }}" autocomplete="off" name="birth_day" class="form-control date-picker"
                                   id="birth_day" placeholder="জন্ম তারিখ">
                            @error('birth_day')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('mobile_no') ? 'has-error' :'' }}">
                        <label for="mobile_no" class="col-sm-3 col-form-label">মোবাইল নং</label>
                        <div class="col-sm-9">
                            <input type="text" value="{{ old('mobile_no') }}" name="mobile_no" class="form-control"
                                   id="mobile_no" placeholder="মোবাইল নং">
                            @error('mobile_no')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('email') ? 'has-error' :'' }}">
                        <label for="email" class="col-sm-3 col-form-label">ই-মেইল</label>
                        <div class="col-sm-9">
                            <input type="email" value="{{ old('email') }}" name="email" class="form-control"
                                   id="mobile_no" placeholder="ই-মেইল">
                            @error('email')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('salary_account_no') ? 'has-error' :'' }}">
                        <label for="salary_account_no" class="col-sm-3 col-form-label">বেতন হিসাব নং <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" value="{{ old('salary_account_no') }}" name="salary_account_no" class="form-control"
                                   id="salary_account_no" placeholder="বেতন হিসাব নং">
                            @error('salary_account_no')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('provident_fund_account_no') ? 'has-error' :'' }}">
                        <label for="provident_fund_account_no" class="col-sm-3 col-form-label">ভবিষ্য তহবিল হিসাব নং <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" value="{{ old('provident_fund_account_no') }}" name="provident_fund_account_no" class="form-control"
                                   id="provident_fund_account_no" placeholder="ভবিষ্য তহবিল হিসাব নং">
                            @error('provident_fund_account_no')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('gratuity_account_no') ? 'has-error' :'' }}">
                        <label for="gratuity_account_no" class="col-sm-3 col-form-label">অনুতোষিক হিসাব নং <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" value="{{ old('gratuity_account_no') }}" name="gratuity_account_no" class="form-control"
                                   id="gratuity_account_no" placeholder="অনুতোষিক হিসাব নং">
                            @error('gratuity_account_no')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('photo') ? 'has-error' :'' }}">
                        <label for="photo" class="col-sm-3 col-form-label">ছবি</label>
                        <div class="col-sm-9">
                            <input type="file" name="photo" class="form-control"
                                   id="photo" placeholder="অনুতোষিক হিসাব নং">
                            @error('photo')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                            <div id="image-preview"></div>
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('religion') ? 'has-error' :'' }}">
                        <label for="religion" class="col-sm-3 col-form-label">ধর্ম <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <select class="form-control select2" id="religion" name="religion">
                                <option  value="">ধর্ম নির্ধারণ</option>
                                <option {{ old('religion') == 1 ? 'selected' : '' }} value="1">মুসলিম</option>
                                <option {{ old('religion') == 1 ? 'selected' : '' }} value="2">হিন্দু</option>
                            </select>
                            @error('religion')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" id="submit-btn" class="btn btn-success bg-gradient-success">সংরক্ষণ করুন</button>
                        <a href="{{ route('employee') }}" class="btn btn-default float-right">বাতিল করুন</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function () {
            var sectionSelected = '{{ old('section') }}'
            $("#department").change(function () {
                let departmentId = $(this).val();
                $('#section').html('<option value="">শাখা নির্ধারণ</option>');
                if (departmentId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_sections') }}",
                        data: {departmentId: departmentId}
                    }).done(function (data) {
                        $.each(data, function (index, item) {
                            if (sectionSelected == item.id)
                                $('#section').append('<option value="' + item.id + '" selected>' + item.shaka_name + '</option>');
                            else
                                $('#section').append('<option value="' + item.id + '">' + item.shaka_name + '</option>');
                        });
                    });
                }
            })
            $('#department').trigger('change');


            $(document).ready(function() {
                $('#photo').on('change', function(e) {
                    var file = e.target.files[0];
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        var imageSrc = e.target.result;
                        $('#image-preview').html('<img style="width: 150px;margin-top: 8px" src="' + imageSrc + '" alt="Preview">');
                    };

                    reader.readAsDataURL(file);
                });
            });
        })

    </script>
@endsection
