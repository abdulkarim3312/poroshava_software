@extends('layouts.app')
@section('title','আয়/ব্যয় ব্যবস্থাপন')
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
                <form>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="bank">ব্যাংক </label>
                                    <select name="bank" class="form-control select2" id="bank">
                                        <option value="">ব্যাংক নির্ধারণ</option>
                                        @foreach($banks as $bank)
                                            <option value="{{ $bank->bank_id }}">{{ $bank->bank_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="branch">শাখা</label>
                                    <select name="branch" class="form-control select2" id="branch">
                                        <option value="">শাখা নির্ধারণ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="bank_account">ব্যাংক একাউন্ট নম্বর </label>
                                    <select name="bank_account" class="form-control select2" id="bank_account">
                                        <option value="">ব্যাংক একাউন্ট নম্বর নির্ধারণ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="start_date">শুরুর তারিখ </label>
                                    <input type="text" id="start_date" autocomplete="off"
                                           name="start_date" class="form-control date-picker"
                                           placeholder="শুরুর তারিখ">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="end_date">শেষের তারিখ</label>
                                    <input type="text" id="end_date" autocomplete="off"
                                           name="end_date" class="form-control date-picker"
                                           placeholder="শেষের তারিখ">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="search_amount">অ্যামাউন্ট </label>
                                    <input type="text" id="search_amount" autocomplete="off"
                                           name="search_amount" class="form-control"
                                           placeholder="অ্যামাউন্ট">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <input type="button" id="search" name="search"
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
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-default">
                <div class="card-header">
                    <div class="card-title">আয়/ব্যয় ব্যবস্থাপন</div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table" class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>তারিখ</th>
                                <th>উপাংশ</th>
                                <th>আয়/ব্যায় খাত</th>
                                <th>খাত টাইপ</th>
                                <th>খাত</th>
                                <th>আর্থ বছর</th>
                                <th>ব্যাংক</th>
                                <th>ব্রাঞ্চ</th>
                                <th>অ্যাকাউন্ট নং</th>
                                <th>ব্যাংক জমা</th>
                                <th>টাকা</th>
                                <th class="extra_column">প্রক্রিয়া</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-income-expense" data-backdrop="static" data-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">আয়/ব্যয় সংশোধন</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="myForm" method="POST" action="{{ route('income_expenditure.update') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="fiscal_year">আর্থ বছর</label>
                                    <input type="text" readonly id="fiscal_year" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="sector_name">খাত</label>
                                    <input type="text" readonly id="sector_name" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group" id="amount-group">
                                    <input type="hidden" id="income_expense_id" name="income_expense_id">
                                    <label for="amount">টাকা <span class="text-danger">*</span></label>
                                    <input type="text" id="amount" class="form-control" name="amount"
                                           placeholder="টাকার পরিমাণ লিখুন">
                                    <span class="help-block" id="amount-error"></span>
                                </div>
                                <div class="form-group" id="cheque-amount-group">
                                    <label for="cheque_amount">চেকের টাকা</label>
                                    <input type="text" id="cheque_amount" class="form-control" name="cheque_amount"
                                           placeholder="চেকের টাকার পরিমাণ লিখুন">
                                    <span class="help-block" id="cheque-amount-error"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">বন্ধ</button>
                    <button type="submit" id="submitForm" class="btn btn-primary">হালনাগাদ</button>
                </div>
            </div>

        </div>

    </div>

@endsection

@section('script')
    <script>
        $(function () {
            $("#bank").change(function () {
                let bankId = $(this).val();
                $('#branch').html('<option value="">শাখা নির্ধারণ</option>');
                if (bankId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_branches') }}",
                        data: {bankId: bankId}
                    }).done(function (data) {
                        $.each(data, function (index, item) {
                            $('#branch').append('<option value="' + item.branch_id + '">' + item.branch_name + '</option>');
                        });
                        $('#branch').trigger('change');
                    });
                }
            })
            $('#bank').trigger('change');

            $("#branch").change(function () {
                let branchId = $(this).val();
                $('#bank_account').html('<option value="">ব্যাংক একাউন্ট নম্বর নির্ধারণ</option>');
                if (branchId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_bank_accounts') }}",
                        data: {branchId: branchId, upangshoId: null}
                    }).done(function (data) {
                        $.each(data, function (index, item) {
                            $('#bank_account').append('<option value="' + item.bank_details_id + '">' + item.acc_no + '</option>');
                        });
                    });
                }
            })
            $('#branch').trigger('change');


            $('body').on('click', '.income-expense-edit', function () {
                let incomeExpenseId = $(this).data('id');
                $("#income_expense_id").val(incomeExpenseId);
                $("#amount").val($(this).data('amount'));
                $("#cheque_amount").val($(this).data('cheque-amount'));
                $("#fiscal_year").val($(this).data('fiscal_year'));
                $("#sector_name").val($(this).data('sector_type_name') + ' - ' + $(this).data('sector_name'));
                $('#modal-income-expense').modal('show');
            })
            $('#submitForm').click(function () {
                $.ajax({
                    type: 'POST',
                    url: $('#myForm').attr('action'),
                    data: $('#myForm').serialize(),
                    success: function (response) {
                        $('#modal-income-expense').modal('hide');
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
                            $('#amount-group').removeClass('has-error');
                            $('#amount-error').text(' ');
                            // Display new error messages

                            if (errors.amount) {
                                $('#amount-group').addClass('has-error');
                                $('#amount-error').text(errors.amount[0]);
                            }
                        }
                    }
                });
            });

            $('body').on('click', '.income-expense-delete', function () {
                var incomeExpenseId = $(this).data('id');
                Swal.fire({
                    title: 'আপনি কি নিশ্চিত?',
                    text: "আপনি এটিকে ফিরিয়ে আনতে পারবেন না!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'হ্যাঁ,নিশ্চিত করুন!',
                    cancelButtonText: 'বাতিল',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: "Post",
                            url: "{{ route('income_expenditure.delete') }}",
                            data: {incomeExpenseId: incomeExpenseId}
                        }).done(function (response) {
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

            var table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('income_expenditure.datatable') }}",
                    data: function (d) {
                        d.bank = $('#bank').val()
                        d.branch = $('#branch').val()
                        d.bank_account = $('#bank_account').val()
                        d.start_date = $('#start_date').val()
                        d.end_date = $('#end_date').val()
                        d.search_amount = $('#search_amount').val()
                    }
                },
                columns: [
                    {data: 'incoexpenses_id', name: 'incoexpenses_id', visible: false},
                    {data: 'receive_datwe', name: 'receive_datwe'},
                    {data: 'upangsho_name', name: 'upangsho.upangsho_name'},
                    {data: 'income_expense_type_name', name: 'incomeExpenseType.khat'},
                    {data: 'sector_type_name', name: 'taxType.tax_name'},
                    {
                        data: null,
                        render: function (data, type, row) {
                            return data.sector_serilas_name + ' ' + data.sector_name;
                        }
                    },
                    {data: 'year', name: 'year'},
                    {data: 'bank_name', name: 'bank.bank_name'},
                    {data: 'branch_name', name: 'branch.branch_name'},
                    {data: 'bank_account_no', name: 'bankAccount.acc_no'},
                    {data: 'bank_balance', name: 'bankAccount.update_balance'},
                    {data: 'amount', name: 'amount'},
                    {data: 'action', name: 'action', orderable: false},
                ],
                order: [[0, 'desc']],
                "pagingType": "full_numbers",
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]
                ],
                "dom": 'lBfrtip',
                "buttons": [
                    {
                        "extend": "copy",
                        "text": "<i class='fas fa-copy'></i> Copy",
                        "className": "btn btn-info"
                    }, {
                        "extend": "csv",
                        "text": "<i class='fas fa-file-csv'></i> Export to CSV",
                        "className": "btn btn-warning text-white"
                    },
                    {
                        "extend": "excel",
                        "text": "<i class='fas fa-file-excel'></i> Export to Excel",
                        "className": "btn btn-success"
                    },
                    {
                        "extend": "pdf",
                        "text": "<i class='fas fa-file-pdf'></i> Export to PDF",
                        "className": "btn btn-danger"
                    },
                    {
                        "extend": "print",
                        "text": "<i class='fas fa-print'></i> Print",
                        "className": "btn btn-success bg-gradient-success"
                    }
                ],
            });
            $('#start_date,#end_date, #bank,#branch,#bank_account').change(function () {
                table.ajax.reload();
            });
            $('#search_amount').keyup(function () {
                table.ajax.reload();
            });
            $("#search").click(function (){
                table.ajax.reload();
            })
        })
    </script>
@endsection
