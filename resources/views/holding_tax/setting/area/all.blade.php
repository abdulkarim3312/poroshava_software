@extends('layouts.app')

@section('title')
    এলাকা
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-success bg-gradient-success" href="{{ route('holding.area.add') }}">এলাকা যুক্তকরন</a>

                </div>
                <div class="card-body">
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ক্রমিক</th>
                            <th>মহল্লা নং</th>
                            <th>মহল্লা নাম</th>
                            <th>ওয়ার্ড</th>
                            <th>অ্যাকশন</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($areas as $index => $area)
                            <tr>
                                <td>
                                   {{ $index+1 }}
                                </td>
                                <td>{{ $area->road_no }}</td>
                                <td>
                                    {{ $area->road_name }}
                                </td>
                                <td>
                                    {{ $area->ward_id }}
                                </td>
                                <td>
                                    <a class="btn btn-success bg-gradient-success btn-sm" href="{{ route('holding.area.edit', ['area' => $area->id]) }}">হালনাগাদ</a>
                                    <a class="btn btn-danger bg-gradient-danger btn-sm areaDelete" data-id="{{ $area->id }}" href="#">ডিলিট</a>
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

            $('body').on('click', '.areaDelete', function (e) {
                e.preventDefault();
                let areaId = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure to save?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#343a40',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Save It!'

                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: "POST",
                            url: "{{ route('holding.area.delete') }}",
                            data: { areaId: areaId }
                        }).done(function(response) {
                            if(response.success){
                                Swal.fire(
                                    'Deleted',
                                    response.message,
                                    'success'
                                ).then((result)=>{
                                    location.reload();
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: response.message
                                })
                            }
                        });
                    }
                })

            });
        })
    </script>
@endsection
