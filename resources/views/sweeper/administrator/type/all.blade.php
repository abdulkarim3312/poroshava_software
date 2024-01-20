@extends('layouts.app')
@section('title')
    ধরণ
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-success bg-gradient-success" href="{{ route('type.add') }}">ধরণ যুক্তকরন</a>

                </div>
                <div class="card-body">
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ধরণ</th>
                            <th>পরিচ্ছন্ন কর্মী সংখ্যা</th>
                            <th>অ্যাকশন</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($types as $type)
                            <tr>
                                <td>
                                    @if ($type->cleaners->count() > 0)
                                        <a  href="{{ route('cleaner',['type'=>$type->id]) }}">{{ $type->name }}</a>
                                    @else
                                        {{ $type->name }}
                                    @endif

                                </td>
                                <td>
                                    @if ($type->cleaners->count() > 0)
                                        <a class="label label-info" href="{{ route('cleaner',['type'=>$type->id]) }}">{{ $type->cleaners->count() }}</a>
                                    @else
                                        <span class="label label-danger">{{ $type->cleaners->count() }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-success bg-gradient-success btn-sm" href="{{ route('type.edit', ['type' => $type->id]) }}">হালনাগাদ</a>
                                    @if ($type->cleaners->count() > 0)
                                        <a class="btn btn-success bg-gradient-success btn-sm" href="{{ route('cleaner',['type'=>$type->id]) }}">বিস্তারিত</a>

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
