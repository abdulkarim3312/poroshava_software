@extends('layouts.app')
@section('title','ট্রেড লাইসেন্স পেন্ডিং তালিকা')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-default">
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table id="table" class="table table-bordered">
                            <thead>
                            <tr>
                                <th>প্রতিষ্ঠানের নাম</th>
                                <th>মালিকের নাম</th>
                                <th>ওয়ার্ড নং</th>
                                <th>মহল্লা/রাস্তা নাম</th>
                                <th>মোবাইল নম্বর</th>
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
                ajax: '{{ route('trade_license_pending_list_datatable') }}',

                "pagingType": "full_numbers",
                "dom": 'T<"clear">lfrtip',
                "lengthMenu": [[10, 25, 50, -1],[10, 25, 50, "All"]
                ],
                columns: [
                    {data: 'organization_name', name: 'organization_name'},
                    {data: 'name', name: 'name'},
                    {data: 'ward_no', name: 'ward_no'},
                    {data: 'road_name', name: 'road_name'},
                    {data: 'mobile_no', name: 'mobile_no'},
                    {data: 'inactive_status', name: 'inactive_status'},
                    {data: 'action', name: 'action', orderable: false},
                ],
                "columnDefs": [
                    {"className": "text-left", "targets": "5"}
                ],
                "responsive": false, "autoWidth": false,
            });
        })
    </script>
@endsection
