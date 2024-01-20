@extends('layouts.app')
@section('title','বাজেট যুক্ত করুন')
@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-outline card-default">
                <div class="card-header">
                    <h3 class="card-title">বাজেটের তথ্য</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form enctype="multipart/form-data" action="{{ route('budget.create') }}" class="form-horizontal"
                      method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row {{ $errors->has('upangsho') ? 'has-error' :'' }}">
                            <label for="upangsho" class="col-sm-2 col-form-label">উপাংশ <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
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

                        <div class="form-group row {{ $errors->has('income_expenditure') ? 'has-error' :'' }}">
                            <label for="income_expenditure" class="col-sm-2 col-form-label">আয়/ব্যয় খাত <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select name="income_expenditure" class="form-control select2" id="income_expenditure">
                                    <option value="">আয়/ব্যয় নির্ধারণ</option>
                                    <option {{ old('income_expenditure') == 1 ? 'selected' : '' }} value="1">আয়</option>
                                    <option {{ old('income_expenditure') == 2 ? 'selected' : '' }} value="2">ব্যয়
                                    </option>
                                </select>
                                @error('income_expenditure')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('sector_type') ? 'has-error' :'' }}">
                            <label for="sector_type" class="col-sm-2 col-form-label">খাত টাইপ <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select name="sector_type" class="form-control select2" id="sector_type">
                                    <option value="">খাত টাইপ নির্ধারণ</option>
                                </select>
                                @error('sector_type')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('sub_sector_type') ? 'has-error' :'' }}">
                            <label for="sub_sector_type" class="col-sm-2 col-form-label">উপ খাত টাইপ <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select name="sub_sector_type" class="form-control select2" id="sub_sector_type">
                                    <option value="">উপ খাত টাইপ নির্ধারণ</option>
                                </select>
                                @error('sub_sector_type')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('sector') ? 'has-error' :'' }}">
                            <label for="sector" class="col-sm-2 col-form-label">খাত <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select name="sector" class="form-control select2" id="sector">
                                    <option value="">খাত নির্ধারণ</option>
                                </select>
                                @error('sector')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('financial_year') ? 'has-error' :'' }}">
                            <label for="financial_year" class="col-sm-2 col-form-label">অর্থ বছর <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select class="form-control select2" name="financial_year" id="financial_year">
                                    <option value="">অর্থ বছর নির্ধারণ</option>
                                    @for($i=2022; $i <= date('Y'); $i++)
                                        <option
                                            value="{{ $i }}-{{ substr($i+1, -2) }}" {{ old('financial_year') == $i.'-'.substr($i+1, -2) ? 'selected' : '' }}>{{ enNumberToBn($i) }}-{{ enNumberToBn(substr($i+1, -2)) }}</option>
                                    @endfor
                                </select>
                                @error('financial_year')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                                <span class="text-danger" id="budget_message"></span>
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('amount') ? 'has-error' :'' }}">
                            <label for="amount" class="col-sm-2 col-form-label">টাকা <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ old('amount') }}" name="amount" class="form-control"
                                       id="amount" placeholder="টাকার পরিমাণ লিখুন">
                                @error('amount')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" id="submit-btn" class="btn btn-success bg-gradient-success">সংরক্ষণ করুন</button>
                        <a href="{{ route('budget') }}" class="btn btn-default float-right">বাতিল করুন</a>
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
            $('#upangsho').change(function () {
                $("#income_expenditure").trigger('change');
                $("#financial_year").trigger('change');
            })
            var sectorTypeSelected = '{{ old('sector_type') }}'
            $("#income_expenditure").change(function () {
                let incomeExpenditureId = $(this).val();
                let upangshoId = $('#upangsho').val();
                $('#sector_type').html('<option value="">খাত টাইপ নির্ধারণ</option>');
                $('#financial_year').trigger('change');
                if (incomeExpenditureId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_upangsho_wise_sector_types') }}",
                        data: {incomeExpenditureId: incomeExpenditureId, upangshoId: upangshoId}
                    }).done(function (data) {
                        $.each(data, function (index, item) {
                            if (sectorTypeSelected == item.tax_id)
                                $('#sector_type').append('<option value="' + item.tax_id + '" selected>' + item.tax_name + '</option>');
                            else
                                $('#sector_type').append('<option value="' + item.tax_id + '">' + item.tax_name + '</option>');
                        });
                        $('#sector_type').trigger('change');
                    });
                }
            })
            $('#income_expenditure').trigger('change');

            var subSectorSelected = '{{ old('sub_sector_type') }}'
            $("#sector_type").change(function () {
                let sectorId = $(this).val();
                let upangshoId = $('#upangsho').val();
                let incomeExpenditureId = $('#income_expenditure').val();
                $('#sub_sector_type').html('<option value="">উপ খাত টাইপ নির্ধারণ</option>');
                if (sectorId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_upangsho_income_expenditure_sub_sector_types') }}",
                        data: {sectorId: sectorId, incomeExpenditureId: incomeExpenditureId, upangshoId: upangshoId}
                    }).done(function (data) {
                        $.each(data, function (index, item) {
                            if (subSectorSelected == item.tax_id) {
                               if(subSectorSelected != ''){
                                   $('#sub_sector_type').append('<option value="' + item.tax_id + '" selected>' + item.tax_name2 + '</option>');
                               }else {
                                   $('#sub_sector_type').append('<option value="' + item.tax_id + '">' + item.tax_name2 + '</option>');
                               }
                            } else {
                                $('#sub_sector_type').append('<option value="' + item.tax_id + '">' + item.tax_name2 + '</option>');
                            }
                        });
                        $('#sub_sector_type').trigger('change');
                    });
                }
            })
            $('#sector_type').trigger('change');

            var sectorSelected = '{{ old('sector') }}'
            $("#sub_sector_type").change(function () {
                let subSectorTypeId = $(this).val();
                $('#sector').html('<option value="">খাত নির্ধারণ</option>');
                if (subSectorTypeId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_sectors') }}",
                        data: {subSectorTypeId: subSectorTypeId}
                    }).done(function (data) {
                        $.each(data, function (index, item) {
                            if (sectorSelected == item.khat_id)
                                $('#sector').append('<option value="' + item.khat_id + '" selected>' + item.serilas + '' + item.khat_name + '</option>');
                            else
                                $('#sector').append('<option value="' + item.khat_id + '">' + item.serilas + '' + item.khat_name + '</option>');
                        });
                    });
                }
            })
            $('#sub_sector_type').trigger('change');

            $("#sector").change(function () {
                $('#financial_year').trigger('change');
            })
            $("#financial_year").change(function () {
                let financialYear = $(this).val();
                let sectorId = $('#sector').val();
                let incomeExpenditureId = $('#income_expenditure').val();
                $('#budget_message').text(' ');
                if (financialYear != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('check_budget') }}",
                        data: {financialYear: financialYear,sectorId:sectorId,incomeExpenditureId:incomeExpenditureId}
                    }).done(function (response) {
                        if(response.success == false){
                            $('#budget_message').text(response.message);
                            $('#submit-btn').attr("disabled","disabled");
                        }else{
                            $('#submit-btn').removeAttr("disabled");
                        }
                    });
                }
            })
            $('#financial_year').trigger('change');

        })
    </script>
@endsection
