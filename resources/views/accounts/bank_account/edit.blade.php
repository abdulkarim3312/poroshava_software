@extends('layouts.app')
@section('title','ব্যাঙ্ক একাউন্ট হালনাগাদ')
@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-outline card-default">
                <div class="card-header">
                    <h3 class="card-title">ব্যাঙ্ক একাউন্ট তথ্য</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form enctype="multipart/form-data" action="{{ route('bank_account.edit',['bankAccount'=>$bankAccount->bank_details_id]) }}" class="form-horizontal" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row {{ $errors->has('upangsho') ? 'has-error' :'' }}">
                            <label for="upangsho" class="col-sm-2 col-form-label">উপাংশ <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select name="upangsho" class="form-control select2" id="upangsho">
                                    <option value="">উপাংশ নির্ধারণ</option>
                                    @foreach($sections as $section)
                                        <option {{ old('upangsho',$bankAccount->upangsho_id) == $section->upangsho_id ? 'selected' : '' }} value="{{ $section->upangsho_id }}">{{ $section->upangsho_name }}</option>
                                    @endforeach
                                </select>
                                @error('upangsho')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('bank') ? 'has-error' :'' }}">
                            <label for="bank" class="col-sm-2 col-form-label">ব্যাংক <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select name="bank" class="form-control select2" id="bank">
                                    <option value="">ব্যাংক নির্ধারণ</option>
                                    @foreach($banks as $bank)
                                        <option {{ old('bank',$bankAccount->bank_id) == $bank->bank_id ? 'selected' : '' }} value="{{ $bank->bank_id }}">{{ $bank->bank_name }}</option>
                                    @endforeach
                                </select>
                                @error('bank')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('branch') ? 'has-error' :'' }}">
                            <label for="branch" class="col-sm-2 col-form-label">শাখার <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select name="branch" class="form-control select2" id="branch">
                                    <option value="">শাখা নির্ধারণ</option>
                                </select>
                                @error('branch')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('account_no') ? 'has-error' :'' }}">
                            <label for="account_no" class="col-sm-2 col-form-label">হিসাব নাম্বার <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ old('account_no',$bankAccount->acc_no) }}" name="account_no" class="form-control" id="account_no" placeholder="হিসাব নাম্বার">
                                @error('account_no')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('code') ? 'has-error' :'' }}">
                            <label for="code" class="col-sm-2 col-form-label">হিসাব কোড <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ old('code',$bankAccount->acc_code) }}" name="code" class="form-control" id="code" placeholder="হিসাব কোড">
                                @error('code')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('details') ? 'has-error' :'' }}">
                            <label for="details" class="col-sm-2 col-form-label">বিস্তারিত <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ old('details',$bankAccount->acc_details) }}" name="details" class="form-control" id="details" placeholder="বিস্তারিত">
                                @error('details')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('opening_balance') ? 'has-error' :'' }}">
                            <label for="opening_balance" class="col-sm-2 col-form-label">প্রারম্ভিক স্থিতি <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ old('opening_balance',$bankAccount->open_balance) }}" name="opening_balance" class="form-control" id="opening_balance" placeholder="প্রারম্ভিক স্থিতি">
                                @error('opening_balance')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('status') ? 'has-error' :'' }}">
                            <label class="col-sm-2 col-form-label">স্ট্যাটাস <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <div class="icheck-success d-inline">
                                    <input checked type="radio" id="active" name="status" value="1" {{ empty(old('status')) ? ($errors->has('status') ? '' : ($bankAccount->status == '1' ? 'checked' : '')) :
                                            (old('status') == '1' ? 'checked' : '') }}>
                                    <label for="active">
                                        সক্রিয়
                                    </label>
                                </div>
                                <div class="icheck-danger d-inline">
                                    <input type="radio" id="inactive" name="status" value="0" {{ empty(old('status')) ? ($errors->has('status') ? '' : ($bankAccount->status == '0' ? 'checked' : '')) :
                                            (old('status') == '0' ? 'checked' : '') }}>
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
                        <a href="{{ route('bank_account') }}" class="btn btn-default float-right">বাতিল করুন</a>
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
        $(function (){
            var branchSelected = '{{ old('branch',$bankAccount->branch_id) }}'
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
                    });
                }
            })
            $('#bank').trigger('change');
        })
    </script>
@endsection
