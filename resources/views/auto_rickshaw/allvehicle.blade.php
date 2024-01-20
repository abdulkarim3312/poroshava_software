@extends('layouts.app')
@section('title','সকল যানবাহন চালকের লাইসেন্স')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <section class="card">
                <header class="card-header">
                    <h3 class="card-title">সকল যানবাহন চালকের লাইসেন্স</h3>
                </header>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="table">
                                <thead>
                                <tr>
                                    <th>ক্রমিক নং</th>
                                    <th>ধরন</th>
                                    <th>অর্থ বছর</th>
                                    <th>নাম</th>
                                    <th>পিতার নাম</th>
                                    <th>ঠিকানা</th>
                                    <th>লাইসেন্স নং</th>
                                    <th>রিসিভ নং</th>
                                    <th>ডেলিভারি তারিখ</th>
                                    <th>প্রক্রিয়া</th>
                                </tr>
                                </thead>
                            </table>
                        </div>

                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function (){
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('auto_rickshaw.vehicle_license_datatable') }}',
                columns: [
                    {data: 'slno', name: 'slno'},
                    {data: 'type.name', name: 'type.name'},
                    {data: 'year', name: 'year'},
                    {data: 'name', name: 'name'},
                    {data: 'fname', name: 'fname'},
                    {data: 'address', name: 'address'},
                    {data: 'licenseno', name: 'licenseno'},
                    {data: 'taka_receive_no', name: 'taka_receive_no'},
                    {data: 'delivery_date', name: 'delivery_date'},
                    {data: 'action', name: 'action', orderable: false},
                ],
                order: [[ 0, "desc" ]],
            });
        });
    </script>
@endsection
