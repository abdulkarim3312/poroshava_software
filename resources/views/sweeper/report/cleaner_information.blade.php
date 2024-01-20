@extends('layouts.app')
@section('title')
    পরিচ্ছন্ন কর্মীদের তথ্য
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
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">ফিল্টার</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('cleaner_information') }}">
                        <div class="row">
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

                            <div class="col-md-3 pull-right">
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
    @if(count($cleaners) > 0)
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
                                <h2>পরিচ্ছন্ন কর্মীদের তথ্য</h2>
                            </div>
                            @foreach($cleaners->unique('type') as $key => $cleaner)

                            <table class="table table-bordered">
                                <tr>
                                    <th style="border-top: 1px solid #FFF !important;border-left: 1px solid #FFF !important;border-right: 1px solid #FFF !important;" colspan="13"><strong>{{ $cleaner->type->name.' ['.'মোট '.str_replace($en,$bn,count($cleaner->type->cleanerType)).' জন ] ' }}</strong></th>
                                </tr>
                                <tr>
                                    <th>আইডি</th>
                                    <th>ছবি</th>
                                    <th>কমিউনিটি / এলাকা</th>
                                    <th>দলের নাম</th>
                                    <th>ধরণ</th>
                                    <th>পরিচ্ছন্ন কর্মীর নাম</th>
                                    <th>পিতা/ স্বামীর নাম</th>
                                    <th>জাতীয় পরিচয় পত্ৰ/ জন্ম নিবন্ধন নম্বর</th>
                                    <th>মোবাইল নম্বর</th>
                                    <th>ঠিকানা</th>
                                    <th>দৈনিক বেতন</th>
                                    <th>অন্যান্য</th>
                                    <th>কর্তনের দিন</th>
                                </tr>
                                    @foreach($cleaner->type->cleanerType as $row)
                                    <tr>
                                        <td>{{ str_replace($en,$bn,$row->cleaner_id) }}</td>
                                        <td><img src="{{ asset($row->photo) }}" width="50px" alt=""></td>
                                        <td>{{ $row->area->community }}</td>
                                        <td>{{ $row->team->name }}</td>
                                        <td>{{ $row->type->name }}</td>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->father_name }}</td>
                                        <td>{{ str_replace($en,$bn,$row->national_nid) }}</td>
                                        <td>{{ str_replace($en,$bn,$row->mobile_no) }}</td>
                                        <td>{{ $row->address }}</td>
                                        <td>{{ str_replace($en,$bn,number_format($row->daily_salary,2)) }}</td>
                                        <td>{{ str_replace($en,$bn,number_format($row->others_salary,2)) }}</td>
                                        <td>{{ str_replace($en,$bn,$row->deduction_day) }}</td>
                                    </tr>
                                    @endforeach
                            </table>
                            @endforeach
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


        });
        var APP_URL = '{!! url()->full()  !!}';

        function getprint(print) {

            $('body').html($('#' + print).html());
            window.print();
            window.location.replace(APP_URL)
        }
    </script>
@endsection
