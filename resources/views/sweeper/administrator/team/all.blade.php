@extends('layouts.app')
@section('title')
    দল
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-success bg-gradient-success" href="{{ route('team.add') }}">দল যুক্তকরন</a>
                </div>
                <div class="card-body">
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>দল নং</th>
                            <th>দলের নাম</th>
                            <th>দল নেতার নাম</th>
                            <th>কমিউনিটি / এলাকা</th>
                            <th>পরিচ্ছন্ন কর্মী সংখ্যা</th>
                            <th>অ্যাকশন</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($teams as $team)
                            <tr>
                                <td>{{ $team->team_no }}</td>
                                <td>
                                    @if ($team->cleaners->count() > 0)
                                        <a  href="{{ route('cleaner',['team'=>$team->id]) }}"> {{ $team->name }}</a>
                                    @else
                                        {{ $team->name }}
                                    @endif

                                </td>
                                <td>{{ $team->leader }}</td>
                                <td>{{ $team->area->community }}</td>
                                <td>
                                    @if ($team->cleaners->count() > 0)
                                        <a class="label label-info" href="{{ route('cleaner',['team'=>$team->id]) }}">{{ $team->cleaners->count() }}</a>
                                    @else
                                        <span class="label label-danger">{{ $team->cleaners->count() }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-success bg-gradient-success btn-sm" href="{{ route('team.edit', ['team' => $team->id]) }}">হালনাগাদ</a>
                                    @if ($team->cleaners->count() > 0)
                                        <a class="btn btn-success bg-gradient-success btn-sm" href="{{ route('cleaner',['team'=>$team->id]) }}">বিস্তারিত</a>

                                    @endif
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
