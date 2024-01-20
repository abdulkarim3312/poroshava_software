@extends('layouts.app')
@section('title','চেক রেজিস্টার')
@section('style')
    <style>

        .table-bordered td, .table-bordered th {
            border: 1px solid #dee2e6;
            vertical-align: middle;
            border-bottom-width: 2px;
            text-align: center;
        }

        .table-bordered thead td, .table-bordered thead th {
            vertical-align: middle;
        }

        .table thead th {
            border-bottom: 1px solid #000000 !important;
        }

        .table-bordered td, .table-bordered th {
            border: 1px solid #000000 !important;
        }

        .table-bordered td, .table-bordered th {
            padding: 3px !important;
            font-size: 13px !important;
        }

        .table-bordered-modal td, .table-bordered-modal th {
            border: 1px solid #dee2e6 !important;
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
                    <h3 class="card-title">ডেটা ফিল্টারিং</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('report.cheque_register') }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="upangsho">উপাংশ <span
                                            class="text-danger">*</span></label>
                                    <select required name="upangsho" class="form-control select2" id="upangsho">
                                        <option value="">উপাংশ নির্ধারণ</option>
                                        @foreach($sections as $section)
                                            <option
                                                {{ request('upangsho') == $section->upangsho_id ? 'selected' : '' }} value="{{ $section->upangsho_id }}">{{ $section->upangsho_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="financial_year">অর্থ বছর <span
                                            class="text-danger">*</span></label>
                                    <select required class="form-control select2" name="financial_year"
                                            id="financial_year">
                                        <option value="">অর্থ বছর নির্ধারণ</option>
                                        @for($i=2019; $i <= date('Y'); $i++)
                                            <option value="{{ $i }}-{{ substr($i+1, -2) }}" {{ request('financial_year') == $i.'-'. substr($i+1, -2) ? 'selected' : '' }}>{{ enNumberToBn($i) }}
                                            -{{ enNumberToBn(substr($i+1, -2)) }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="start_date">শুরুর তারিখ <span class="text-danger">*</span></label>
                                    <input required type="text" id="start_date" autocomplete="off"
                                           name="start_date" class="form-control date-picker"
                                           placeholder="শুরুর তারিখ লিখুন" value="{{ request()->get('start_date')  }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="end_date">শেষের তারিখ <span class="text-danger">*</span></label>
                                    <input required type="text" id="end_date" autocomplete="off"
                                           name="end_date" class="form-control date-picker"
                                           placeholder="শেষের তারিখ লিখুন" value="{{ request()->get('end_date')  }}">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <input type="submit" name="search"
                                           class="btn btn-success bg-gradient-success form-control" value="সার্চ">
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <!-- /.card -->
        </div>
        <!--/.col (left) -->
    </div>
    @if(count($expenses) > 0)
        <form id="all_allow_confirm"  method="post" action="{{ route('cheque_register.allow_all') }}">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-default">
                    <div class="card-header">
                        <a href="#" onclick="getprint('printArea')" class="btn btn-success bg-gradient-success btn-sm"><i
                                class="fa fa-print"></i></a>
                       <button onclick="return allAllowConfirm()" class="btn btn-warning bg-gradient-warning btn-sm text-white" type="button">সব গুলোর অনুমতি দিন</button>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive-sm" id="printArea">
                            <div class="row print-heading">
                                <div class="col-12">
                                    <h1 class="text-center m-0" style="font-size: 20px !important;font-weight: bold">
                                        <img height="50px"
                                             src="{{ asset('img/logo.png') }}"
                                             alt="">
                                        {{ config('app.full_name') }}
                                    </h1>
                                    <h3 class="text-center m-0 mb-2" style="font-size: 19px !important;">চেক রেজিস্টার</h3>
                                    <h3 class="text-center m-0 mb-2" style="font-size: 19px !important;">আর্থিক
                                        বছরঃ {{ enNumberToBn(request('financial_year')) }}</h3>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <p>তারিখঃ {{ enNumberToBn(\Carbon\Carbon::parse(request('start_date'))->format('d/m/Y')) }}
                                    - {{ enNumberToBn(\Carbon\Carbon::parse(request('end_date'))->format('d/m/Y')) }}</p>

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>তারিখ</th>
                                            <th>উপাংশ</th>
                                            <th>প্রাপক</th>
                                            <th>খাত</th>
                                            <th>বিবরণ</th>
                                            <th>চেক নং</th>
                                            <th>ভাউচার নং</th>
                                            <th>হিসাব নং</th>
                                            <th>ব্যাংক</th>
                                            <th>টাকা</th>
                                            <th>হিঃরঃকঃ</th>
                                            <th>প্রঃনিঃকঃ</th>
                                            <th>মেয়র</th>
                                            <th class="extra_column"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($expenses as $expense)
                                        <tr>
                                            <td>
                                                <input type="hidden" name="incoexpenses_id[]"
                                                       value="{{ $expense->incoexpenses_id }}">
                                                {{ enNumberToBn(\Carbon\Carbon::parse($expense->receive_datwe)->format('d-m-Y')) }}
                                            </td>
                                            <td>{{ $expense->upangsho->upangsho_name ?? '' }}</td>
                                            <td>{{ $expense->receiver_name }}</td>
                                            <td class="text-left">{{ $expense->sector->khat_name ?? ''  }}</td>
                                            <td class="text-left">{{ $expense->khat_des  }}</td>
                                            <td>{{ enNumberToBn($expense->check_no)  }}</td>
                                            <td>{{ enNumberToBn($expense->vourcher_no)  }}</td>
                                            <td>{{ enNumberToBn($expense->bankAccount->acc_no ?? '')  }}</td>
                                            <td>{{ $expense->bank->bank_name ?? ''  }}</td>
                                            <td>{{ enNumberToBn(number_format($expense->amount,2))  }}</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            @if($expense->khat_des == '-ঐ-কাজের মূঃসঃক' || $expense->khat_des == 'ঐ-কাজের আয়কর'  ||  $expense->khat_des == '-ঐ-কাজের জামানত')
                                                <td class="extra_column">
                                                    <a target="_blank" href="{{ route('cheque_register.cheque_print',['incomeExpense'=>$expense->incoexpenses_id]) }}" class="btn btn-primary bg-gradient-primary btn-sm">চেক <i class="fa fa-print"></i></a>
                                                </td>
                                            @else
                                                <td class="extra_column">
                                                    <a target="_blank" href="{{ route('cheque_register.cheque_print',['incomeExpense'=>$expense->incoexpenses_id]) }}" class="btn btn-primary bg-gradient-primary btn-sm">চেক <i class="fa fa-print"></i></a>
                                                    <a target="_blank" href="{{ route('challan_print',['incomeExpense'=>$expense->incoexpenses_id]) }}" class="btn btn-primary bg-gradient-primary btn-sm">চালান <i class="fa fa-print"></i></a>
                                                    <a class="btn btn-success bg-gradient-success btn-sm check-register-allow" data-id="{{ $expense->incoexpenses_id }}" role="button">অনুমতি দিন</a>
                                                    <a data-id="{{ $expense->incoexpenses_id }}" class="btn btn-warning bg-gradient-warning btn-sm text-white cheque-register-edit" role="button"><i class="fa fa-edit"></i></a>
                                                    @if($expense->inout_id == "2")
                                                        <a class="btn btn-info bg-gradient-info btn-sm"
                                                           href="{{ route('cheque_register.print',['incomeExpense'=>$expense->incoexpenses_id]) }}"
                                                           target="_blank"><i class="fa fa-info-circle"></i></a>
                                                    @endif
                                                    <a class="btn btn-danger bg-gradient-danger btn-sm check-register-delete" data-id="{{ $expense->incoexpenses_id }}"><i class="fa fa-trash"></i></a>

                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </form>
    @else
        @if(request('start_date') != '')
            <div class="alert alert-warning text-center"><h4>কোনো তথ্য পাওয়া যায়নি !</h4></div>
        @endif
    @endif
    <div class="modal fade" id="modal-cheque-register" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg  modal-dialog-centered modal-dialog-scrollable" >
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">আয়/ব্যয় সংযুক্তি হালনাগাদ</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="myForm" method="POST" action="{{ route('cheque_register.update') }}">
                        @csrf
                        <input type="hidden" id="income_expense_id" name="income_expense_id">
                        <div class="form-group row" id="description_group">
                            <label for="description" class="col-sm-3 col-form-label">খাতের বিবরন <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="description" class="form-control"
                                       id="description" placeholder="খাতের বিবরন লিখুন">
                                <span class="help-block" id="description_error"></span>
                            </div>
                        </div>
                        <div class="form-group row " id="voucher_no_group">
                            <label for="voucher_no" class="col-sm-3 col-form-label">ভাউচার/ চালান নম্বর <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="voucher_no" class="form-control"
                                       id="voucher_no" placeholder="ভাউচার/ চালান নম্বর লিখুন">
                                <span class="help-block" id="voucher_no_error"></span>
                            </div>
                        </div>
                        <div class="form-group row" id="cheque_no_group">
                            <label for="cheque_no" class="col-sm-3 col-form-label">চেক নম্বর <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="cheque_no" class="form-control"
                                       id="cheque_no" placeholder="চেক নম্বর লিখুন">
                                <span class="help-block" id="cheque_no_error"></span>
                            </div>
                        </div>
                        <div class="form-group row" id="amount_group">
                            <label for="amount" class="col-sm-3 col-form-label">টাকা <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="amount" class="form-control"
                                       id="amount" placeholder="টাকার পরিমাণ লিখুন">
                                <span class="help-block" id="amount_error"></span>
                            </div>
                        </div>
                        <div class="form-group row" id="cheque_amount_group">
                            <label for="cheque_amount" class="col-sm-3 col-form-label">চেকের টাকা</label>
                            <div class="col-sm-9">
                                <input type="text" name="cheque_amount" class="form-control"
                                       id="cheque_amount" placeholder="চেকের টাকার পরিমাণ লিখুন">
                                <span class="help-block" id="cheque_amount_error"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9 offset-md-3 col-12">
                                <div class="table-responsive-sm">
                                    <table class="table table-bordered table-bordered-modal">
                                        <tr>
                                            <td>
                                                <div class="form-group" id="vat_group">
                                                    <label for="vat">ভ্যাটের টাকা</label>
                                                    <input type="text" name="vat" class="form-control"
                                                           id="vat" placeholder="ভ্যাটের টাকার পরিমাণ">
                                                    <span class="help-block" id="vat_error"></span>

                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group" id="vat_voucher_no_group">
                                                    <label for="vat_voucher_no">ভাউচার নম্বর/চালান</label>
                                                    <input type="text" name="vat_voucher_no" class="form-control"
                                                           id="vat_voucher_no" placeholder="ভাউচার নম্বর/চালান">
                                                    <span class="help-block" id="vat_voucher_no_error"></span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group" id="vat_cheque_no_group">
                                                    <label for="vat_cheque_no">চেক নম্বর</label>
                                                    <input type="text" name="vat_cheque_no" class="form-control"
                                                           id="vat_cheque_no" placeholder="চেক নম্বর">
                                                    <span class="help-block" id="vat_cheque_no_error"></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-group" id="tax_group">
                                                    <label for="tax">আয়করের টাকা</label>
                                                    <input type="text" name="tax" class="form-control"
                                                           id="tax" placeholder="আয়করের টাকার পরিমাণ">
                                                    <span class="help-block" id="tax_error"></span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group" id="tax_voucher_no_group">
                                                    <label for="tax_voucher_no">ভাউচার নম্বর/চালান</label>
                                                    <input type="text" name="tax_voucher_no" class="form-control"
                                                           id="tax_voucher_no" placeholder="ভাউচার নম্বর/চালান">
                                                    <span class="help-block" id="tax_voucher_no_error"></span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group" id="tax_cheque_no_group">
                                                    <label for="tax_cheque_no">চেক নম্বর</label>
                                                    <input type="text"  name="tax_cheque_no" class="form-control"
                                                           id="tax_cheque_no" placeholder="চেক নম্বর">
                                                    <span class="help-block" id="tax_cheque_no_error"></span>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row" id="receiver_name_group">
                            <label for="receiver_name" class="col-sm-3 col-form-label">প্রাপকের নাম</label>
                            <div class="col-sm-9">
                                <input type="text" name="receiver_name" class="form-control"
                                       id="receiver_name" placeholder="প্রাপকের নাম">
                                <span class="help-block" id="receiver_name_error"></span>

                            </div>
                        </div>
                        <div class="form-group row" id="date_group">
                            <label for="date" class="col-sm-3 col-form-label">প্রাপ্তি/ প্রদান তারিখ <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" readonly autocomplete="off"  name="date" class="form-control date-picker"
                                       id="date" placeholder="প্রাপ্তি/ প্রদান তারিখ">
                                <span class="help-block" id="date_error"></span>
                            </div>
                        </div>
                        <div class="form-group row" id="note_group">
                            <label for="note" class="col-sm-3 col-form-label">মন্তব্য</label>
                            <div class="col-sm-9">
                                <input type="text"  name="note" class="form-control"
                                       id="note" placeholder="মন্তব্য লিখুন">
                                <span class="help-block" id="note_error"></span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">বন্ধ</button>
                    <button type="submit" id="submitForm" class="btn btn-primary">সংরক্ষণ</button>
                </div>
            </div>

        </div>

    </div>
@endsection
@section('script')
    <script>
        $(function (){

            $('body').on('click', '.cheque-register-edit', function () {
                let incomeExpenseId = $(this).data('id');
                if(incomeExpenseId != ''){
                    $.ajax({
                        method: "Post",
                        url: "{{ route('cheque_register.details') }}",
                        data: { incomeExpenseId: incomeExpenseId }
                    }).done(function( response ) {
                        $('input[name="income_expense_id"]').val(response.incomeExpense.incoexpenses_id);
                        $('input[name="amount"]').val(response.incomeExpense.amount);
                        $('input[name="cheque_amount"]').val(response.incomeExpense.cheque_amount);
                        $('input[name="description"]').val(response.incomeExpense.khat_des);
                        $('input[name="receiver_name"]').val(response.incomeExpense.receiver_name);
                        var originalDate = response.incomeExpense.receive_date;
                        var formattedDate = moment(originalDate).format('DD-MM-YYYY');
                        $('input[name="date"]').val(formattedDate);
                        $('input[name="voucher_no"]').val(response.incomeExpense.vourcher_no);
                        $('input[name="cheque_no"]').val(response.incomeExpense.check_no);
                        $('input[name="note"]').val(response.incomeExpense.note);

                        if(response.vat){
                            $('input[name="vat"]').val(response.vat.amount);
                            $('input[name="vat_voucher_no"]').val(response.vat.vourcher_no);
                            $('input[name="vat_cheque_no"]').val(response.vat.check_no);
                        }
                        if(response.tax){
                            $('input[name="tax"]').val(response.tax.amount);
                            $('input[name="tax_voucher_no"]').val(response.tax.vourcher_no);
                            $('input[name="tax_cheque_no"]').val(response.tax.check_no);
                        }
                    });
                }

                $('#modal-cheque-register').modal('show');
            })
            $('#submitForm').click(function () {
                $.ajax({
                    type: 'POST',
                    url: $('#myForm').attr('action'),
                    data: $('#myForm').serialize(),
                    success: function (response) {
                        // If the form submission is successful
                        // Update the page as desired
                        $('#modal-budget').modal('hide');
                        $(document).Toasts('create', {
                            icon: 'fas fa-envelope fa-lg',
                            class: 'bg-success',
                            title: 'Success',
                            autohide: true,
                            delay: 2000,
                            body: response.success,
                        })
                        location.reload(); // Refresh the page
                    },
                    error: function (xhr) {
                        // If the form submission encounters an error
                        // Display validation errors
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            // Clear previous error messages
                            $('.form-group.row').removeClass('has-error');
                            $('.help-block').text(' ');
                            // Display new error messages
                            if (errors.description) {
                                $('#description_group').addClass('has-error');
                                $('#description_error').text(errors.description[0]);
                            }
                            if (errors.amount) {
                                $('#amount_group').addClass('has-error');
                                $('#amount_error').text(errors.amount[0]);
                            }
                            if (errors.voucher_no) {
                                $('#voucher_no_group').addClass('has-error');
                                $('#voucher_no_error').text(errors.voucher_no[0]);
                            }
                            if (errors.cheque_no) {
                                $('#cheque_no_group').addClass('has-error');
                                $('#cheque_no_error').text(errors.cheque_no[0]);
                            }

                            if (errors.receiver_name) {
                                $('#receiver_name_group').addClass('has-error');
                                $('#receiver_name_error').text(errors.receiver_name[0]);
                            }
                            if (errors.date) {
                                $('#date_group').addClass('has-error');
                                $('#date_error').text(errors.date[0]);
                            }
                            if (errors.note) {
                                $('#note_group').addClass('has-error');
                                $('#note_error').text(errors.note[0]);
                            }
                            if (errors.vat) {
                                $('#vat_group').addClass('has-error');
                                $('#vat_error').text(errors.vat[0]);
                            }
                            if (errors.vat_voucher_no) {
                                $('#vat_voucher_no_group').addClass('has-error');
                                $('#vat_voucher_no_error').text(errors.vat_voucher_no[0]);
                            }
                            if (errors.vat_cheque_no) {
                                $('#vat_cheque_no_group').addClass('has-error');
                                $('#vat_cheque_no_error').text(errors.vat_cheque_no[0]);
                            }
                            if (errors.tax) {
                                $('#tax_group').addClass('has-error');
                                $('#tax_error').text(errors.tax[0]);
                            }
                            if (errors.tax_voucher_no) {
                                $('#tax_voucher_no_group').addClass('has-error');
                                $('#tax_voucher_no_error').text(errors.tax_voucher_no[0]);
                            }
                            if (errors.tax_cheque_no) {
                                $('#tax_cheque_no_group').addClass('has-error');
                                $('#tax_cheque_no_error').text(errors.tax_cheque_no[0]);
                            }
                        }
                    }
                });
            });

            $('body').on('click', '.check-register-allow', function () {
                var incomeExpenseId = $(this).data('id');
                Swal.fire({
                    title: 'আপনি কি নিশ্চিত?',
                    text: "আপনি এটিকে ফিরিয়ে আনতে পারবেন না!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#d33',
                    confirmButtonText:'হ্যাঁ,নিশ্চিত করুন!',
                    cancelButtonText: 'বাতিল',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: "Post",
                            url: "{{ route('cheque_register.allow') }}",
                            data: { incomeExpenseId: incomeExpenseId }
                        }).done(function( response ) {
                            if (response.success) {
                                Swal.fire(
                                    'অনুমোদিত!',
                                    response.message,
                                    'success'
                                ).then((result) => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: response.message,
                                });
                            }
                        });

                    }
                })

            });
            $('body').on('click', '.check-register-delete', function () {
                var incomeExpenseId = $(this).data('id');
                Swal.fire({
                    title: 'আপনি কি নিশ্চিত?',
                    text: "আপনি এটিকে ফিরিয়ে আনতে পারবেন না!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#d33',
                    confirmButtonText:'হ্যাঁ,নিশ্চিত করুন!',
                    cancelButtonText: 'বাতিল',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: "Post",
                            url: "{{ route('cheque_register.delete') }}",
                            data: { incomeExpenseId: incomeExpenseId }
                        }).done(function( response ) {
                            if (response.success) {
                                Swal.fire(
                                    'মুছে ফেলা হয়েছে!',
                                    response.message,
                                    'success'
                                ).then((result) => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: response.message,
                                });
                            }
                        });

                    }
                })

            });
        })
        function allAllowConfirm() {
            Swal.fire({
                title: 'আপনি কি নিশ্চিত?',
                text: "আপনি এটিকে ফিরিয়ে আনতে পারবেন না!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'হ্যাঁ,সব নিশ্চিত করুন!',
                cancelButtonText: 'বাতিল',

            }).then((result) => {
                if (result.isConfirmed) {
                    $('#all_allow_confirm').submit();
                }
            })
        }
        var APP_URL = '{!! url()->full()  !!}';

        function getprint(print) {
            $('.print-heading').css('display','block');
            $('.extra_column').remove();
            $('body').html($('#' + print).html());
            window.print();
            window.location.replace(APP_URL)
        }
    </script>
@endsection
