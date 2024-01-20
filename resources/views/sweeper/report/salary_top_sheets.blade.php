@extends('layouts.app')
@section('title')
    পরিচ্ছন্ন কর্মীদের বেতন টপশীট
@endsection
@section('style')
    <style>
        .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
            border: 1px solid #000000 !important;
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
                    <form action="{{ route('salary_top_sheets') }}">
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
                                    <label for="bi-month">পাক্ষিক/মাসিক  *</label>
                                    <select class="form-control" name="bi_month" id="bi-month" required>
                                        <option value="">পাক্ষিক নির্ধারণ</option>
                                    </select>
                                </div>
                            </div>
{{--                            <div class="col-md-3">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="area">এলাকা</label>--}}
{{--                                    <select class="form-control select2" name="area" id="area">--}}
{{--                                        <option value="">এলাকা নির্ধারণ</option>--}}
{{--                                        @foreach($areas as $area)--}}
{{--                                            <option value="{{ $area->id }}" {{ request()->get('area') == $area->id ? 'selected' : '' }}>{{ $area->community }}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-3">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="team">দল</label>--}}
{{--                                    <select class="form-control select2" name="team" id="team">--}}
{{--                                        <option value="">দল নির্ধারণ</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-3">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="type">ধরণ</label>--}}
{{--                                    <select class="form-control select2" name="type" id="type">--}}
{{--                                        <option value="">ধরণ নির্ধারণ</option>--}}
{{--                                        @foreach($types as $type)--}}
{{--                                            <option value="{{ $type->id }}" {{ request()->get('type') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}

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
                                <h3>ফরিদপুর পৌরসভা, ফরিদপুর</h3>
                                <h4>পরিচ্ছন্ন কর্মীদের {{ request()->get('bi_month') == 1 ? 'প্রথম পাক্ষিক' : (request()->get('bi_month') == 2 ? 'দ্বিতীয় পাক্ষিক' :'মাসিক ')}} বিল</h4>
                                @if(request()->get('year') != '')
                                    <h4>
                                        সময়কালঃ
                                        {{ str_replace($en,$bn,$durationStartDate) }} হতে
                                        {{ str_replace($en,$bn,$durationEndDate) }}



                                    </h4>
                                @endif
                            </div>
                           <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">ক্রমিক নং</th>
                                <th class="text-center">পরিচ্ছন্ন কর্মীদের সংখ্যা</th>
                                <th class="text-center">মোট পারিশ্রমিক(টাকা)</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($salaries as $salary)
                            <tr>
                                <td class="text-center">{{ str_replace($en,$bn,$loop->iteration) }}</td>
                                <td class="text-left">{{ str_replace($en,$bn,number_format($totalCleaner)) }} জন</td>
                                <td class="text-right">{{ str_replace($en,$bn,number_format($salary->total)) }}</td>
                            </tr>
                         @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th  class="text-center">মোট</th>
                                <th colspan="2" class="text-right">{{ str_replace($en,$bn,number_format($salaries->sum('total'))) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                            <div class="row text-center" style="margin-top: 150px">
                                <div class="col-3 offset-2"><span style="border-top: 1px solid #000">কন্জারভেন্সী ইনস্পেকটর</span></div>
                                <div class="col-2"></div>
                                <div class="col-2"><span style="border-top: 1px solid #000">হিসাব রক্ষক</span></div>
                            </div>
                            <div class="row text-center" style="margin-top: 50px;">
                                <div class="col-8 offset-2">
                                    <div class="" style="border:1px solid #000!important;clear:both;min-height: 170px;padding: 5px 10px;">
                                        <p class="text-center">এই বিলের পরিচ্ছন্ন কর্মীদের {{ request()->get('bi_month') == 1 ? 'প্রথম পাক্ষিক' : (request()->get('bi_month') == 2 ? 'দ্বিতীয় পাক্ষিক' :'মাসিক ')}} বিল বাবদ  টাঃ {{ str_replace($en,$bn,number_format($salaries->sum('total'))) }} /- মাত্র দেওয়া গেল |</p>
                                        <div class="row">
                                            <div class="col-6">
                                                <p style="margin-top: 70px;padding-bottom: 5px;" class="pull-left">প্রধান নির্বাহী কর্মকর্তা<br>
                                                    ফরিদপুর পৌরসভা
                                                </p>
                                            </div>
                                            <div class="col-6">
                                                <p style="margin-top: 70px;padding-bottom: 5px;" class="pull-right">মেয়র<br>
                                                    ফরিদপুর পৌরসভা</p>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
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
                $('#bi-month').html('<option value="">পাক্ষিক/মাসিক নির্ধারণ</option>');

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
