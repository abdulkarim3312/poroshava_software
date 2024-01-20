@extends('layouts.app')

@section('title')
    হোল্ডিং ব্যবহারের ধরন তথ্য
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-success bg-gradient-success" href="{{ route('holding.use_type.add') }}">হোল্ডিং ব্যবহারের ধরন যুক্তকরন</a>

                </div>
                <div class="card-body">
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ক্রমিক নং</th>
                            <th>হোল্ডিং ব্যবহারের ধরন</th>
                            <th>অ্যাকশন</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($holdingUseTypes as $index => $data)
                            <tr>
                                <td>
                                   {{ $index+1 }}
                                </td>
                                <td>{{ $data->name }}</td>
                                <td>
                                    <a class="btn btn-success bg-gradient-success btn-sm" href="{{ route('holding.use_type.edit', ['holdingUseType' => $data->id]) }}">হালনাগাদ</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function () {
            $('#table').DataTable();
        })
    </script>
@endsection
