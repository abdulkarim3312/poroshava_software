@extends('layouts.app')
@section('title')
    চালান প্রিন্টঃ ভাউচার নং {{ enNumberToBn($incomeExpense->vourcher_no) }}
@endsection
@section('style')
    <style>
        .custom-check-box {
            height: calc(1.25rem + 2px);
        }

        .table-bordered thead td, .table-bordered thead th, .table-bordered body td {
            border: 1px solid #000 !important;
            vertical-align: middle;
        }
        .table-bordered td, .table-bordered th {
            border: 1px solid #000000 !important;
        }
        .chalan.table-bordered td, .chalan.table-bordered th {
            border: 1px solid #000 !important;
            vertical-align: middle;
        }

        .form-top {
            position: relative;
        }


        ul.code-list {
            list-style: none;
        }

        ul.code-list li {
            min-height: 30px;
            display: inline;
            border: 1.5px solid black !important;
            margin: 0 5px;
        }

        ul.code-list li {
            display: inline-block;
            min-width: 58.7px !important;
            height: 28px;
            margin-left: -7px;
            padding: 0;
        }

        ul.code-list {
            float: left;
        }

        .code-area span {
            float: left;
            margin-right: 15px;
        }

        .card-body.form-print-area p {
            color: black !important;
            font-size: 14px;
        }

        .code-area span {
            font-size: 19px;
        }

        .code-area {
            width: 100% !important;
        }
        ul.code-list li {
            text-align: center;
        }
        .payment-list-table td{
            padding: 3px 4px !important;
        }
        .first-code-list{
            padding-left: 1px !important;
        }
        @media print {
            .first-code-list{
                padding-left: 4px !important;
            }
            ul.code-list li {
                min-width: 62px !important;
            }
            @page {
                size: legal !important;
                margin: 0 10px 0 40px !important;
            }
        }
        .table-bordered td, .table-bordered th {
            font-size: 16px !important;
        }
        ul.code-list li {
            margin: 0 -2px;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-default">
                <div class="card-header">
                    <a href="#" onclick="getprint('printArea')" class="btn btn-success bg-gradient-success btn-sm"><i
                            class="fa fa-print"></i></a>
                </div>
                <div class="card-body form-print-area" id="printArea">
                    @if($vat)
                        <div id="vat-area" style="margin-top: 60px">
                            <div class="row">
                                <div class="col-12 form-top">
                                    <h2  class="text-center">চালান ফরম</h2>
                                    <p class="text-center" style="font-size: 18px;margin-bottom: 0;">টি,আর ফরম নং ৬ (এস, আর ৩৭ দ্রষ্টব্যঃ)</p>

                                </div>
                                <div class="col-5 offset-7">
                                    <table class="table table-bordered form-top-table">
                                        <tr>
                                            <th class="text-center" style="    padding: 4px 0;font-size: 12px;border-color: #000 !important;">১ম (মূল) কপি</th>
                                            <th class="text-center" style="    padding: 4px 0;font-size: 12px;border-color: #000 !important;">২য় কপি</th>
                                            <th class="text-center" style="    padding: 4px 0;font-size: 12px;border-color: #000 !important;">৩য় কপি</th>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-12">
                                    <p>
                                        চালান নং................................................................................তারিখঃ.................................................................................<br><br>
                                        বাংলাদেশ ব্যাংক/সোনালী ব্যাংক
                                        লিমিটেডের............................ফারিদপুর............................জেলা......................ফারিদপুর....................... শাখায়
                                        টাকা জমা দেওয়ার চালান
                                    </p>

                                    <div class="code-area">
                                        <ul class="code-list first-code-list" >
                                            <li style="min-width: 90px !important;">কোড নং</li>
                                            <li style="border-left: 0 !important;">১</li>
                                        </ul>
                                        <ul class="code-list">
                                            <li>১</li>
                                            <li style="border-left: 0 !important;">১</li>
                                            <li style="border-left: 0 !important;">৩</li>
                                            <li style="border-left: 0 !important;">৩</li>
                                        </ul>
                                        <ul class="code-list">
                                            <li>০</li>
                                            <li style="border-left: 0 !important;">০</li>
                                            <li style="border-left: 0 !important;">০</li>
                                            <li style="border-left: 0 !important;">৫</li>
                                        </ul>
                                        <ul class="code-list">
                                            <li>০</li>
                                            <li style="border-left: 0 !important;">৩</li>
                                            <li style="border-left: 0 !important;">১</li>
                                            <li style="border-left: 0 !important;">১</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <table style="font-size: 13px;" class="table chalan table-bordered">
                                <tr>
                                    <td class="text-center" colspan="4">জমা প্রদানকারী কর্তৃক পূরণ করিতে হইবে</td>
                                    <td width="20%" colspan="2" class="text-center">টাকার অংক</td>
                                    <td rowspan="3" class="text-center">বিভাগের নাম <br> এবং চালানের পৃষ্ঠাংকনকারী <br> কর্মকর্তার
                                        <br>
                                        নাম, পদবী <br> ও দপ্তর
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">যাহার মারফত প্রদত্ত হইল তাহার নাম ও ঠিকানা</td>
                                    <td class="text-center">যে ব্যাক্তির/প্রতিষ্ঠানের পক্ষ হইতে টাকা প্রদত্ত হইল তাহার নাম ও ঠিকানা
                                    </td>
                                    <td class="text-center">কি বাবদ জমা দেওয়া হইল তাহার বিবরণ</td>
                                    <td class="text-center">মুদ্রা ও নোটের বিবরণ/ড্রাফট, পে-অর্ডার ও চেকের বিবরণ</td>
                                    <td class="text-center">টাকা</td>
                                    <td class="text-center">পয়সা</td>

                                </tr>
                                <tr>
                                    <td style="" class="text-center">
                                       মেয়র, ফারিদপুর পৌরসভা।
                                    </td>
                                    <td class="text-center">
                                        {{ $incomeExpense->receiver_name }},
                                        ঠিকাদার, ফরিদপুর <br>
                                        পৌরসভা।
                                    </td>
                                    <td class="text-center">
                                       {{ $incomeExpense->khat_des }}
                                    </td>
                                    <td class="text-center">
                                        চেক নং-{{ enNumberToBn($vat->check_no) }}<br>
                                        তাং- {{ enNumberToBn(\Carbon\Carbon::parse($vat->date)->format('d/m/Y')) }}<br>
                                        সোনালি ব্যাংক লিঃ, <br>
                                        ফরিদপুর শাখা, <br>
                                        ফরিদপুর।
                                    </td>
                                    <td style="vertical-align: baseline;" class="text-center"><b>{{ enNumberToBn(number_format($vat->amount)) }}</b></td>
                                    <td style="vertical-align: baseline;" class="text-center"><b>{{ enNumberToBn(0).enNumberToBn(0) }}</b></td>
                                </tr>

                                <tr>
                                    <td style="border-top: 1px solid transparent !important;" colspan="4" class="text-right"><b>মোট টাকা</b></td>
                                    <td style="vertical-align: baseline;" class="text-center"><b>{{ enNumberToBn(number_format($vat->amount)) }}</b></td>
                                    <td style="vertical-align: baseline;" class="text-center"><b>{{ enNumberToBn(0).enNumberToBn(0) }}</b></td>
                                    <td>.</td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="padding: 4px 12px;">টাকা(কথায়়ঃ) {{ $inWordBangla->bnMoney($vat->amount) }} মাত্র</td>

                                    <td colspan="3" style="vertical-align: initial" rowspan="3" class="text-center">ম্যানেজার <br> বাংলাদেশ ব্যাংক/সোনালী
                                        ব্যাংক লিমিটেড
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 4px 12px;" colspan="4">টাকা পাওয়া গেলো</td>
                                </tr>
                                <tr>
                                    <td style="padding: 4px 12px;" colspan="4">তারিখঃ.............................................................</td>
                                </tr>
                            </table>
                        </div>
                    @endif
                    @if($tax)
                        <div style="border-top: 2px dashed #000;margin-top: 80px"></div>
                        <div id="tax-area" style="margin-top: 60px">
                            <div class="row">
                                <div class="col-12 form-top">
                                    <h2  class="text-center">চালান ফরম</h2>
                                    <p class="text-center" style="font-size: 18px;margin-bottom: 0;">টি,আর ফরম নং ৬ (এস, আর ৩৭ দ্রষ্টব্যঃ)</p>

                                </div>
                                <div class="col-5 offset-7">
                                    <table class="table table-bordered form-top-table">
                                        <tr>
                                            <th class="text-center" style="    padding: 4px 0;font-size: 12px;border-color: #000 !important;">১ম (মূল) কপি</th>
                                            <th class="text-center" style="    padding: 4px 0;font-size: 12px;border-color: #000 !important;">২য় কপি</th>
                                            <th class="text-center" style="    padding: 4px 0;font-size: 12px;border-color: #000 !important;">৩য় কপি</th>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-12">
                                    <p>
                                        চালান নং................................................................................তারিখঃ.................................................................................<br><br>
                                        বাংলাদেশ ব্যাংক/সোনালী ব্যাংক
                                        লিমিটেডের............................ফারিদপুর............................জেলা......................ফারিদপুর....................... শাখায়
                                        টাকা জমা দেওয়ার চালান
                                    </p>

                                    <div class="code-area">
                                        <ul class="code-list first-code-list" >
                                            <li style="min-width: 90px !important;">কোড নং</li>
                                            <li style="border-left: 0 !important;">১</li>
                                        </ul>
                                        <ul class="code-list">
                                            <li>১</li>
                                            <li style="border-left: 0 !important;">১</li>
                                            <li style="border-left: 0 !important;">৪</li>
                                            <li style="border-left: 0 !important;">১</li>
                                        </ul>
                                        <ul class="code-list">
                                            <li>০</li>
                                            <li style="border-left: 0 !important;">০</li>
                                            <li style="border-left: 0 !important;">১</li>
                                            <li style="border-left: 0 !important;">০</li>
                                        </ul>
                                        <ul class="code-list">
                                            <li>০</li>
                                            <li style="border-left: 0 !important;">১</li>
                                            <li style="border-left: 0 !important;">১</li>
                                            <li style="border-left: 0 !important;">১</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <table style="font-size: 13px;" class="table chalan table-bordered">
                                <tr>
                                    <td class="text-center" colspan="4">জমা প্রদানকারী কর্তৃক পূরণ করিতে হইবে</td>
                                    <td width="20%" colspan="2" class="text-center">টাকার অংক</td>
                                    <td rowspan="3" class="text-center">বিভাগের নাম <br> এবং চালানের পৃষ্ঠাংকনকারী <br> কর্মকর্তার
                                        <br>
                                        নাম, পদবী <br> ও দপ্তর
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">যাহার মারফত প্রদত্ত হইল তাহার নাম ও ঠিকানা</td>
                                    <td class="text-center">যে ব্যাক্তির/প্রতিষ্ঠানের পক্ষ হইতে টাকা প্রদত্ত হইল তাহার নাম ও ঠিকানা
                                    </td>
                                    <td class="text-center">কি বাবদ জমা দেওয়া হইল তাহার বিবরণ</td>
                                    <td class="text-center">মুদ্রা ও নোটের বিবরণ/ড্রাফট, পে-অর্ডার ও চেকের বিবরণ</td>
                                    <td class="text-center">টাকা</td>
                                    <td class="text-center">পয়সা</td>

                                </tr>
                                <tr>
                                    <td style="" class="text-center">
                                        মেয়র, ফারিদপুর পৌরসভা।
                                    </td>
                                    <td class="text-center">
                                        {{ $incomeExpense->receiver_name }},
                                        ঠিকাদার, ফরিদপুর <br>
                                        পৌরসভা।
                                    </td>
                                    <td class="text-center">
                                        {{ $incomeExpense->khat_des }}
                                    </td>
                                    <td class="text-center">
                                        চেক নং-{{ enNumberToBn($tax->check_no) }}<br>
                                        তাং- {{ enNumberToBn(\Carbon\Carbon::parse($tax->date)->format('d/m/Y')) }}<br>
                                        সোনালি ব্যাংক লিঃ, <br>
                                        ফরিদপুর শাখা, <br>
                                        ফরিদপুর।
                                    </td>
                                    <td style="vertical-align: baseline;" class="text-center"><b>{{ enNumberToBn(number_format($tax->amount)) }}</b></td>
                                    <td style="vertical-align: baseline;" class="text-center"><b>{{ enNumberToBn(0).enNumberToBn(0) }}</b></td>
                                </tr>

                                <tr>
                                    <td style="border-top: 1px solid transparent !important;" colspan="4" class="text-right"><b>মোট টাকা</b></td>
                                    <td style="vertical-align: baseline;" class="text-center"><b>{{ enNumberToBn(number_format($tax->amount)) }}</b></td>
                                    <td style="vertical-align: baseline;" class="text-center"><b>{{ enNumberToBn(0).enNumberToBn(0) }}</b></td>
                                    <td>.</td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="padding: 4px 12px;">টাকা(কথায়়ঃ) {{ $inWordBangla->bnMoney($tax->amount) }} মাত্র</td>

                                    <td colspan="3" style="vertical-align: initial" rowspan="3" class="text-center">ম্যানেজার <br> বাংলাদেশ ব্যাংক/সোনালী
                                        ব্যাংক লিমিটেড
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="padding: 4px 12px;">টাকা পাওয়া গেলো</td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="padding: 4px 12px;">তারিখঃ.............................................................</td>
                                </tr>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>


        var APP_URL = '{!! url()->full()  !!}';
        function getprint(print) {
            $('.print-heading').css('display','block');
            $('.extra_column').remove();
            $('body').html($('#' + print).html());
            window.print();
            window.location.replace(APP_URL)
        }
    </script>
@endsection
