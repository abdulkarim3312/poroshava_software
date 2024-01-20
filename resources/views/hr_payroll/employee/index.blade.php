@extends('layouts.app')
@section('title','কর্মচারী হালনাগাদ')
@section('style')
    <style>
        @media print {
            .table-bordered td, .table-bordered th {
                border: 1px solid #000000 !important;
            }
            table.dataTable>thead .sorting:before, table.dataTable>thead .sorting:after, table.dataTable>thead .sorting_asc:before, table.dataTable>thead .sorting_asc:after, table.dataTable>thead .sorting_desc:before, table.dataTable>thead .sorting_desc:after, table.dataTable>thead .sorting_asc_disabled:before, table.dataTable>thead .sorting_asc_disabled:after, table.dataTable>thead .sorting_desc_disabled:before, table.dataTable>thead .sorting_desc_disabled:after {
                display: none;
            }
            @page {
                size: auto;
                margin: 15px 20px !important;
            }
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-default">
                <div class="card-header">
                    <a href="#" onclick="getprint('printArea')"
                       class="btn btn-success bg-gradient-success btn-sm"><i
                            class="fa fa-print"></i></a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive-sm" id="printArea">
                        <table id="table" class="table table-bordered">
                            <thead>
                            <tr>
                                <th class="text-center">আইডি নং </th>
                                <th class="text-center">ছবি </th>
                                <th class="text-center">বিভাগ  </th>
                                <th class="text-center">পদবি</th>
                                <th class="text-center">নাম</th>
                                <th class="text-center">যোগদানের তারিখ</th>
                                <th class="text-center">মোবাইল নং</th>
                                <th class="text-center">বেতন হিসাব নং</th>
                                <th class="extra_column text-center">প্রক্রিয়া</th>
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


            $('body').on('click', '.income-expense-edit', function () {
                let incomeExpenseId = $(this).data('id');
                $("#income_expense_id").val(incomeExpenseId);
                $("#amount").val($(this).data('amount'));
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
                    url: "{{ route('employee.datatable') }}",
                },
                columns: [
                    {data: 'emp_id', name: 'emp_id'},
                    {data: 'photo', name: 'photo'},
                    {data: 'department_name', name: 'department.name'},
                    {data: 'designation', name: 'designation'},
                    {data: 'name', name: 'name'},
                    {data: 'joindate', name: 'joindate'},
                    {data: 'mob', name: 'mob'},
                    {data: 'salaryaccno', name: 'salaryaccno'},
                    {data: 'action', name: 'action', orderable: false},
                ],
                order: [[0, 'asc']],
                "pagingType": "full_numbers",
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]
                ],
                "columnDefs": [
                    { className: "extra_column", "targets": [ 8 ] }
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
                "responsive": true, "autoWidth": false,
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
        var APP_URL = '{!! url()->full()  !!}';
        function getprint(print) {
            $('.print-heading').css('display', 'block');
            $('.extra_column').remove();
            $('#table_length').remove();
            $('#table_filter').remove();
            $('.dt-buttons').remove();
          //  $('.sorting').remove();
            $('#table_info').remove();
            $('#table_paginate').remove();
            $('.bankdetailsaction').remove();
            $('body').html($('#' + print).html());
            window.print();
            window.location.replace(APP_URL)
        }

    </script>
@endsection
