@extends('layouts.app')
@section('title','করদাতা ')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="" method="get">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>মহল্লা</label>

                                    <select class="form-control select2 select2-hidden-accessible" name="area" id="area">
                                        <option value="0">সকল মহল্লা</option>
                                        @foreach($holdingAreas as $area)
                                            <option value="{{ $area->id }}" {{ request()->get('area')==$area->id?'selected':'' }}  >{{ $area->road_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>করদাতার নাম</label>
                                    <input type="text" class="form-control" placeholder="করদাতার নাম" name="name" value="{{ request()->get('name') }}">
                                </div>
                            </div>

                            <div class="col-md-3 pull-right">
                                <div class="form-group">
                                    <label>	&nbsp;</label>

                                    <input class="btn btn-success bg-gradient-success form-control" type="submit" value="সার্চ">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card card-outline card-default">
                <div class="card-header">
                    <a href="{{ route('holding.tax_payer.add') }}" class="btn btn-success bg-gradient-success">করদাতা  যুক্ত করুন</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table id="table" class="table table-bordered table-responsive">
                            <thead>
                            <tr>
                                <th>হোল্ডিং নং</th>
                                <th style="width:15%">করদাতার আইডি</th>
                                <th>নাম</th>
                                <th>পিতা/স্বামীর নাম</th>
                                <th>মাতার নাম</th>
                                <th>ওয়ার্ড নং</th>
                                <th>মহল্লা/রাস্তা নাম</th>
                                <th>মোবাইল নম্বর</th>
                                <th>ই-মেইল</th>
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
                ajax: '{{ route('holding_tax_payer_datatable',['area'=>request()->get('area')??'0','name'=>request()->get('name')??'0']) }}',

                "pagingType": "full_numbers",
                "dom": 'T<"clear">lfrtip',
                "lengthMenu": [[10, 25, 50, -1],[10, 25, 50, "All"]
                ],
                columns: [
                    {data: 'holding_no', name: 'holding_no'},
                    {data: 'client_no', name: 'client_no'},
                    {data: 'name', name: 'name'},
                    {data: 'father_husband_name', name: 'father_husband_name'},
                    {data: 'mother_name', name: 'mother_name'},
                    {data: 'ward_no', name: 'ward_no'},
                    {data: 'holding_name', name: 'holding_name'},
                    {data: 'contact_no', name: 'contact_no'},
                    {data: 'email', name: 'email'},
                    {data: 'status', name: 'status'},
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
