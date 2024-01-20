@extends('layouts.app')

@section('title')
    পরিচ্ছন্ন কর্মীর বেতন/ বোনাস হালনাগাদ
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title"> পরিচ্ছন্ন কর্মীর বেতন/ বোনাস হালনাগাদ</div>
                </div>
                <div class="card-body">

                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ছবি</th>
                            <th>আইডি</th>
                            <th>নাম</th>
                            <th>দৈনিক বেতন</th>
                            <th>বোনাস</th>
                            <th>অন্যান্য সংযোজন</th>
                            <th>বেতন কর্তনের দিন</th>
                            <th>অন্যান্য বেতন কর্তন</th>
                            <th>মন্তব্য</th>
                            <th width="25%">অ্যাকশন</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal-update">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">পরিচ্ছন্ন কর্মীর বেতন হালনাগাদ</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="modal-form" enctype="multipart/form-data" name="modal-form">
                        <div class="form-group">
                            <label>পরিচ্ছন্ন কর্মীর নাম </label>
                            <input class="form-control" id="modal-name" disabled>
                            <input type="hidden" id="cleaner_id" name="cleaner_id">
                        </div>

                        <div class="form-group">
                            <label>দৈনিক বেতন</label>
                            <input class="form-control" name="daily_salary" id="daily_salary" placeholder="দৈনিক বেতন">
                        </div>
                        <div class="form-group">
                            <label>অন্যান্য সংযোজন</label>
                            <input class="form-control" name="others_salary" id="others_salary" placeholder="অন্যান্য সংযোজন">
                        </div>
                        <div class="form-group">
                            <label>অন্যান্য বেতন কর্তন</label>
                            <input class="form-control" name="deduct_salary" id="deduct_salary" placeholder="বেতন কর্তন">
                        </div>
                        <div class="form-group">
                            <label>বেতন কর্তনের দিন</label>
                            <input class="form-control" name="deduction_day" id="deduction_day" placeholder="বেতন কর্তনের দিন">
                        </div>
                        <div class="form-group">
                            <label>মন্তব্য</label>
                            <input class="form-control" name="notes" id="notes" placeholder="মন্তব্য">
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">বন্ধ করুন</button>
                    <button type="button" class="btn btn-success bg-gradient-success" id="modal-btn-update">হালনাগাদ করুন</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal-bonus">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">পরিচ্ছন্ন কর্মীর বোনাস হালনাগাদ</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <div class="modal-body">
                    <form id="modal-form-bonus" enctype="multipart/form-data" name="modal-form-bonus">
                        <div class="form-group">
                            <label>পরিচ্ছন্ন কর্মীর নাম </label>
                            <input class="form-control" id="modal-name-bonus" disabled>
                            <input type="hidden" id="cleaner_id_bonus" name="cleaner_id">
                        </div>

                        <div class="form-group">
                            <label>বোনাস</label>
                            <input class="form-control" name="bonus" id="bonus" placeholder="বোনাস">
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">বন্ধ করুন</button>
                    <button type="button" class="btn btn-success bg-gradient-success" id="modal-btn-bonus">হালনাগাদ করুন</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="password-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">আপনার পাসওয়ার্ড প্রবেশ করুন</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#">
                        <div class="form-group">
                            <input type="password" class="form-control" id="salary-password" placeholder="আপনার পাসওয়ার্ড প্রবেশ করুন...">
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">বন্ধ করুন</button>
                    <button type="button" class="btn btn-success bg-gradient-success" id="modal-btn-salary-confirm">ঠিক আছে</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="password-modal2">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">আপনার পাসওয়ার্ড প্রবেশ করুন</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <div class="modal-body">
                    <form action="#">
                        <div class="form-group">
                            <input type="password" class="form-control" id="salary-password2" placeholder="আপনার পাসওয়ার্ড প্রবেশ করুন...">
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">বন্ধ করুন</button>
                    <button type="button" class="btn btn-success bg-gradient-success" id="modal-btn-salary-confirm2">ঠিক আছে</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- /.modal -->
@endsection

@section('script')
    <script>
        $(function () {
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('cleaner_datatable') }}',
                columns: [
                    {data: 'photo', name: 'photo', orderable: false},
                    {data: 'cleaner_id', name: 'cleaner_id'},
                    {data: 'name', name: 'name'},
                    {data: 'daily_salary', name: 'daily_salary'},
                    {data: 'bonus', name: 'bonus'},
                    {data: 'others_salary', name: 'others_salary'},
                    {data: 'deduction_day', name: 'deduction_day'},
                    {data: 'deduct_salary', name: 'deduct_salary'},
                    {data: 'notes', name: 'notes'},
                    {data: 'salary_update', name: 'salary_update', orderable: false},
                ],
                order: [[ 1, "asc" ]],
            });

            $('body').on('click', '.btn-update', function () {
                var cleanerId = $(this).data('id');
                var cleanerName = $(this).data('name');

                $('#modal-name').val(cleanerName);
                $('#cleaner_id').val(cleanerId);

                $("#password-modal").modal('show');

                $("#modal-btn-salary-confirm").click(function (){
                   var salaryPassword = $("#salary-password").val();
                   if (salaryPassword == 'g8907'){
                       $("#password-modal").modal('hide');

                       $.ajax({
                           method: "GET",
                           url: "{{ route('get_cleaner') }}",
                           data: { cleanerId: cleanerId }
                       }).done(function( response ) {

                           $('#deduction_day').val(response.deduction_day);
                           $('#daily_salary').val(response.daily_salary.toFixed(2));
                           $('#others_salary').val(response.others_salary.toFixed(2));
                           $('#deduct_salary').val(response.deduct_salary.toFixed(2));
                           $('#notes').val(response.notes);

                           $('#modal-update').modal('show');
                       });
                   }else if (salaryPassword == ''){
                       Swal.fire({
                           icon: 'error',
                           title: 'উফফ...',
                           text: 'আপনার পাসওয়ার্ড প্রবেশ করুন',
                       });
                   }else{
                       Swal.fire({
                           icon: 'error',
                           title: 'উফফ...',
                           text: 'আপনার পাসওয়ার্ড ভুল হয়েছে',
                       });
                   }

                });


            });
            $('#modal-btn-update').click(function () {
                var formData = new FormData($('#modal-form')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ route('cleaner_salary_update') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            $('#modal-update').modal('hide');
                            Swal.fire(
                                'হালনাগাদ!',
                                response.message,
                                'success'
                            ).then((result) => {
                                //location.reload();
                                window.location.href = response.redirect_url;
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message,
                            });
                        }
                    }
                });
            });

            $('body').on('click', '.btn-bonus', function () {
                var cleanerId = $(this).data('id');
                var cleanerName = $(this).data('name');

                $('#modal-name-bonus').val(cleanerName);
                $('#cleaner_id_bonus').val(cleanerId);
                $("#password-modal2").modal('show');

                $("#modal-btn-salary-confirm2").click(function (){
                    var salaryPassword2 = $("#salary-password2").val();

                    if (salaryPassword2 == 'g8907'){
                        $("#password-modal2").modal('hide');

                        $.ajax({
                            method: "GET",
                            url: "{{ route('get_cleaner') }}",
                            data: { cleanerId: cleanerId }
                        }).done(function( response ) {

                            $('#bonus').val(response.bonus);
                            $('#modal-bonus').modal('show');
                        });
                    }else if (salaryPassword2 == ''){
                        Swal.fire({
                            icon: 'error',
                            title: 'উফফ...',
                            text: 'আপনার পাসওয়ার্ড প্রবেশ করুন',
                        });
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'উফফ...',
                            text: 'আপনার পাসওয়ার্ড ভুল হয়েছে',
                        });
                    }

                });

            });
            $('#modal-btn-bonus').click(function () {
                var formData = new FormData($('#modal-form-bonus')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ route('cleaner_bonus_update') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            $('#modal-bonus').modal('hide');
                            Swal.fire(
                                'হালনাগাদ!',
                                response.message,
                                'success'
                            ).then((result) => {
                                //location.reload();
                                window.location.href = response.redirect_url;
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message,
                            });
                        }
                    }
                });
            });

        })
    </script>
@endsection
