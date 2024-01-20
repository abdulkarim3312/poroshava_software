@extends('layouts.app')
@section('title','ব্যবহারকারী')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-default">
                <div class="card-header">
                    <a href="{{ route('user.add') }}" class="btn btn-success bg-gradient-success">ব্যবহারকারী যুক্ত করুন</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table id="table" class="table table-bordered">
                            <thead>
                            <tr>
                                <th>ক্রমিক</th>
                                <th>নাম</th>
                                <th>মডিউল পারমিশন</th>
                                <th>এক্সেস পারমিশন</th>
                                <th>লগিন ইউজার নাম</th>
                                <th>ইমেইল</th>
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
                ajax: '{{ route('user.datatable') }}',

                "pagingType": "full_numbers",
                "dom": 'T<"clear">lfrtip',
                "lengthMenu": [[10, 25, 50, -1],[10, 25, 50, "All"]
                ],
                columns: [
                    { data: 'DT_RowIndex', 'orderable': false, 'searchable': false },
                    {data: 'name', name: 'name'},
                    {data: 'role', name: 'role'},
                    {data: 'sub_role', name: 'sub_role'},
                    {data: 'username', name: 'username'},
                    {data: 'email', name: 'email'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false},
                ],
                "columnDefs": [
                    {"className": "text-left", "targets": "5"}
                ],
                "responsive": true, "autoWidth": false,
            });
        })
    </script>
@endsection
