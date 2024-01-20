@extends('layouts.app')

@section('title')
    হোল্ডিং স্থাপনার ধরন
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-success bg-gradient-success" href="{{ route('holding.structure_type.add') }}">হোল্ডিং স্থাপনার ধরন যুক্তকরন</a>

                </div>
                <div class="card-body">
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ক্রমিক নং</th>
                            <th>হোল্ডিং স্থাপনার ধরন</th>
                            <th>অ্যাকশন</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($structureTypes as $index => $data)
                            <tr>
                                <td>
                                   {{ $index+1 }}
                                </td>
                                <td>{{ $data->name }}</td>
                                <td>
                                    <a class="btn btn-success bg-gradient-success btn-sm" href="{{ route('holding.structure_type.edit', ['structureType' => $data->id]) }}">হালনাগাদ</a>
                                    <a class="btn btn-danger bg-gradient-danger btn-sm structureTypeDelete" data-id="{{ $data->id }}" href="#">ডিলিট</a>
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
            $('body').on('click', '.structureTypeDelete', function (e) {
                e.preventDefault();
                let structureTypeId = $(this).data('id');
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
                            url: "{{ route('holding.structure_type.delete') }}",
                            data: { structureTypeId: structureTypeId }
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
