@extends('layouts.app')
@section('title','দৈনিক সমাপনী')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-default">
            <div class="card-header">

                <form action="{{ route('collection.closing') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" autocomplete="off" name="date" class="form-control date-picker" placeholder="সমাপনীর তারিখ">
                                @error('date')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button  class="btn btn-success bg-gradient-success">সমাপনী যুক্তকরুন</button>
                        </div>
                    </div>
                </form>

            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>তারিখ</th>
                        <th>টোটাল এমাউন্ট</th>
                        <th>সমাপনীকারী</th>
                        <th>গ্রহন কারী</th>
                        <th>অবস্থা</th>
                        <th>অ্যাকশন</th>
                    </tr>
                    </thead>
                </table>
                </div>
                </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>

<div class="modal fade" id="pin-modal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="border: none"></div>
            <div class="modal-body">
                <form action="#">
                    <input type="hidden" id="closing_id">
                    <input type="hidden" id="approve">
                    <div class="form-group">
                        <input type="password" class="form-control form-control-sm" id="pin" placeholder="আপনার পিন প্রবেশ করুন">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal">বন্ধ করুন</button>
                <button type="button" class="btn btn-primary btn-sm" id="pin-check">ঠিক আছে</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@endsection
@section('script')
    <script>
        $(function () {
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('collection_closing.datatable') }}',
                columns: [
                    {data: 'date', name: 'date'},
                    {data: 'total_amount', name: 'total_amount',orderable: false},
                    {data: 'closing_by', name: 'closing_by.name'},
                    {data: 'approve_by', name: 'approve_by.name'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false},
                ],
                "order": [[ 0, "desc" ]],
            });

            $('body').on('click', '.btn-trash', function () {
                var closingId = $(this).data('id');
                $("#approve").val('');
                $("#closing_id").val(closingId);
                $("#pin-modal").modal('show');

            });

            $('body').on('click','.btn-approve', function () {

                var closingId = $(this).data('id');

                Swal.fire({
                    title: 'আপনি কি নিশ্চিত?',
                    text: "আপনি এটি ফিরিয়ে আনতে পারবেন না!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'হ্যাঁ, এটি অনুমোদিত!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: "Post",
                            url: "{{ route('collection.cashier_approve') }}",
                            data: { closingId: closingId }
                        }).done(function( response ) {
                            if (response.success) {
                                Swal.fire(
                                    'অনুমোদিত!',
                                    response.message,
                                    'সফল'
                                ).then((result) => {
                                    location.reload();
                                });
                            }
                        });

                    }
                })

            });

            $("#pin-check").click(function (){

               var pin = $("#pin").val();
               var closing_id = $("#closing_id").val();
               var approve = $("#approve").val();

                if (pin === ''){
                    Swal.fire({
                        icon: 'error',
                        title: 'দুঃখিত...',
                        text: 'আপনার পিন প্রবেশ করুন',
                    });
                }else if(pin.length > 4 || pin.length < 4){
                    Swal.fire({
                        icon: 'error',
                        title: 'দুঃখিত...',
                        text: '৪ ডিজিটের পিন প্রবেশ করুন',
                    });
                }else{
                    $.ajax({
                        method: "Post",
                        url: "{{ route('collection.user_pin_check_closing_delete') }}",
                        data: { closing_id:closing_id,pin:pin,approve:approve }
                    }).done(function( response ) {
                        if (response.success) {
                            $('#pin-modal').modal('hide');
                            Swal.fire(
                                'সম্পন্ন!',
                                response.message,
                                'সম্পন্ন'
                            ).then((result) => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'দুঃখিত...',
                                text: response.message,
                            });
                        }
                    });
                }

            })



        });
    </script>
@endsection
