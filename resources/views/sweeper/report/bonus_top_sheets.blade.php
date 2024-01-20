@extends('layouts.app')
@section('title')
    পরিচ্ছন্ন কর্মীদের বোনাস টপশীট
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
                    <form action="{{ route('bonus_top_sheets') }}">
                        <div class="row">
                            <div class="col-md-4">
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
    @if ($bonus)
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
                                <h4>পরিচ্ছন্ন কর্মীদের বোনাস </h4>
                                @if(request()->get('bonus') != '')
                                    <h4>{{ str_replace($enBonus,$bnBonus,$bonus->bonus) }}, {{ str_replace($enMonth,$bnMonth,$bonus->month) }}-{{ str_replace($en,$bn,$bonus->year) }}</h4>
                                @endif
                            </div>
                           <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">ক্রমিক নং</th>
                                <th class="text-center">পরিচ্ছন্ন কর্মীদের সংখ্যা</th>
                                <th class="text-center">মোট বোনাস(টাকা)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ str_replace($en,$bn,1) }}</td>
                                <td class="text-left">{{ str_replace($en,$bn,number_format($totalCleaner)) }} জন</td>
                                <td class="text-right">{{ str_replace($en,$bn,number_format($bonus->total)) }}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th  class="text-center">মোট</th>
                              <th colspan="2" class="text-right">{{ str_replace($en,$bn,number_format($bonus->total)) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                            <div class="row text-center" style="margin-top: 150px">
                                <div class="col-xs-3 col-xs-offset-2"><span style="border-top: 1px solid #000">কন্জারভেন্সী ইনস্পেকটর</span></div>
                                <div class="col-xs-2"></div>
                                <div class="col-xs-2"><span style="border-top: 1px solid #000">হিসাব রক্ষক</span></div>
                            </div>
                            <div class="row text-center" style="margin-top: 50px;">
                                <div class="col-xs-8 col-xs-offset-2">
                                    <div class="" style="border:1px solid #000!important;clear:both;min-height: 170px;padding: 5px 10px;">
                                        <p class="text-center">এই বিলের পরিচ্ছন্ন কর্মীদের @if(request()->get('bonus') != '')
                                            {{ str_replace($enBonus,$bnBonus,$bonus->bonus) }}, {{ str_replace($enMonth,$bnMonth,$bonus->month) }}-{{ str_replace($en,$bn,$bonus->year) }}
                                        @endif বাবদ  টাঃ {{ str_replace($en,$bn,number_format($bonus->total)) }} /- মাত্র দেওয়া গেল |</p>
                                        <p style="margin-top: 70px;padding-bottom: 5px;" class="pull-left">প্রধান নির্বাহী কর্মকর্তা<br>
                                            ফরিদপুর পৌরসভা
                                        </p>
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
    @endif
@endsection
@section('script')

    <script>


        var APP_URL = '{!! url()->full()  !!}';

        function getprint(print) {

            $('body').html($('#' + print).html());
            window.print();
            window.location.replace(APP_URL)
        }
    </script>
@endsection
