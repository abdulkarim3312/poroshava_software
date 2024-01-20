@extends('layouts.app')

@section('style')
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ asset('themes/backend/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('title')
    বেতন প্রস্তুত করুন
@endsection

@section('content')

    @if(Session::has('message'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ Session::get('message') }}
        </div>
    @endif
<?php
    $en = [1,2,3,4,5,6,7,8,9,0];
    $bn = ['১','২','৩','৪','৫','৬','৭','৮','৯','০'];

?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">বেতন প্রস্তুত করুন</h3>
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                    <form action="{{ route('cleaner_salary_process') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>বছর</label>

                                    <select class="form-control select2" name="year" id="year" required>
                                        <option value="">বছর নির্ধারণ</option>
                                        @for($i=2021; $i <= date('Y'); $i++)
                                            <option value="{{ $i }}" {{ request()->get('year') == $i ? 'selected' : '' }}>{{ str_replace($en,$bn,$i)}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>মাস</label>

                                    <select class="form-control select2" name="month" id="month" required>
                                        <option value="">মাস নির্ধারণ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>পাক্ষিক/মাসিক</label>

                                    <select class="form-control" name="bi_month" id="bi-month" required>
                                        <option value="">পাক্ষিক/মাসিক নির্ধারণ</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>প্রস্তুত তারিখ</label>

                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right"
                                               id="date" name="date" value="{{ date('Y-m-d')  }}" autocomplete="off" required>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>

                            <div class="col-md-3 pull-right">
                                <div class="form-group">
                                    <label>	&nbsp;</label>

                                    <input class="btn btn-success bg-gradient-success form-control" type="submit" value="প্রস্তুত করুন">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- bootstrap datepicker -->
    <script src="{{ asset('themes/backend/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

    <script>
        $(function () {
            //Date picker
            $('#date').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd',
                orientation: 'bottom'
            });
            var oldMonthSelected = '{{ request()->get('month') }}';
            var oldBiMonthSelected = '{{ request()->get('bi_month') }}';

            $('#year').change(function () {
                var year = $(this).val();
                $('#month').html('<option value="">মাস নির্ধারণ</option>');

                if (year != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_month') }}",
                        data: { year: year }
                    }).done(function( response ) {
                        $.each(response, function( index, item ) {
                            if(oldMonthSelected == item.id)
                                $('#month').append('<option value="'+item.id+'" selected>'+item.name+'</option>');
                            else
                                $('#month').append('<option value="'+item.id+'">'+item.name+'</option>');
                        });
                        $('#month').trigger("change");
                    });
                }
            });

            $('#year').trigger("change");

            $('#month').change(function () {
                var month = $(this).val();
                var year = $('#year').val();
                $('#bi-month').html('<option value="">পাক্ষিক/মাসিক নির্ধারণ</option>');

                if (month != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_bi_month') }}",
                        data: {year:year, month: month }
                    }).done(function( response ) {
                        $.each(response, function( index, item ) {
                            if(oldBiMonthSelected == item.id)
                                $('#bi-month').append('<option value="'+item.id+'" selected>'+item.name+'</option>');
                            else
                                $('#bi-month').append('<option value="'+item.id+'">'+item.name+'</option>');
                        });
                    });
                }
            });
            $('#month').trigger("change");
        });
    </script>
@endsection

