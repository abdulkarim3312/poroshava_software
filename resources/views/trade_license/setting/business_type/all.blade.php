@extends('layouts.app')

@section('title')
    ব্যবসার ধরন তথ্য
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-success bg-gradient-success" href="{{ route('trade_license_business_type_add') }}">ব্যবসার ধরন যুক্তকরন</a>

                </div>
                <div class="card-body">
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ক্রমিক নং</th>
                            <th>ব্যবসার ধরন</th>
                            <th>লাইসেন্স ফি</th>
                            <th>অ্যাকশন</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($businessTypes as $index => $data)
                            <tr>
                                <td>
                                   {{ $index+1 }}
                                </td>
                                <td>{{ $data->business_type }}</td>
                                <td>{{ enNumberToBn($data->type_rate) }}</td>
                                <td width="18%">
                                    <a class="btn btn-success bg-gradient-success btn-sm" href="{{ route('trade_license_business_type_edit', ['businessType' => $data->id]) }}">হালনাগাদ</a>
                                    <a class="btn btn-danger bg-gradient-danger btn-sm tradeLicenseBusinessType" data-id="{{ $data->id }}" href="#">ডিলিট</a>
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
            $('body').on('click', '.tradeLicenseBusinessType', function (e) {
                e.preventDefault();
                let businessTypeID = $(this).data('id');
                Swal.fire({
                    title: 'আপনি কি মুছে ফেলতে চান?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#343a40',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'না',
                    confirmButtonText: 'হ্যাঁ, মুছে ফেলুন!'

                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: "POST",
                            url: "{{ route('trade_license_business_type_delete') }}",
                            data: { businessTypeID: businessTypeID }
                        }).done(function(response) {
                            if(response.success){
                                Swal.fire(
                                    'সফলভাবে',
                                    response.message,
                                    'success'
                                ).then((result)=>{
                                    location.reload();
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'উফ...',
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
