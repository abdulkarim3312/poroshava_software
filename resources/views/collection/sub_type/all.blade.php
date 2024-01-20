@extends('layouts.app')
@section('title','উপ খাত সমূহের তালিকা')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-default">
            <div class="card-header">
                <a href="{{ route('collection_sub_type.add') }}" class="btn btn-success bg-gradient-success">উপ খাত যুক্ত করুন</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table id="table" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>ক্রমিক</th>
                        <th>খাতের নাম</th>
                        <th>উপ খাতের নাম</th>
                        <th>ফি</th>
                        <th>অবস্থা</th>
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
                ajax: '{{ route('collection_sub_type.datatable') }}',
                columns: [
                    { data: 'DT_RowIndex', 'orderable': false, 'searchable': false },
                    {data: 'type.name', name: 'type.name'},
                    {data: 'name', name: 'name'},
                    {data: 'fees', name: 'fees'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false},
                ],
                "responsive": true, "autoWidth": false,
            });
        });
    </script>
@endsection
