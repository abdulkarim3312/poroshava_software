@extends('layouts.app')
@section('title','ঠিকাদারের ব্যয় সংযুক্তি')
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
        <!-- left column -->
        <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-outline card-default">
                <div class="card-header">
                    <h3 class="card-title">ঠিকাদারের  ব্যয় সংযুক্তির তথ্য</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form enctype="multipart/form-data" action="{{ route('project.contractor_payment',['contractorAccount'=>$contractorAccount->conacc_id]) }}" class="form-horizontal"
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
                        <div class="form-group row {{ $errors->has('income_expenditure') ? 'has-error' :'' }}">
                            <label for="income_expenditure" class="col-sm-3 col-form-label">আয়/ব্যয় খাত <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select name="income_expenditure" class="form-control select2" id="income_expenditure">
                                    <option value="">আয়/ব্যয় নির্ধারণ</option>
                                    <option {{ old('income_expenditure') == 2 ? 'selected' : '' }} value="2">ব্যয়
                                    </option>
                                </select>
                                @error('income_expenditure')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('sector_type') ? 'has-error' :'' }}">
                            <label for="sector_type" class="col-sm-3 col-form-label">খাত টাইপ <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select name="sector_type" class="form-control select2" id="sector_type">
                                    <option value="">খাত টাইপ নির্ধারণ</option>
                                </select>
                                @error('sector_type')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('sub_sector_type') ? 'has-error' :'' }}">
                            <label for="sub_sector_type" class="col-sm-3 col-form-label">উপ খাত টাইপ <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select name="sub_sector_type" class="form-control select2" id="sub_sector_type">
                                    <option value="">উপ খাত টাইপ নির্ধারণ</option>
                                </select>
                                @error('sub_sector_type')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('sector') ? 'has-error' :'' }}">
                            <label for="sector" class="col-sm-3 col-form-label">খাত <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select name="sector" class="form-control select2" id="sector">
                                    <option value="">খাত নির্ধারণ</option>
                                </select>
                                @error('sector')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('tax_type') ? 'has-error' :'' }}">
                            <label for="tax_type" class="col-sm-3 col-form-label">ট্যাক্স টাইপ <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select class="form-control select2"  id="tax_type" name="tax_type">
                                    <option value="">ট্যাক্স টাইপ নির্ধারণ</option>
                                    <option {{ old('tax_type') == 1 ? 'selected' : '' }} value="1">ট্যাক্স</option>
                                    <option {{ old('tax_type') == 2 ? 'selected' : '' }} value="2">নন-ট্যাক্স</option>
                                </select>
                                @error('tax_type')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('financial_year') ? 'has-error' :'' }}">
                            <label for="financial_year" class="col-sm-3 col-form-label">অর্থ বছর <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select class="form-control select2" name="financial_year" id="financial_year">
                                    <option value="">অর্থ বছর নির্ধারণ</option>
                                    @for($i=2019; $i <= date('Y'); $i++)
                                        <option
                                            value="{{ $i }}-{{ substr($i+1, -2) }}" {{ old('financial_year') == $i.'-'.substr($i+1, -2) ? 'selected' : '' }}>{{ enNumberToBn($i) }}-{{ enNumberToBn(substr($i+1, -2)) }}</option>
                                    @endfor
                                </select>
                                @error('financial_year')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                                <span class="text-danger budget_message" id="budget_message"></span>
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('description') ? 'has-error' :'' }}">
                            <label for="description" class="col-sm-3 col-form-label">খাতের বিবরন</label>
                            <div class="col-sm-9">
                                <input type="text" value="{{ old('description') }}" name="description" class="form-control"
                                       id="description" placeholder="খাতের বিবরন লিখুন">
                                @error('description')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('bank') ? 'has-error' :'' }}">
                            <label for="bank" class="col-sm-3 col-form-label">ব্যাংক <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select name="bank" class="form-control select2" id="bank">
                                    <option value="">ব্যাংক নির্ধারণ</option>
                                    @foreach($banks as $bank)
                                        <option {{ old('bank') == $bank->bank_id ? 'selected' : '' }} value="{{ $bank->bank_id }}">{{ $bank->bank_name }}</option>
                                    @endforeach
                                </select>
                                @error('bank')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('branch') ? 'has-error' :'' }}">
                            <label for="branch" class="col-sm-3 col-form-label">শাখার <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select name="branch" class="form-control select2" id="branch">
                                    <option value="">শাখা নির্ধারণ</option>
                                </select>
                                @error('branch')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('bank_account') ? 'has-error' :'' }}">
                            <label for="bank_account" class="col-sm-3 col-form-label">ব্যাংক একাউন্ট নম্বর <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select name="bank_account" class="form-control select2" id="bank_account">
                                    <option value="">ব্যাংক একাউন্ট নম্বর নির্ধারণ</option>
                                </select>
                                @error('bank_account')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('voucher_no') ? 'has-error' :'' }}">
                            <label for="voucher_no" class="col-sm-3 col-form-label">ভাউচার/ চালান নম্বর <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" value="{{ old('voucher_no') }}" name="voucher_no" class="form-control"
                                       id="voucher_no" placeholder="ভাউচার/ চালান নম্বর লিখুন">
                                @error('voucher_no')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('cheque_no') ? 'has-error' :'' }}">
                            <label for="cheque_no" class="col-sm-3 col-form-label">চেক নম্বর <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" value="{{ old('cheque_no') }}" name="cheque_no" class="form-control"
                                       id="cheque_no" placeholder="চেক নম্বর লিখুন">
                                @error('cheque_no')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('amount') ? 'has-error' :'' }}">
                            <label for="amount" class="col-sm-3 col-form-label">টাকা <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" value="{{ old('amount') }}" name="amount" class="form-control"
                                       id="amount" placeholder="টাকার পরিমাণ লিখুন">
                                @error('amount')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9 offset-md-3 col-12">
                                <div class="table-responsive-sm">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td>
                                                <div class="form-group {{ $errors->has('jamanot') ? 'has-error' :'' }}">
                                                    <label for="jamanot">জামানতের টাকা</label>
                                                    <input type="text" value="{{ old('jamanot') }}" name="jamanot" class="form-control"
                                                           id="jamanot" placeholder="জামানতের টাকার পরিমাণ">
                                                    @error('jamanot')
                                                    <span class="help-block">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group {{ $errors->has('jamanot_voucher_no') ? 'has-error' :'' }}">
                                                    <label for="jamanot_voucher_no">ভাউচার নম্বর/চালান</label>
                                                    <input type="text" value="{{ old('jamanot_voucher_no') }}" name="jamanot_voucher_no" class="form-control"
                                                           id="jamanot_voucher_no" placeholder="ভাউচার নম্বর/চালান">
                                                    @error('jamanot_voucher_no')
                                                    <span class="help-block">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group {{ $errors->has('jamanot_cheque_no') ? 'has-error' :'' }}">
                                                    <label for="jamanot_cheque_no">চেক নম্বর</label>
                                                    <input type="text" value="{{ old('jamanot_cheque_no') }}" name="jamanot_cheque_no" class="form-control"
                                                           id="jamanot_cheque_no" placeholder="চেক নম্বর">
                                                    @error('jamanot_cheque_no')
                                                    <span class="help-block">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-group {{ $errors->has('vat') ? 'has-error' :'' }}">
                                                    <label for="vat">ভ্যাটের টাকা</label>
                                                    <input type="text" value="{{ old('vat') }}" name="vat" class="form-control"
                                                           id="vat" placeholder="ভ্যাটের টাকার পরিমাণ">
                                                    @error('vat')
                                                    <span class="help-block">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group {{ $errors->has('vat_voucher_no') ? 'has-error' :'' }}">
                                                    <label for="vat_voucher_no">ভাউচার নম্বর/চালান</label>
                                                    <input type="text" value="{{ old('vat_voucher_no') }}" name="vat_voucher_no" class="form-control"
                                                           id="vat_voucher_no" placeholder="ভাউচার নম্বর/চালান">
                                                    @error('vat_voucher_no')
                                                    <span class="help-block">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group {{ $errors->has('vat_cheque_no') ? 'has-error' :'' }}">
                                                    <label for="vat_cheque_no">চেক নম্বর</label>
                                                    <input type="text" value="{{ old('vat_cheque_no') }}" name="vat_cheque_no" class="form-control"
                                                           id="vat_cheque_no" placeholder="চেক নম্বর">
                                                    @error('vat_cheque_no')
                                                    <span class="help-block">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-group {{ $errors->has('tax') ? 'has-error' :'' }}">
                                                    <label for="tax">আয়করের টাকা</label>
                                                    <input type="text" value="{{ old('tax') }}" name="tax" class="form-control"
                                                           id="tax" placeholder="আয়করের টাকার পরিমাণ">
                                                    @error('tax')
                                                    <span class="help-block">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group {{ $errors->has('tax_voucher_no') ? 'has-error' :'' }}">
                                                    <label for="tax_voucher_no">ভাউচার নম্বর/চালান</label>
                                                    <input type="text" value="{{ old('vat_voucher_no') }}" name="tax_voucher_no" class="form-control"
                                                           id="tax_voucher_no" placeholder="ভাউচার নম্বর/চালান">
                                                    @error('tax_voucher_no')
                                                    <span class="help-block">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group {{ $errors->has('tax_cheque_no') ? 'has-error' :'' }}">
                                                    <label for="tax_cheque_no">চেক নম্বর</label>
                                                    <input type="text" value="{{ old('tax_cheque_no') }}" name="tax_cheque_no" class="form-control"
                                                           id="tax_cheque_no" placeholder="চেক নম্বর">
                                                    @error('tax_cheque_no')
                                                    <span class="help-block">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('receiver_name') ? 'has-error' :'' }}">
                            <label for="receiver_name" class="col-sm-3 col-form-label">প্রাপকের নাম</label>
                            <div class="col-sm-9">
                                <input type="text" readonly  value="{{ old('receiver_name',$contractorAccount->contractor->name ?? '') }}" name="receiver_name" class="form-control"
                                       id="receiver_name" placeholder="প্রাপকের নাম">
                                @error('receiver_name')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('date') ? 'has-error' :'' }}">
                            <label for="date" class="col-sm-3 col-form-label">প্রাপ্তি/ প্রদান তারিখ <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" readonly autocomplete="off" value="{{ old('date') }}" name="date" class="form-control date-picker"
                                       id="date" placeholder="প্রাপ্তি/ প্রদান তারিখ">
                                @error('date')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('note') ? 'has-error' :'' }}">
                            <label for="note" class="col-sm-3 col-form-label">মন্তব্য</label>
                            <div class="col-sm-9">
                                <input type="text" value="{{ old('note') }}" name="note" class="form-control"
                                       id="note" placeholder="মন্তব্য লিখুন">
                                @error('note')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" id="submit-btn" class="btn btn-success bg-gradient-success">সংরক্ষণ করুন</button>
                        <a href="{{ route('dashboard') }}" class="btn btn-default float-right">বাতিল করুন</a>
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
                $('#branch').trigger('change');
            })


            var branchSelected = '{{ old('branch') }}'
            $("#bank").change(function (){
                let bankId = $(this).val();
                $('#branch').html('<option value="">শাখা নির্ধারণ</option>');
                if(bankId != ''){
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_branches') }}",
                        data: { bankId: bankId }
                    }).done(function( data ) {
                        $.each(data, function( index, item ) {
                            if (branchSelected == item.branch_id)
                                $('#branch').append('<option value="'+item.branch_id+'" selected>'+item.branch_name+'</option>');
                            else
                                $('#branch').append('<option value="'+item.branch_id+'">'+item.branch_name+'</option>');
                        });
                        $('#branch').trigger('change');
                    });
                }
            })
            $('#bank').trigger('change');

            var bankAccountSelected = '{{ old('bank_account') }}'
            $("#branch").change(function (){
                let branchId = $(this).val();
                let upangshoId = $('#upangsho').val();
                $('#bank_account').html('<option value="">ব্যাংক একাউন্ট নম্বর নির্ধারণ</option>');
                if(branchId != ''){
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_bank_accounts') }}",
                        data: { branchId: branchId,upangshoId:upangshoId }
                    }).done(function( data ) {
                        $.each(data, function( index, item ) {
                            if (bankAccountSelected == item.bank_details_id)
                                $('#bank_account').append('<option value="'+item.bank_details_id+'" selected>'+item.acc_no+'</option>');
                            else
                                $('#bank_account').append('<option value="'+item.bank_details_id+'">'+item.acc_no+'</option>');
                        });
                    });
                }
            })
            $('#branch').trigger('change');


            var sectorTypeSelected = '{{ old('sector_type') }}'
            $("#income_expenditure").change(function () {
                let incomeExpenditureId = $(this).val();
                let upangshoId = $('#upangsho').val();
                $('#financial_year').trigger('change');
                $('#sector_type').html('<option value="">খাত টাইপ নির্ধারণ</option>');
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
                        $('#financial_year').trigger('change');
                    });
                }
            })
            $('#sub_sector_type').trigger('change');


        })

    </script>
@endsection
