@extends('layouts.app')

@section('title')
    হোল্ডিং মালিকানার ধরন তথ্য
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-success bg-gradient-success" href="{{ route('holding.holding_category.add') }}">হোল্ডিং মালিকানার ধরন যুক্তকরন</a>

                </div>
                <div class="card-body">
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ক্রমিক নং</th>
                            <th>মালিকানার ধরন</th>
                            <th>কর যোগ্য</th>
                            <th>করের হার</th>
                            <th>অ্যাকশন</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($holdingCategories as $index => $data)
                            <tr>
                                <td>
                                   {{ $index+1 }}
                                </td>
                                <td>{{ $data->name }}</td>
                                <td>
                                    @if ($data->taxable == 1)
                                    <span class="badge badge-success">হ্যা</span>
                                    @else
                                   <span class="badge badge-danger">না</span>
                                   @endif
                                </td>
                                <td>{{ $data->tax_rate }}%</td>
                                <td>
                                    <a class="btn btn-success bg-gradient-success btn-sm" href="{{ route('holding.holding_category.edit', ['holdingCategory' => $data->id]) }}">হালনাগাদ</a>
                                    <a class="btn btn-danger bg-gradient-danger btn-sm holdingCategory" data-id="{{ $data->id }}" href="#">ডিলিট</a>
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
            $('body').on('click', '.holdingCategory', function (e) {
                e.preventDefault();
                let holdingCategoryId = $(this).data('id');
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
                            url: "{{ route('holding.holding_category.delete') }}",
                            data: { holdingCategoryId: holdingCategoryId }
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
