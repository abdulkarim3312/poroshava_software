@extends('layouts.app')
@section('title')
    মাসিক পরিচ্ছন্ন কর্মীদের বিল
@endsection
@section('style')
    <style>
        .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
            border: 1px solid #000000 !important;
            vertical-align: middle !important;
            text-align: center;
        }
        .body td {
            height: 91px !important;
            vertical-align: middle !important;
            text-align: center;
        }
        .table td, .table th {
            padding: 2px;
            border-top: 1px solid #000;
            font-size: 13px;
        }
    </style>
@endsection
@section('content')

    <?php
    $en = [1,2,3,4,5,6,7,8,9,0];
    $bn = ['১','২','৩','৪','৫','৬','৭','৮','৯','০'];
    $enMonth = ['1','2','3','4','5','6','7','8','9','10','11','12'];
    $bnMonth = ['জানুয়ারী','ফেব্রুয়ারী','মার্চ','এপ্রিল','মে','জুন','জুলাই','অগাস্ট','সেপ্টেম্বর','অক্টোবর','নভেম্বর','ডিসেম্বর'];


    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">ফিল্টার</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('monthly_bill') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="year">বছর *</label>
                                    <select class="form-control select2" name="year" id="year" required>
                                        <option value="">বছর নির্ধারণ</option>
                                        @foreach($salaryDates as $item)
                                            <option {{ request()->get('year') == $item->year ? 'selected' : '' }} value="{{ $item->year }}">{{ str_replace($en,$bn,$item->year)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="month">মাস *</label>
                                    <select class="form-control select2" name="month" id="month" required>
                                        <option value="">মাস নির্ধারণ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="area">এলাকা</label>
                                    <select class="form-control select2" name="area" id="area">
                                        <option value="">এলাকা নির্ধারণ</option>
                                        @foreach($areas as $area)
                                            <option value="{{ $area->id }}" {{ request()->get('area') == $area->id ? 'selected' : '' }}>{{ $area->community }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="team">দল</label>
                                    <select class="form-control select2" name="team" id="team">
                                        <option value="">দল নির্ধারণ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="type">ধরণ</label>
                                    <select class="form-control select2" name="type" id="type">
                                        <option value="">ধরণ নির্ধারণ</option>
                                        @foreach($types as $type)
                                            <option value="{{ $type->id }}" {{ request()->get('type') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>	&nbsp;</label>
                                    <input class="btn btn-success bg-gradient-success form-control" name="submit" type="submit" value="খুজুন">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if (count($salaries) > 0)
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header with-border">
                    <a href="#" role="button" class="btn btn-success bg-gradient-success pull-right" onclick="getprint('printArea')"><i class="fa fa-print"></i></a>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <div id="printArea">
                            <div style="padding:10px; width:100%; text-align:center;">
                                <h2>মাসিক পরিচ্ছন্ন কর্মীদের বিল</h2>
                                @if(request()->get('year') != '')
                                <h4>{{ str_replace($enMonth,$bnMonth,request()->get('month')) }}-{{ str_replace($en,$bn,request()->get('year')) }}</h4>
                                @endif
                            </div>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>আইডি</th>
                                        <th>ছবি</th>
                                        <th>পরিচ্ছন্ন কর্মীর নাম</th>
                                        <th>কমিউনিটি / এলাকা</th>
                                        <th>দলের নাম</th>
                                        <th>ধরণ</th>
                                        <th>দৈনিক বেতন</th>
{{--                                        <th>অন্যান্য</th>--}}
                                        <th>কর্তনের দিন</th>
                                        <th>মোট</th>
                                        <th width="200px" class="text-center">স্বাক্ষর</th>
                                    </tr>
                                @foreach ($salaries as $salary)
                                    <tr>
                                        <td>{{ str_replace($en,$bn,$salary->cleaner->cleaner_id) }}</td>
                                        <td><img src="{{ asset($salary->cleaner->photo) }}" width="50px" alt=""></td>
                                        <td>{{ $salary->cleaner->name }}</td>
                                        <td>{{ $salary->area->community }}</td>
                                        <td>{{ $salary->team->name }}</td>
                                        <td>{{ $salary->type->name }}</td>
                                        <td>{{ str_replace($en,$bn,number_format($salary->daily_salary,2)) }}</td>
{{--                                        <td>{{ str_replace($en,$bn,number_format($salary->others_salary,2)) }}</td>--}}
                                        <td>{{  str_replace($en,$bn,number_format($salary->deduction_day)) }}</td>
                                        <td>{{ str_replace($en,$bn,number_format($salary->total,2)) }}</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                                        <tr>
                                            <td class="text-right" colspan="6">মোট</td>
                                            <td>{{ str_replace($en,$bn,number_format($salaries->sum('daily_salary'),2)) }}</td>
{{--                                            <th>{{ str_replace($en,$bn,number_format($salaries->sum('others_salary'),2)) }}</th>--}}
                                            <td>{{  str_replace($en,$bn,number_format($salaries->sum('deduction_day'))) }}</td>
                                            <td>{{ str_replace($en,$bn,number_format($salaries->sum('total'),2)) }}</td>
                                            <td></td>
                                        </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection

@section('script')

    <script>
        $(function () {

            var oldMonthSelected = '{{ request()->get('month') }}';
            var oldBiMonthSelected = '{{ request()->get('bi_month') }}';
            var teamNameSelected = '{{ request()->get('team') }}';

            $('#area').change(function () {

                var communityID = $(this).val();

                $('#team').html('<option value="">দলের নাম</option>');

                if (communityID != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_team') }}",
                        data: { communityID: communityID }
                    }).done(function( data ) {
                        $.each(data, function( index, item ) {
                            if (teamNameSelected == item.id)
                                $('#team').append('<option value="'+item.id+'" selected>'+item.name+'</option>');
                            else
                                $('#team').append('<option value="'+item.id+'">'+item.name+'</option>');
                        });
                    });
                }
            });

            $('#area').trigger('change');

            $('#year').change(function () {
                var year = $(this).val();
                $('#month').html('<option value="">মাস নির্ধারণ</option>');

                if (year != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_salary_process_month') }}",
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
                $('#bi-month').html('<option value="">পাক্ষিক নির্ধারণ</option>');

                if (month != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_salary_process_bi_month') }}",
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

        var APP_URL = '{!! url()->full()  !!}';

        function getprint(print) {

            $('body').html($('#' + print).html());
            window.print();
            window.location.replace(APP_URL)
        }
    </script>
@endsection
