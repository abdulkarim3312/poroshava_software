@extends('layouts.app')
@section('title','উপ খাত টাইপ')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-default">
                <div class="card-header">
                    <a href="{{ route('sub_sector_type.create') }}" class="btn btn-success bg-gradient-success">উপ খাত টাইপ যুক্ত করুন</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table id="table" class="table table-bordered">
                            <thead>
                            <tr>
                                <th>উপাংশ</th>
                                <th>আয়/ব্যয় খাত</th>
                                <th>খাত টাইপ</th>
                                <th>ক্রমিক</th>
                                <th>উপ খাত টাইপ</th>
                                <th>স্ট্যাটাস</th>
                                <th>অ্যাকশন</th>
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
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('sub_sector_type.datatable') }}',
                columns: [
                    {data: 'upangsho_name', name: 'upangsho.upangsho_name'},
                    {data: 'khat_id', name: 'khat_id'},
                    {data: 'sector_type_name', name: 'taxType.tax_name'},
                    {data: 'serialise', name: 'serialise'},
                    {data: 'tax_name2', name: 'tax_name2'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false},
                ],
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
        })
    </script>
@endsection
