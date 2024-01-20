@extends('layouts.app')

@section('title')
    পরিচ্ছন্ন কর্মী হালনাগাদ
@endsection

@section('content')


    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <a class="btn btn-success bg-gradient-success" href="{{ route('cleaner.add') }}">পরিচ্ছন্ন কর্মী যুক্তকরন</a>
                    <input type="hidden" id="area" value="{{ request()->get('area') }}">
                    <input type="hidden" id="team" value="{{ request()->get('team') }}">
                    <input type="hidden" id="type" value="{{ request()->get('type') }}">
                    <hr>

                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ছবি</th>
                            <th>আইডি</th>
                            <th>নাম</th>
                            <th>এলাকা</th>
                            <th>দল</th>
                            <th>ধরণ</th>
                            <th>মোবাইল নম্বর</th>
                            <th>অবস্থান</th>
                            <th>অ্যাকশন</th>
                        </tr>
                        </thead>
                    </table>
                </div>
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
                ajax: {
                    url: "{{ route('cleaner_datatable') }}",
                    data: function (d) {
                        d.area = $('#area').val()
                        d.team = $('#team').val()
                        d.type = $('#type').val()
                    },
                },
                columns: [
                    {data: 'photo', name: 'photo', orderable: false},
                    {data: 'cleaner_id', name: 'cleaner_id'},
                    {data: 'name', name: 'name'},
                    {data: 'area', name: 'area'},
                    {data: 'team', name: 'team'},
                    {data: 'type', name: 'type'},
                    {data: 'mobile_no', name: 'mobile_no'},
                    {data: 'status', name: 'status', orderable: false},
                    {data: 'action', name: 'action', orderable: false},
                ],
                order: [[ 1, "asc" ]],
            });

        })
    </script>
@endsection
