@extends('layouts.app')
@section('title')
    ঋণ গ্রহীতা
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-primary" href="{{ route('borrower.add') }}">ঋণ গ্রহীতা যুক্তকরন</a>
                </div>
                <div class="card-body">
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>আইডি</th>
                            <th>নাম</th>
                            <th>কমিউনিটি / এলাকা</th>
                            <th>দলের নাম</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($borrowers as $borrower)
                            <tr>
                                <td>{{ $borrower->member_id }}</td>
                                <td>{{ $borrower->name }}</td>
                                <td>{{ $borrower->area->community }}</td>
                                <td>{{ $borrower->team->name }}</td>
                                <td>
                                    <a class="btn btn-info btn-sm" href="{{ route('borrower.edit', ['borrower' => $borrower->id]) }}">পরিবর্তন</a>
                                    <a class="btn btn-primary btn-sm" href="{{ route('borrower.details', ['borrower' => $borrower->id]) }}">বিস্তারিত</a>
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
        });
    </script>
@endsection
