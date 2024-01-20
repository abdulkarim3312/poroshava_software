@extends('layouts.app')

@section('title')
    ঋণ গ্রহীতার বিস্তারিত
@endsection

@section('content')
    <?php
    $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
    $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
    ?>

    <div class="row">
        <div class="col-md-12">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#basic_info" data-toggle="tab">সাধারন তথ্য</a></li>
                    <li><a href="#loan" data-toggle="tab">ঋণ</a></li>
                    <li><a href="#savings" data-toggle="tab">সঞ্চয়</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="basic_info">
                        <div class="row">
                            <div class="col-md-8">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>আইডি</th>
                                        <td>{{ $borrower->member_id }}</td>
                                    </tr>

                                    <tr>
                                        <th>কমিউনিটি / এলাকা</th>
                                        <td>{{ $borrower->area->community }}</td>
                                    </tr>

                                    <tr>
                                        <th>দল</th>
                                        <td>{{ $borrower->team->name }}</td>
                                    </tr>

                                    <tr>
                                        <th>ঋণ গ্রহিতার নাম</th>
                                        <td>{{ $borrower->name }}</td>
                                    </tr>

                                    <tr>
                                        <th>পিতার/স্বামীর নাম</th>
                                        <td>{{ $borrower->father_name }}</td>
                                    </tr>

                                    <tr>
                                        <th>মাতার নাম</th>
                                        <td>{{ $borrower->mother_name }}</td>
                                    </tr>

                                    <tr>
                                        <th>জাতীয় পরিচয়পত্র নম্বর / জন্ম নিবন্ধন নং</th>
                                        <td>{{ $borrower->nid }}</td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-4 text-center">
                                <img class="img-thumbnail" src="{{ asset($borrower->image) }}" width="150px">
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="loan">
                        <table class="table table-bordered">
                            <tr>
                                <th>ঋণের ধরণ</th>
                                <td>
                                    @if($borrower->loan_type == 1)
                                        ব্যাবসা
                                    @else
                                        অন্যান্য
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th>ঋণ প্রদানের তারিখ</th>
                                <td>{{ $borrower->loan_date->format('j F, Y') }}</td>
                            </tr>

                            <tr>
                                <th>ঋণের পরিমান</th>
                                <td>৳{{ str_replace($en, $bn, number_format($borrower->loan_amount, 2)) }}</td>
                            </tr>

                            <tr>
                                <th>কিস্তি পরিমান</th>
                                <td>৳{{ str_replace($en, $bn, number_format($borrower->installment_amount, 2)) }}</td>
                            </tr>

                            <tr>
                                <th>মোট কিস্তি পরিশোধের পরিমাণ</th>
                                <td>৳{{ str_replace($en, $bn, number_format($borrower->installment_amount * count($borrower->payments), 2)) }}</td>
                            </tr>

                            <tr>
                                <th>অবশিষ্ট কিস্তির পরিমাণ</th>
                                <td>৳{{ str_replace($en, $bn, number_format($borrower->loan_amount - ($borrower->installment_amount * count($borrower->payments)), 2)) }}</td>
                            </tr>

                            <tr>
                                <th>মোট সেবার পরিমাণ</th>
                                <td>৳{{ str_replace($en, $bn, number_format($borrower->installment_amount * count($borrower->payments) * .10, 2)) }}</td>
                            </tr>

                            <tr>
                                <th>কিস্তি সংখ্যা</th>
                                <td>{{ str_replace($en, $bn, $borrower->installment_count) }}</td>
                            </tr>

                            <tr>
                                <th>পূর্বে প্রদানকৃত কিস্তি সংখ্যা</th>
                                <td>{{ str_replace($en, $bn, $borrower->initial_installment_count) }}</td>
                            </tr>

                            <tr>
                                <th>প্রদানকৃত কিস্তি সংখ্যা</th>
                                <td>{{ str_replace($en, $bn, $borrower->installment_give) }}</td>
                            </tr>

                            <tr>
                                <th>বাকি কিস্তি সংখ্যা</th>
                                <td>{{ str_replace($en, $bn, $borrower->installment_remain) }}</td>
                            </tr>
                        </table>

                        <table id="table-loan" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>তারিখ</th>
                                <th>অর্থ বছর</th>
                                <th>মাস</th>
                                <th>সপ্তাহ</th>
                                <th>পরিমাণ</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($borrower->payments as $payment)
                                <tr>
                                    <td>{{ $payment->pay_date->format('Y-m-d') }}</td>
                                    <td>{{ str_replace($en, $bn, $payment->financial_year) }}</td>
                                    <td>
                                        @if($payment->month == 1)
                                            জানুয়ারী
                                        @elseif($payment->month == 2)
                                            ফেব্রুয়ারী
                                        @elseif($payment->month == 3)
                                            মার্চ
                                        @elseif($payment->month == 4)
                                            এপ্রিল
                                        @elseif($payment->month == 5)
                                            মে
                                        @elseif($payment->month == 6)
                                            জুন
                                        @elseif($payment->month == 7)
                                            জুলাই
                                        @elseif($payment->month == 8)
                                            অগাস্ট
                                        @elseif($payment->month == 9)
                                            সেপ্টেম্বর
                                        @elseif($payment->month == 10)
                                            অক্টোবর
                                        @elseif($payment->month == 11)
                                            নভেম্বর
                                        @elseif($payment->month == 12)
                                            ডিসেম্বর
                                        @endif
                                    </td>
                                    <td>
                                        @if($payment->week == 1)
                                            ১ম সপ্তাহ
                                        @elseif($payment->week == 2)
                                            ২য় সপ্তাহ
                                        @elseif($payment->week == 3)
                                            ৩য় সপ্তাহ
                                        @elseif($payment->week == 4)
                                            ৪র্থ সপ্তাহ
                                        @endif
                                    </td>
                                    <td>৳{{ str_replace($en, $bn, number_format($payment->pay_amount, 2)) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="savings">
                        <table class="table table-bordered">
                            <tr>
                                <th>প্রারম্ভিক সঞ্চয়ের পরিমাণ</th>
                                <td>৳{{ str_replace($en, $bn, number_format($borrower->initial_saving_amount, 2)) }}</td>
                            </tr>
                            <tr>
                                <th>বর্তমান সঞ্চয়ের পরিমাণ</th>
                                <td>৳{{ str_replace($en, $bn, number_format($borrower->saving_amount, 2)) }}</td>
                            </tr>
                        </table>

                        <table id="table-savings" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>তারিখ</th>
                                <th>ধরণ</th>
                                <th>অর্থ বছর</th>
                                <th>মাস</th>
                                <th>সপ্তাহ</th>
                                <th>পরিমাণ</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($borrower->savings as $saving)
                                <tr>
                                    <td>{{ $saving->date->format('Y-m-d') }}</td>
                                    <td>
                                        @if($saving->type == 1)
                                            জমা
                                        @elseif($saving->type == 2)
                                            উত্তোলন
                                        @endif
                                    </td>
                                    <td>{{ str_replace($en, $bn, $saving->financial_year) }}</td>
                                    <td>
                                        @if($saving->month == 1)
                                            জানুয়ারী
                                        @elseif($saving->month == 2)
                                            ফেব্রুয়ারী
                                        @elseif($saving->month == 3)
                                            মার্চ
                                        @elseif($saving->month == 4)
                                            এপ্রিল
                                        @elseif($saving->month == 5)
                                            মে
                                        @elseif($saving->month == 6)
                                            জুন
                                        @elseif($saving->month == 7)
                                            জুলাই
                                        @elseif($saving->month == 8)
                                            অগাস্ট
                                        @elseif($saving->month == 9)
                                            সেপ্টেম্বর
                                        @elseif($saving->month == 10)
                                            অক্টোবর
                                        @elseif($saving->month == 11)
                                            নভেম্বর
                                        @elseif($saving->month == 12)
                                            ডিসেম্বর
                                        @endif
                                    </td>
                                    <td>
                                        @if($saving->week == 1)
                                            ১ম সপ্তাহ
                                        @elseif($saving->week == 2)
                                            ২য় সপ্তাহ
                                        @elseif($saving->week == 3)
                                            ৩য় সপ্তাহ
                                        @elseif($saving->week == 4)
                                            ৪র্থ সপ্তাহ
                                        @endif
                                    </td>
                                    <td>৳{{ str_replace($en, $bn, number_format($saving->amount, 2)) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>
@endsection

@section('script')
    <!-- DataTables -->
    <script src="{{ asset('themes/backend/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('themes/backend/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

    <script>
        $(function () {
            $('#table-loan').DataTable({
                "order": [[ 0, "desc" ]],
            });

            $('#table-savings').DataTable({
                "order": [[ 0, "desc" ]],
            });
        })
    </script>
@endsection
