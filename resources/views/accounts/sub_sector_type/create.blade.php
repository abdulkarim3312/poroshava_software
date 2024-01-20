@extends('layouts.app')
@section('title','উপ খাত টাইপ যুক্ত করুন')
@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-outline card-default">
                <div class="card-header">
                    <h3 class="card-title">উপ খাত টাইপের তথ্য</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form enctype="multipart/form-data" action="{{ route('sub_sector_type.create') }}" class="form-horizontal" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row {{ $errors->has('upangsho') ? 'has-error' :'' }}">
                            <label for="upangsho" class="col-sm-2 col-form-label">উপাংশ <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select name="upangsho" class="form-control select2" id="upangsho">
                                    <option value="">উপাংশ নির্ধারণ</option>
                                    @foreach($sections as $section)
                                        <option {{ old('upangsho') == $section->upangsho_id ? 'selected' : '' }} value="{{ $section->upangsho_id }}">{{ $section->upangsho_name }}</option>
                                    @endforeach
                                </select>
                                @error('upangsho')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('income_expenditure') ? 'has-error' :'' }}">
                            <label for="income_expenditure" class="col-sm-2 col-form-label">আয়/ব্যয় খাত <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select name="income_expenditure" class="form-control select2" id="income_expenditure">
                                    <option value="">আয়/ব্যয় নির্ধারণ</option>
                                    <option {{ old('income_expenditure') == 1 ? 'selected' : '' }} value="1">আয়</option>
                                    <option {{ old('income_expenditure') == 2 ? 'selected' : '' }} value="2">ব্যয়</option>
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
                        <div class="form-group row {{ $errors->has('serial') ? 'has-error' :'' }}">
                            <label for="serial" class="col-sm-2 col-form-label">ক্রমিক নাম</label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ old('serial') }}" name="serial" class="form-control" id="serial" placeholder="ক্রমিক লিখুন (ক, খ, গ...)">
                                @error('serial')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('name') ? 'has-error' :'' }}">
                            <label for="name" class="col-sm-2 col-form-label">উপ খাত টাইপের নাম <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ old('name') }}" name="name" class="form-control" id="name" placeholder="উপ খাত টাইপের নাম">
                                @error('name')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('status') ? 'has-error' :'' }}">
                            <label class="col-sm-2 col-form-label">স্ট্যাটাস <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <div class="icheck-success d-inline">
                                    <input checked type="radio" id="active" name="status" value="1" {{ old('status') == '1' ? 'checked' : '' }}>
                                    <label for="active">
                                        সক্রিয়
                                    </label>
                                </div>
                                <div class="icheck-danger d-inline">
                                    <input type="radio" id="inactive" name="status" value="0" {{ old('status') == '0' ? 'checked' : '' }}>
                                    <label for="inactive">
                                        নিষ্ক্রিয়
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
                        <a href="{{ route('sub_sector_type') }}" class="btn btn-default float-right">বাতিল করুন</a>
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

        })
    </script>
@endsection


