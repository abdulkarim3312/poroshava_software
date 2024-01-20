@extends('layouts.app')
@section('title','কর্মচারী বেতন হালনাগাদ')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-default">
                <div class="card-header">
                  <div class="card-title">কর্মচারীর বেতন হালনাগাদ তথ্য</div>
                </div>
                <!-- /.card-header -->
                <form enctype="multipart/form-data" action="{{ route('employee_salary_edit',['employee'=>$employee->eid]) }}" class="form-horizontal"
                      method="post">
                    @csrf
                <div class="card-body">
                    <div class="form-group row {{ $errors->has('department') ? 'has-error' :'' }}">
                        <label for="department" class="col-sm-2 col-form-label">বিভাগ <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input readonly id="department" type="text" value="{{ $employee->department->name ?? '' }}" class="form-control">
                            @error('department')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('id_no') ? 'has-error' :'' }}">
                        <label for="id_no" class="col-sm-2 col-form-label">আইডি নং <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" readonly value="{{ old('id_no',enNumberToBn($employee->emp_id)) }}" name="id_no" class="form-control"
                                   id="id_no" placeholder="আইডি নং">
                            @error('id_no')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('name') ? 'has-error' :'' }}">
                        <label for="name" class="col-sm-2 col-form-label">নাম <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" readonly value="{{ old('name',$employee->name) }}" name="name" class="form-control"
                                   id="name" placeholder="কর্মচারী নাম">
                            @error('name')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('designation') ? 'has-error' :'' }}">
                        <label for="designation" class="col-sm-2 col-form-label">পদবী <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" readonly value="{{ old('designation',$employee->designation) }}" name="designation" class="form-control"
                                   id="designation" placeholder="পদবী">
                            @error('designation')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('salary_scale') ? 'has-error' :'' }}">
                        <label for="salary_scale" class="col-sm-2 col-form-label">বেতন স্কেল <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <select name="salary_scale" id="salary_scale" class="form-control select2">
                                <option value="">বেতন স্কেল নির্ধারণ</option>
                                @foreach($salaryScales as $salaryScale)
                                    <option {{ old('salary_scale',$employee->scaleid) == $salaryScale->id ? 'selected' : '' }} value="{{ $salaryScale->id }}">{{ enNumberToBn($salaryScale->name) }}</option>
                                @endforeach
                            </select>
                            @error('salary_scale')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('salary') ? 'has-error' :'' }}">
                        <label for="salary" class="col-sm-2 col-form-label">মূল বেতন <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" value="{{ old('salary',$employee->salary) }}" name="salary" class="form-control"
                                   id="salary" placeholder="মূল বেতন">
                            @error('salary')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('special_benefits') ? 'has-error' :'' }}">
                        <label for="special_benefits" class="col-sm-2 col-form-label">বিশেষ সুবিধা <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" value="{{ old('special_benefits',$employee->special_benefits) }}" name="special_benefits" class="form-control"
                                   id="special_benefits" placeholder="বিশেষ সুবিধা">
                            @error('special_benefits')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('house_rent') ? 'has-error' :'' }}">
                        <label for="house_rent" class="col-sm-2 col-form-label">বাড়ী ভাড়া <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" value="{{ old('house_rent',$employee->houserent) }}" name="house_rent" class="form-control"
                                   id="house_rent" placeholder="বাড়ী ভাড়া">
                            @error('house_rent')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('medical_fee') ? 'has-error' :'' }}">
                        <label for="medical_fee" class="col-sm-2 col-form-label">চিকিৎসা <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" value="{{ old('medical_fee',$employee->treatment) }}" name="medical_fee" class="form-control"
                                   id="medical_fee" placeholder="চিকিৎসা">
                            @error('medical_fee')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('tiffin_fee') ? 'has-error' :'' }}">
                        <label for="tiffin_fee" class="col-sm-2 col-form-label">টিফিন <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" value="{{ old('tiffin_fee',$employee->tifin) }}" name="tiffin_fee" class="form-control"
                                   id="tiffin_fee" placeholder="টিফিন">
                            @error('tiffin_fee')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('washing_fee') ? 'has-error' :'' }}">
                        <label for="washing_fee" class="col-sm-2 col-form-label">ধোলাই <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" value="{{ old('washing_fee',$employee->wash) }}" name="washing_fee" class="form-control"
                                   id="washing_fee" placeholder="ধোলাই">
                            @error('washing_fee')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('education_fee') ? 'has-error' :'' }}">
                        <label for="education_fee" class="col-sm-2 col-form-label">শিক্ষভাতা <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" value="{{ old('education_fee',$employee->education) }}" name="education_fee" class="form-control"
                                   id="education_fee" placeholder="শিক্ষভাতা">
                            @error('education_fee')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('income_tax') ? 'has-error' :'' }}">
                        <label for="income_tax" class="col-sm-2 col-form-label">আয়কর <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" value="{{ old('income_tax',$employee->tax) }}" name="income_tax" class="form-control"
                                   id="income_tax" placeholder="আয়কর">
                            @error('income_tax')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('others_fee') ? 'has-error' :'' }}">
                        <label for="others_fee" class="col-sm-2 col-form-label">অন্যান্য <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" value="{{ old('others_fee',$employee->others) }}" name="others_fee" class="form-control"
                                   id="others_fee" placeholder="অন্যান্য">
                            @error('others_fee')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    @if($pfLoan)
                    <div class="form-group row {{ $errors->has('pf_loan') ? 'has-error' :'' }}">
                        <label for="pf_loan" class="col-sm-2 col-form-label">পি এফ লোন <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" value="{{ old('pf_loan',$pfLoan->monthly_installment_amount) }}" name="pf_loan" class="form-control"
                                   id="pf_loan" placeholder="পি এফ লোন">
                            @error('pf_loan')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    @endif
                    @if($otherLoan)
                    <div class="form-group row {{ $errors->has('other_loan') ? 'has-error' :'' }}">
                        <label for="other_loan" class="col-sm-2 col-form-label">অন্যান্য লোন <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" value="{{ old('other_loan',$otherLoan->monthly_installment_amount) }}" name="other_loan" class="form-control"
                                   id="other_loan" placeholder="অন্যান্য লোন">
                            @error('other_loan')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    @endif

                </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" id="submit-btn" class="btn btn-success bg-gradient-success">সংরক্ষণ করুন</button>
                        <a href="{{ route('employee_salary_update_list') }}" class="btn btn-default float-right">বাতিল করুন</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>
@endsection
