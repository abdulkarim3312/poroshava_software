@extends('layouts.app')
@section('title','আর্থিক স্থানন্তর')
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
                    <h3 class="card-title">আর্থিক স্থানন্তরের তথ্য</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form enctype="multipart/form-data" action="{{ route('balance_transfer') }}" class="form-horizontal"
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
                        <div class="row">
                            <div class="col-12">
                                <h4>উৎস ব্যাংক</h4>
                                <hr>
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
                        <div class="row">
                            <div class="col-12">
                                <h4>গন্তব্য ব্যাংক</h4>
                                <hr>
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('target_bank') ? 'has-error' :'' }}">
                            <label for="target_bank" class="col-sm-3 col-form-label">ব্যাংক <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select name="target_bank" class="form-control select2" id="target_bank">
                                    <option value="">ব্যাংক নির্ধারণ</option>
                                    @foreach($banks as $bank)
                                        <option {{ old('target_bank') == $bank->bank_id ? 'selected' : '' }} value="{{ $bank->bank_id }}">{{ $bank->bank_name }}</option>
                                    @endforeach
                                </select>
                                @error('target_bank')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('target_branch') ? 'has-error' :'' }}">
                            <label for="target_branch" class="col-sm-3 col-form-label">শাখার <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select name="target_branch" class="form-control select2" id="target_branch">
                                    <option value="">শাখা নির্ধারণ</option>
                                </select>
                                @error('target_branch')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('target_bank_account') ? 'has-error' :'' }}">
                            <label for="target_bank_account" class="col-sm-3 col-form-label">ব্যাংক একাউন্ট নম্বর <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select name="target_bank_account" class="form-control select2" id="target_bank_account">
                                    <option value="">ব্যাংক একাউন্ট নম্বর নির্ধারণ</option>
                                </select>
                                @error('target_bank_account')
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
                        <div class="form-group row {{ $errors->has('voucher_no') ? 'has-error' :'' }}">
                            <label for="voucher_no" class="col-sm-3 col-form-label">ভাউচার নম্বর <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" value="{{ old('voucher_no') }}" name="voucher_no" class="form-control"
                                       id="voucher_no" placeholder="ভাউচার নম্বর লিখুন">
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
                $('#target_branch').trigger('change');
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

            // Target Bank
            var targetBranchSelected = '{{ old('target_branch') }}'
            $("#target_bank").change(function (){
                let targetBankId = $(this).val();
                $('#target_branch').html('<option value="">শাখা নির্ধারণ</option>');
                if(targetBankId != ''){
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_branches') }}",
                        data: { bankId: targetBankId }
                    }).done(function( data ) {
                        $.each(data, function( index, item ) {
                            if (targetBranchSelected == item.branch_id)
                                $('#target_branch').append('<option value="'+item.branch_id+'" selected>'+item.branch_name+'</option>');
                            else
                                $('#target_branch').append('<option value="'+item.branch_id+'">'+item.branch_name+'</option>');
                        });
                        $('#target_branch').trigger('change');
                    });
                }
            })
            $('#target_bank').trigger('change');

            var targetBankAccountSelected = '{{ old('target_bank_account') }}'
            $("#target_branch").change(function (){
                let targetBranchId = $(this).val();
                let upangshoId = $('#upangsho').val();
                $('#target_bank_account').html('<option value="">ব্যাংক একাউন্ট নম্বর নির্ধারণ</option>');
                if(targetBranchId != ''){
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_bank_accounts') }}",
                        data: { branchId: targetBranchId,upangshoId:upangshoId }
                    }).done(function( data ) {
                        $.each(data, function( index, item ) {
                            if (targetBankAccountSelected == item.bank_details_id)
                                $('#target_bank_account').append('<option value="'+item.bank_details_id+'" selected>'+item.acc_no+'</option>');
                            else
                                $('#target_bank_account').append('<option value="'+item.bank_details_id+'">'+item.acc_no+'</option>');
                        });
                    });
                }
            })
            $('#target_branch').trigger('change');




        })

    </script>
@endsection
