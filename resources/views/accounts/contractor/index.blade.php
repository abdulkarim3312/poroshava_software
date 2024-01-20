@extends('layouts.app')
@section('title','ঠিকাদার হালনাগাদ')
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
                                <th>আইডি নং </th>
                                <th>ছবি </th>
                                <th>ঠিকাদারের নাম</th>
                                <th>প্রোপ্রাইটর নাম</th>
                                <th>মোবাইল / যোগাযোগ নং</th>
                                <th>ঠিকানা </th>
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

@endsection
@section('script')
    <script>
        $(function () {

            var table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('contractor.datatable') }}",
                },
                columns: [
                    {data: 'emp_id', name: 'emp_id'},
                    {data: 'photo', name: 'photo'},
                    {data: 'name', name: 'name'},
                    {data: 'fname', name: 'fname'},
                    {data: 'mob', name: 'mob'},
                    {data: 'salaryaccno', name: 'salaryaccno'},
                    {data: 'action', name: 'action', orderable: false},
                ],
                order: [[0, 'asc']],
                "pagingType": "full_numbers",
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]
                ],
                "columnDefs": [
                    { className: "extra_column", "targets": [ 6 ] }
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
