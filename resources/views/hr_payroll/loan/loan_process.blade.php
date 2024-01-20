@extends('layouts.app')
@section('title','লোন প্রক্রিয়া')
@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-outline card-default">
                <div class="card-header">
                    <h3 class="card-title">লোন প্রক্রিয়ার তথ্য</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form enctype="multipart/form-data" action="{{ route('loan_process') }}" class="form-horizontal"
                      method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row {{ $errors->has('department') ? 'has-error' :'' }}">
                            <label for="department" class="col-sm-2 col-form-label">শাখা  <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select name="department" class="form-control select2" id="department">
                                    <option value="">শাখা নির্ধারণ</option>
                                    @foreach($departments as $department)
                                        <option
                                            {{ old('department') == $department->id ? 'selected' : '' }} value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                @error('department')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('employee') ? 'has-error' :'' }}">
                            <label for="employee" class="col-sm-2 col-form-label">কর্মচারী <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select name="employee" class="form-control select2" id="employee">
                                    <option value="">কর্মচারী নির্ধারণ</option>
                                </select>
                                @error('employee')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('loan_type') ? 'has-error' :'' }}">
                            <label for="loan_type" class="col-sm-2 col-form-label">লোনের ধরন   <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select name="loan_type" class="form-control select2" id="loan_type">
                                    <option value="">লোনের ধরন নির্ধারণ</option>
                                    @foreach($loanTypes as $loanType)
                                        <option
                                            {{ old('loan_type') == $loanType->id ? 'selected' : '' }} value="{{ $loanType->id }}">{{ $loanType->name }}</option>
                                    @endforeach
                                </select>
                                @error('loan_type')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('amount') ? 'has-error' :'' }}">
                            <label for="amount" class="col-sm-2 col-form-label">লোনের পরিমান <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ old('amount') }}" name="amount" class="form-control"
                                       id="amount" placeholder="লোনের পরিমান লিখুন">
                                @error('amount')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('monthly_installment_amount') ? 'has-error' :'' }}">
                            <label for="monthly_installment_amount" class="col-sm-2 col-form-label">মাসিক কিস্তি পরিমান <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ old('monthly_installment_amount') }}" name="monthly_installment_amount" class="form-control"
                                       id="monthly_installment_amount" placeholder="মাসিক কিস্তি পরিমান লিখুন">
                                @error('monthly_installment_amount')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('date') ? 'has-error' :'' }}">
                            <label for="date" class="col-sm-2 col-form-label">লোনের তারিখ <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ old('date') }}" name="date" class="form-control date-picker"
                                       id="date" placeholder="মাসিক কিস্তি পরিমান লিখুন">
                                @error('date')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" id="submit-btn" class="btn btn-success bg-gradient-success">সংরক্ষণ করুন</button>
                        <a href="{{ route('loan_process') }}" class="btn btn-default float-right">বাতিল করুন</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
            <!-- /.card -->
        </div>
        <!--/.col (left) -->
    </div>
@endsection
@section('script')
    <script>
        $(function () {

            var employeeSelected = '{{ old('employee') }}'
            $("#department").change(function () {
                let departmentId = $(this).val();
                $('#employee').html('<option value="">কর্মচারী নির্ধারণ</option>');
                if (departmentId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_department_wise_employees') }}",
                        data: {departmentId: departmentId}
                    }).done(function (data) {
                        $.each(data, function (index, item) {
                            if (employeeSelected == item.eid)
                                $('#employee').append('<option value="' + item.eid + '" selected>' + item.name + '</option>');
                            else
                                $('#employee').append('<option value="' + item.eid + '">' + item.name + '</option>');
                        });
                    });
                }
            })
            $('#department').trigger('change');

        })
    </script>
@endsection
