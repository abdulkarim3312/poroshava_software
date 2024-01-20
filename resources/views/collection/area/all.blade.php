@extends('layouts.app')
@section('title','মহল্লা সমূহের তালিকা')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-default">
            <div class="card-header">
                <a href="{{ route('collection_area.add') }}" class="btn btn-success bg-gradient-success">মহল্লা যুক্ত করুন</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table id="table" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>ক্রমিক</th>
                        <th>মহল্লার নাম</th>
                        <th>মহল্লার কোড</th>
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
                ajax: '{{ route('collection_area.datatable') }}',
                columns: [
                    { data: 'DT_RowIndex', 'orderable': false, 'searchable': false },
                    {data: 'area_name', name: 'area_name'},
                    {data: 'area_code', name: 'area_code'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false},
                ],
                "responsive": true, "autoWidth": false,
            });
        });
    </script>
@endsection
