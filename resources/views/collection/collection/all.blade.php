@extends('layouts.app')
@section('title','আদায় সমূহের তালিকা')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-default">
            <div class="card-header">
               <div class="card-title">ফিল্টার</div>
            </div>
            <div class="card-body">
                <form action="">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="start">শুরুর তারিখ</label>
                                <input type="text" autocomplete="off" id="start" name="start" class="form-control date-picker" placeholder="শুরুর তারিখ">

                            </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-group">
                               <label for="end">শেষ তারিখ</label>
                               <input type="text" autocomplete="off" id="end" name="end" class="form-control date-picker" placeholder="শেষ তারিখ">
                           </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="type">খাত</label>
                                <select class="form-control select2" id="type" name="type">
                                    <option value="">খাত বাছাই করুন</option>
                                    @foreach($types as $type)
                                        <option {{ request()->get('type') == $type->id ? 'selected' : '' }} value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="sub_type">উপ খাত</label>
                                <select class="form-control select2" id="sub_type" name="sub_type">
                                    <option value="">উপ খাত বাছাই করুন</option>
                                </select>
                            </div>
                        </div>
                        @if(auth()->user()->role != \App\Enumeration\Role::$COLLECTION && auth()->user()->sub_role != \App\Enumeration\SubRole::$COLLECTOR)
                        <div class="col-md-3">
                           <div class="form-group">
                               <label for="collector">আদায়কারী</label>
                               <select class="form-control select2" id="collector" name="collector">
                                   <option value="">আদায়কারী বাছাই করুন</option>
                                   @foreach($users as $user)
                                       <option {{ request()->get('collector') == $user->id ? 'selected' : '' }} value="{{ $user->id }}">{{ $user->name }}</option>
                                   @endforeach
                               </select>
                           </div>
                        </div>
                        @endif
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <input type="button" id="search" class="btn btn-success bg-gradient-success form-control" value="সার্চ">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card card-default">
            <div class="card-header">
                @if(auth()->user()->role != \App\Enumeration\Role::$COLLECTION && auth()->user()->sub_role != \App\Enumeration\SubRole::$COLLECTOR)
                <a href="{{ route('collection.add') }}" class="btn btn-primary btn-flat bg-gradient-primary">আদায় যুক্তকরুন</a>
                @endif
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>ক্রমিক নং</th>
                        <th>তারিখ</th>
                        <th>খাত</th>
                        <th>প্রদানকারী</th>
                        <th>মহল্লা</th>
                        <th>ফি</th>
                        <th>ভ্যাট</th>
                        <th>সাব টোটাল</th>
                        <th>ডিসকাউন্ট</th>
                        <th>গ্রান্ড টোটাল</th>
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
                    <input type="hidden" id="collection_id">
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

            var selectedSubTYpe = '{{ request()->get('sub_type') }}';
            //Select Type
            $('#type').change(function (){
                var typeId = $(this).val();

                $('#sub_type').html('<option value="">উপ খাত বাছাই করুন</option>');

                if (typeId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('collection.get_sub_type') }}",
                        data: {typeId:typeId}
                    }).done(function( data ) {
                        $.each(data, function( index, item ) {
                            if (selectedSubTYpe == item.id)
                                $('#sub_type').append('<option value="'+item.id+'" selected>'+item.name+'</option>');
                            else
                                $('#sub_type').append('<option value="'+item.id+'">'+item.name+'</option>');
                        });
                        $('#sub_type').trigger("change");
                    });

                }
            });
            $('#type').trigger("change");


           var table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                   url: "{{ route('collection.datatable') }}",
                   data: function (d) {
                       d.start_date = $('#start').val()
                       d.end_date = $('#end').val()
                       d.type = $('#type').val()
                       d.sub_type = $('#sub_type').val()
                       d.collector = $('#collector').val()
                   }
               },
                columns: [
                    {data: 'receipt_no', name: 'receipt_no'},
                    {data: 'date', name: 'date'},
                    {data: 'sub_type', name: 'sub_type.name'},
                    {data: 'name', name: 'name'},
                    {data: 'area', name: 'area.area_name'},
                    {data: 'fees', name: 'fees'},
                    {data: 'vat', name: 'vat'},
                    {data: 'sub_total', name: 'sub_total'},
                    {data: 'discount', name: 'discount'},
                    {data: 'grand_total', name: 'grand_total'},
                    {data: 'action', name: 'action', orderable: false},
                ],
                "order": [[ 0, "desc" ]],
            });
           $("#start,#end").change(function (){
               var startDate = $("#start").val();
               var endDate = $("#end").val();
               if(startDate != '' && endDate != ''){
                   table.ajax.reload();
               }

           })
            $("#type,#sub_type,#collector").change(function (){
                table.ajax.reload();

            })
            $("#search").click(function (){
                table.ajax.reload();
            })

            $('body').on('click', '.btn-edit', function () {
                var collectionId = $(this).data('id');

                $("#collection_id").val(collectionId);
                $("#pin-modal").modal('show');

            });

            $("#pin-check").click(function (){

               var pin = $("#pin").val();
               var collection_id = $("#collection_id").val();

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
                        url: "{{ route('collection.user_pin_check') }}",
                        data: { collection_id:collection_id,pin:pin }
                    }).done(function( response ) {
                        if (response.success) {
                            location.href = response.url;
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

