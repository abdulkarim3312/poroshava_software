@extends('layouts.app')
@section('title')
  পরিচ্ছন্ন কর্মীদের বোনাস
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
    $enBonus = ['1','2','3','4'];
    $bnBonus = ['ঈদ উল ফিতর','ঈদ উল আজহা','পহেলা বৈশাখ','দূর্গা পুজা'];


    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">ফিল্টার</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('bonus') }}">
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
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="type">বোনাস</label>
                                    <select class="form-control select2" name="bonus" id="bonus" required>
                                        <option value="">বোনাস নির্ধারণ</option>
                                        @foreach($bonusDates as $bonusDate)
                                            <option value="{{ $bonusDate->year.'-'.$bonusDate->month.'-'.$bonusDate->bonus }}" {{ request()->get('bonus') == $bonusDate->year.'-'.$bonusDate->month.'-'.$bonusDate->bonus ? 'selected' : '' }}>{{ str_replace($enBonus,$bnBonus,$bonusDate->bonus).'/ '.str_replace($enMonth,$bnMonth,$bonusDate->month).'-'.str_replace($en,$bn,$bonusDate->year) }}</option>
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

    @if (count($bonuses) > 0)
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
                                <h2>পরিচ্ছন্ন কর্মীদের বোনাস</h2>
                                @if(request()->get('bonus') != '')
                                <h4>{{ str_replace($enBonus,$bnBonus,$bonuses[0]->bonus) }}, {{ str_replace($enMonth,$bnMonth,$bonuses[0]->month) }}-{{ str_replace($en,$bn,$bonuses[0]->year) }}</h4>
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
                                        <th>বোনাস</th>
                                        <th width="200px" class="text-center">স্বাক্ষর</th>
                                    </tr>
                                @foreach ($bonuses as $bonus)
                                    <tr class="body">
                                        <td>{{ str_replace($en,$bn,$bonus->cleaner->cleaner_id) }}</td>
                                        <td><img src="{{ asset($bonus->cleaner->photo) }}" width="50px" alt=""></td>
                                        <td>{{ $bonus->cleaner->name }}</td>
                                        <td>{{ $bonus->area->community }}</td>
                                        <td>{{ $bonus->team->name }}</td>
                                        <td>{{ $bonus->type->name }}</td>
                                        <td>{{ str_replace($en,$bn,number_format($bonus->total,2)) }}</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                                    <tr>
                                        <td class="text-right" colspan="6">মোট</td>
                                       <td>{{ str_replace($en,$bn,number_format($bonuses->sum('total'),2)) }}</td>
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
    <script src="{{ asset('themes/backend/js/sweetalert2@9.js') }}"></script>
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
