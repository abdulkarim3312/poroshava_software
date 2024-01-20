@extends('layouts.app')
@section('title','কর্মচারী লোন রিপোট')
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
                                <th>আইডি নং</th>
                                <th>কর্মকর্তা/কর্মচারী নাম ও বেতন স্কেল</th>
                                <th>পদবি</th>
                                <th>লোনের ধরণ</th>
                                <th>লোনের তারিখ</th>
                                <th>লোনের পরিমান</th>
                                <th>পরিশোধের পরিমাণ</th>
                                <th>অবশিষ্ট লোন</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>


@endsection
@section('script')
    <script>
        $(function () {

            var table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('loan.datatable') }}",
                },
                columns: [
                    {data: 'employee_id_no', name: 'employee_id_no'},
                    {
                        data: null,
                        render: function (data, type, row) {
                            return data.employee_name + ' ' + data.employee_salary_scale;
                        }
                    },
                    {data: 'employee_designation_name', name: 'employee.designation'},
                    {data: 'loan_type_name', name: 'loanType.name'},
                    {data: 'date', name: 'date'},
                    {data: 'amount', name: 'amount'},
                    {data: 'loan_paid', name: 'loan_paid'},
                    {data: 'due_paid', name: 'due_paid'},
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
