@extends('layouts.app')

@section('title')
    এলাকা
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-success bg-gradient-success" href="{{ route('area.add') }}">এলাকা যুক্তকরন</a>

                </div>
                <div class="card-body">
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>কমিউনিটি / এলাকা</th>
                            <th>এস আই সি  সভাপতি</th>
                            <th>পরিচ্ছন্ন কর্মী সংখ্যা</th>
                            <th>অ্যাকশন</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($areas as $area)
                            <tr>
                                <td>
                                    @if ($area->cleaners->count() > 0)
                                        <a  href="{{ route('cleaner',['area'=>$area->id]) }}">{{ $area->community }}</a>
                                    @else
                                        {{ $area->community }}
                                    @endif

                                </td>
                                <td>{{ $area->president }}</td>
                                <td>
                                    @if ($area->cleaners->count() > 0)
                                    <a class="label label-info" href="{{ route('cleaner',['area'=>$area->id]) }}">{{ $area->cleaners->count() }}</a>
                                    @else
                                        <span class="label label-danger">{{ $area->cleaners->count() }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-success bg-gradient-success btn-sm" href="{{ route('area.edit', ['area' => $area->id]) }}">হালনাগাদ</a>

                                    @if ($area->cleaners->count() > 0)
                                    <a class="btn btn-success bg-gradient-success btn-sm" href="{{ route('cleaner',['area'=>$area->id]) }}">বিস্তারিত</a>

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
