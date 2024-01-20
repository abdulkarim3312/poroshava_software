@extends('layouts.app')
@section('title','কোষাধ্যক্ষের ক্যাশ বহি')
@section('style')
    <style>

        .table-bordered td, .table-bordered th {
            border: 1px solid #dee2e6;
            vertical-align: middle;
            border-bottom-width: 2px;
            text-align: center;
        }

        .table-bordered thead td, .table-bordered thead th {
            vertical-align: middle;
        }

        .table thead th {
            border-bottom: 1px solid #000000 !important;
        }

        .table-bordered td, .table-bordered th {
            border: 1px solid #000000 !important;
        }

        .table-bordered td, .table-bordered th {
            padding: 3px !important;
            font-size: 13px !important;
        }

        .table-bordered-modal td, .table-bordered-modal th {
            border: 1px solid #dee2e6 !important;
        }
        tr.bottom-content td {
            padding-top: 49px !important;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-outline card-default">
                <div class="card-header">
                    <h3 class="card-title">ডেটা ফিল্টারিং</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('report.treasurer_cashbook') }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="upangsho">উপাংশ <span
                                            class="text-danger">*</span></label>
                                    <select required name="upangsho" class="form-control select2" id="upangsho">
                                        <option value="">উপাংশ নির্ধারণ</option>
                                        @foreach($sections as $section)
                                            <option
                                                {{ request('upangsho') == $section->upangsho_id ? 'selected' : '' }} value="{{ $section->upangsho_id }}">{{ $section->upangsho_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tax_type">ট্যাক্স টাইপ</label>
                                    <select class="form-control select2"  id="tax_type" name="tax_type">
                                        <option value="">ট্যাক্স টাইপ নির্ধারণ</option>
                                        <option {{ request('tax_type') == 1 ? 'selected' : '' }} value="1">ট্যাক্স</option>
                                        <option {{ request('tax_type') == 2 ? 'selected' : '' }} value="2">নন-ট্যাক্স</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="start_date">শুরুর তারিখ <span class="text-danger">*</span></label>
                                    <input required type="text" id="start_date" autocomplete="off"
                                           name="start_date" class="form-control date-picker"
                                           placeholder="শুরুর তারিখ লিখুন" value="{{ request()->get('start_date') ? \Carbon\Carbon::parse(request()->get('start_date'))->format('d-m-Y') : '' }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="end_date">শেষের তারিখ <span class="text-danger">*</span></label>
                                    <input required type="text" id="end_date" autocomplete="off"
                                           name="end_date" class="form-control date-picker"
                                           placeholder="শেষের তারিখ লিখুন" value="{{ request()->get('end_date') ? \Carbon\Carbon::parse(request()->get('end_date'))->format('d-m-Y') : ''  }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <input type="submit" name="search"
                                           class="btn btn-success bg-gradient-success form-control" value="সার্চ">
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <!-- /.card -->
        </div>
        <!--/.col (left) -->
    </div>
    @if(count($taxIncomes) > 0 || count($nonTaxIncomes) > 0 || count($nonTaxIncomes2) > 0 || count($upangsho_two_in_one) > 0 || count($upangsho_two_in_two) > 0)
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-default">
                    <div class="card-header">
                        <div class="card-title">
                            কোষাধ্যক্ষের ক্যাশ বহি
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div id="printarea">
                            @if (count($taxIncomes) > 0)
                                <button type="button" class="btn btn-success btn-sm extra_column" onclick="getprint('printarea')">Print</button>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <section class="panel">

                                            <header class="panel-heading">

                                                <h4 style="text-align: center;"><strong>দোহার পৌরসভা,ফরিদপুর</strong></h4>
                                                <h4 style="text-align: center;"><strong> কোষাধ্যক্ষের ক্যাশ বহি (ফর্ম নং-৭৮ রুল-২০৩)</strong></h4>
                                                <h4 style="text-align: center;">উপাংশ ১ ( সাধারন সংস্থাপন )</h4>
                                                <h4 style="text-align: center;">ট্যাক্সেস </h4>

                                            </header>

                                            <div class="panel-body">
                                                <div class="adv-table">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <td width="8%" style="vertical-align: middle" class="text-center" rowspan="3">তারিখ</td>
                                                            <td style="vertical-align: middle" class="text-center" rowspan="3">বিবিধ রশিদ</td>
                                                            <td style="vertical-align: middle" class="text-center" rowspan="3">কাহার নিকট হতে গৃহীত</td>
                                                            <td style="vertical-align: middle" class="text-center" rowspan="3">কি বাবদ</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center" colspan="2">গৃহ ও ভূমির উপর কর</td>
                                                            <td class="text-center" colspan="2">লাইটিং রেট</td>
                                                            <td class="text-center" colspan="2">কঞ্জারভেন্সি রেট</td>
                                                            <td class="text-center" colspan="2">পানি কর</td>
                                                            <td class="text-center" colspan="5"></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">গৃহ ও ভূমির উপর কর চলতি</td>
                                                            <td class="text-center">গৃহ ও ভূমির উপর কর বকেয়া</td>
                                                            <td class="text-center">লাইটিং রেট চলতি</td>
                                                            <td class="text-center">লাইটিং রেট বকেয়া</td>
                                                            <td class="text-center">কঞ্জারভেন্সি রেট চলতি</td>
                                                            <td class="text-center">কঞ্জারভেন্সি রেট বকেয়া</td>
                                                            <td class="text-center">পানি কর (চলতি)</td>
                                                            <td class="text-center">পানি কর (বকেয়া)</td>
                                                            <td class="text-center">জরিমানা / সারচার্জ /ক্রোকিং পরওযানা</td>
                                                            <td class="text-center">ভূমি উন্নয়ন কর</td>
                                                            <td class="text-center">চালান অনুযায়ী  কোষাধ্যক্ষের জমা(মোট টাকা)</td>
                                                            <td class="text-center">চালান চেক নং</td>
                                                            <td class="text-center">মন্তব্য</td>
                                                        </tr>
                                                        <?php
                                                        $taxIncomesTotal_1 = 0;
                                                        $taxIncomesTotal_2 = 0;
                                                        $taxIncomesTotal_3 = 0;
                                                        $taxIncomesTotal_4 = 0;
                                                        $taxIncomesTotal_5 = 0;
                                                        $taxIncomesTotal_6 = 0;
                                                        $taxIncomesTotal_7 = 0;
                                                        $taxIncomesTotal_8 = 0;
                                                        $taxIncomesTotal_9 = 0;
                                                        $taxIncomesTotal_10 = 0;
                                                        ?>
                                                        @foreach($taxIncomes as $taxIncome)
                                                            <?php
                                                            $taxIncomesTotal_1 +=  $taxIncome->khat_id == 423 ? $taxIncome->amount : 0;
                                                            $taxIncomesTotal_2 +=  $taxIncome->khat_id == 424 ? $taxIncome->amount : 0;
                                                            $taxIncomesTotal_3 +=  $taxIncome->khat_id == 431 ? $taxIncome->amount : 0;
                                                            $taxIncomesTotal_4 +=  $taxIncome->khat_id == 432 ? $taxIncome->amount : 0;
                                                            $taxIncomesTotal_5 +=  $taxIncome->khat_id == 454 ? $taxIncome->amount : 0;
                                                            $taxIncomesTotal_6 +=  $taxIncome->khat_id == 455 ? $taxIncome->amount : 0;
                                                            $taxIncomesTotal_7 +=  $taxIncome->khat_id == 457 ? $taxIncome->amount : 0;
                                                            $taxIncomesTotal_8 +=  $taxIncome->khat_id == 458 ? $taxIncome->amount : 0;
                                                            $taxIncomesTotal_9 +=  $taxIncome->khat_id == 461 ? $taxIncome->amount : 0;
                                                            $taxIncomesTotal_10 +=  $taxIncome->khat_id == 474 ? $taxIncome->amount : 0;


                                                            ?>
                                                            <tr>
                                                                <td class="text-center">{{ enNumberToBn(date('d-m-Y',strtotime($taxIncome->date))) }}</td>
                                                                <td class="text-center">{{ $taxIncome->chalan_no }}</td>
                                                                <td class="text-center">{{ $taxIncome->receiver_name }}</td>
                                                                <td class="text-center">{{ $taxIncome->khat_des }}</td>
                                                                <td class="text-center">{{ $taxIncome->khat_id == 423 ? enNumberToBn(number_format($taxIncome->amount,2)) :'' }}</td>
                                                                <td class="text-center">{{ $taxIncome->khat_id == 424 ? enNumberToBn(number_format($taxIncome->amount,2)) :'' }}</td>
                                                                <td class="text-center">{{ $taxIncome->khat_id == 431 ? enNumberToBn(number_format($taxIncome->amount,2)) :'' }}</td>
                                                                <td class="text-center">{{ $taxIncome->khat_id == 432 ? enNumberToBn(number_format($taxIncome->amount,2)) :'' }}</td>
                                                                <td class="text-center">{{ $taxIncome->khat_id == 454 ? enNumberToBn(number_format($taxIncome->amount,2)) :'' }}</td>
                                                                <td class="text-center">{{ $taxIncome->khat_id == 455 ? enNumberToBn(number_format($taxIncome->amount,2)) :'' }}</td>
                                                                <td class="text-center">{{ $taxIncome->khat_id == 457 ? enNumberToBn(number_format($taxIncome->amount,2)) :'' }}</td>
                                                                <td class="text-center">{{ $taxIncome->khat_id == 458 ? enNumberToBn(number_format($taxIncome->amount,2)) :'' }}</td>
                                                                <td class="text-center">{{ $taxIncome->khat_id == 461 ? enNumberToBn(number_format($taxIncome->amount,2)) :'' }}</td>
                                                                <td class="text-center">{{ $taxIncome->khat_id == 474 ? enNumberToBn(number_format($taxIncome->amount,2)) :'' }}</td>
                                                                <td class="text-center">{{ enNumberToBn(number_format($taxIncome->amount,2)) }}</td>
                                                                <td class="text-center">{{ enNumberToBn($taxIncome->check_no) }}</td>
                                                                <td class="text-center">{{ $taxIncome->note }}</td>

                                                            </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td colspan="4" class="text-right">মোট</td>
                                                            <td>{{ enNumberToBn(number_format($taxIncomesTotal_1,2)) }}</td>
                                                            <td>{{ enNumberToBn(number_format($taxIncomesTotal_2,2)) }}</td>
                                                            <td>{{ enNumberToBn(number_format($taxIncomesTotal_3,2)) }}</td>
                                                            <td>{{ enNumberToBn(number_format($taxIncomesTotal_4,2)) }}</td>
                                                            <td>{{ enNumberToBn(number_format($taxIncomesTotal_5,2)) }}</td>
                                                            <td>{{ enNumberToBn(number_format($taxIncomesTotal_6,2)) }}</td>
                                                            <td>{{ enNumberToBn(number_format($taxIncomesTotal_7,2)) }}</td>
                                                            <td>{{ enNumberToBn(number_format($taxIncomesTotal_8,2)) }}</td>
                                                            <td>{{ enNumberToBn(number_format($taxIncomesTotal_9,2)) }}</td>
                                                            <td>{{ enNumberToBn(number_format($taxIncomesTotal_10,2)) }}</td>
                                                            <td>{{ enNumberToBn(number_format($taxIncomes->sum('amount'),2)) }}</td>
                                                            <td colspan="2"></td>
                                                        </tr>
                                                        <tr class="bottom-content">
                                                            <td class="text-center" style="border-right-color: #fff !important;" colspan="5">
                                                                কোষাধ্যক্ষ<br>
                                                                দোহার পৌরসভা
                                                            </td>
                                                            <td class="text-center" style="border-right-color: #fff !important;" colspan="4">
                                                                হিসাব রক্ষণ কর্মকর্তা / হিসাব রক্ষক<br>
                                                                দোহার পৌরসভা
                                                            </td>
                                                            <td class="text-center" style="border-right-color: #fff !important;" colspan="4">
                                                                প্রধান নির্বাহী কর্মকর্তা / সচিব<br>
                                                                দোহার পৌরসভা
                                                            </td>
                                                            <td class="text-center" colspan="4">
                                                                মেয়র<br>
                                                                দোহার পৌরসভা
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div id="printarea2">
                            @if (count($nonTaxIncomes) > 0)
                                <button type="button" class="btn btn-success btn-sm extra_column" onclick="getprint('printarea2')">Print</button>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <section class="panel">
                                            <header class="panel-heading">

                                                <h4 style="text-align: center;"><strong>দোহার পৌরসভা,ফরিদপুর</strong></h4>

                                                <h4 style="text-align: center;"><strong> কোষাধ্যক্ষের ক্যাশ বহি (ফর্ম নং-৭৮ রুল-২০৩)</strong></h4>
                                                <h4 style="text-align: center;">উপাংশ ১ ( সাধারন সংস্থাপন )</h4>
                                                <h4 style="text-align: center;">(নন-ট্যাক্সেস)রেট ,ফিস ,অন্যান্য </h4>

                                            </header>

                                            <div class="panel-body">
                                                <div class="adv-table">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <td width="8%" style="vertical-align: middle" class="text-center">তারিখ</td>
                                                            <td style="vertical-align: middle" class="text-center">বিবিধ রশিদ</td>
                                                            <td style="vertical-align: middle" class="text-center">কাহার নিকট হতে গ্রহীত</td>
                                                            <td style="vertical-align: middle" class="text-center">কি বাবদ</td>
                                                            <td style="vertical-align: middle" class="text-center">কর্মকর্তা / কর্মচারিদের বেতন-ভাতা সহায়তা</td>
                                                            <td style="vertical-align: middle" class="text-center">ইমারত নির্মাণ/পুনঃ নির্মাণ</td>
                                                            <td style="vertical-align: middle" class="text-center">পেশাঃ ব্যবসা ও কলিং</td>
                                                            <td style="vertical-align: middle" class="text-center">জন্ম বিবাহ দত্তক গ্রহণ</td>
                                                            <td style="vertical-align: middle" class="text-center">বিজ্ঞাপন</td>
                                                            <td style="vertical-align: middle" class="text-center">সিনেমা, থিয়েটার, অডিও ভিজুয়াল ও ডিস ব্যাবসা</td>
                                                            <td style="vertical-align: middle" class="text-center">যানবাহন (যান্ত্রিক যান ও নৌকা ব্যতীত)</td>
                                                            <td style="vertical-align: middle" class="text-center">জন্সেবামুলক পূর্ত কাজ</td>
                                                            <td style="vertical-align: middle" class="text-center">ট্রেড লাইসেন্স ব্যাতিত অন্যান্য</td>
                                                            <td style="vertical-align: middle" class="text-center">পশু জবাই</td>
                                                            <td style="vertical-align: middle" class="text-center">দোকান ভাড়া</td>
                                                            <td style="vertical-align: middle" class="text-center">পৌর মার্কেট সেলামি</td>
                                                            <td style="vertical-align: middle" class="text-center">মেলা , কৃষি প্রদর্শনী</td>
                                                            <td style="vertical-align: middle" class="text-center">অন্যান্য ফিস ( হোলডিং এর নাম পরিবর্তন , সীমানা নির্ধারণ সহ ইত্যাদি )</td>
                                                            <td style="vertical-align: middle" class="text-center">হাট বাজার ইজারা</td>
                                                            <td style="vertical-align: middle" class="text-center">বাস স্ট্যান্ড ইজারা</td>
                                                            <td style="vertical-align: middle" class="text-center">পুকুর / ফেরিঘাট / টয়লেট ইজারা</td>
                                                            <td style="vertical-align: middle" class="text-center">কবরস্তান / শ্মাশান ঘাট</td>
                                                            <td style="vertical-align: middle" class="text-center">চালান অনুযায়ী  কোষাধ্যক্ষের জমা(মোট টাকা)</td>
                                                            <td style="vertical-align: middle" class="text-center">চালান চেক নং</td>
                                                            <td style="vertical-align: middle" class="text-center">মন্তব্য</td>
                                                        </tr>
                                                        <?php
                                                        $nonTaxIncomes_1 = 0;
                                                        $nonTaxIncomes_2 = 0;
                                                        $nonTaxIncomes_3 = 0;
                                                        $nonTaxIncomes_4 = 0;
                                                        $nonTaxIncomes_5 = 0;
                                                        $nonTaxIncomes_6 = 0;
                                                        $nonTaxIncomes_7 = 0;
                                                        $nonTaxIncomes_8 = 0;
                                                        $nonTaxIncomes_9 = 0;
                                                        $nonTaxIncomes_10 = 0;
                                                        $nonTaxIncomes_11 = 0;
                                                        $nonTaxIncomes_12 = 0;
                                                        $nonTaxIncomes_13 = 0;
                                                        $nonTaxIncomes_14 = 0;
                                                        $nonTaxIncomes_15 = 0;
                                                        $nonTaxIncomes_16 = 0;
                                                        $nonTaxIncomes_17 = 0;
                                                        $nonTaxIncomes_18 = 0;
                                                        ?>

                                                        @foreach($nonTaxIncomes as $nonTaxIncome)
                                                            <?php

                                                            $nonTaxIncomes_1 += $nonTaxIncome->khat_id == 450 ? $nonTaxIncome->amount :0;
                                                            $nonTaxIncomes_2 += $nonTaxIncome->khat_id == 425 ? $nonTaxIncome->amount :0;
                                                            $nonTaxIncomes_3 += $nonTaxIncome->khat_id == 426 ? $nonTaxIncome->amount :0;
                                                            $nonTaxIncomes_4 += $nonTaxIncome->khat_id == 427 ? $nonTaxIncome->amount :0;
                                                            $nonTaxIncomes_5 += $nonTaxIncome->khat_id == 428 ? $nonTaxIncome->amount :0;
                                                            $nonTaxIncomes_6 += $nonTaxIncome->khat_id == 430 ? $nonTaxIncome->amount :0;
                                                            $nonTaxIncomes_7 += $nonTaxIncome->khat_id == 456 ? $nonTaxIncome->amount :0;
                                                            $nonTaxIncomes_8 += $nonTaxIncome->khat_id == 460 ? $nonTaxIncome->amount :0;
                                                            $nonTaxIncomes_9 += $nonTaxIncome->khat_id == 433 ? $nonTaxIncome->amount :0;
                                                            $nonTaxIncomes_10 += $nonTaxIncome->khat_id == 434 ? $nonTaxIncome->amount :0;
                                                            $nonTaxIncomes_11 += $nonTaxIncome->khat_id == 442 ? $nonTaxIncome->amount :0;
                                                            $nonTaxIncomes_12 += $nonTaxIncome->khat_id == 435 ? $nonTaxIncome->amount :0;
                                                            $nonTaxIncomes_13 += $nonTaxIncome->khat_id == 436 ? $nonTaxIncome->amount :0;
                                                            $nonTaxIncomes_14 += $nonTaxIncome->khat_id == 437 ? $nonTaxIncome->amount :0;
                                                            $nonTaxIncomes_15 += $nonTaxIncome->khat_id == 438 ? $nonTaxIncome->amount :0;
                                                            $nonTaxIncomes_16 += $nonTaxIncome->khat_id == 439 ? $nonTaxIncome->amount :0;
                                                            $nonTaxIncomes_17 += $nonTaxIncome->khat_id == 467 ? $nonTaxIncome->amount :0;
                                                            $nonTaxIncomes_18 += $nonTaxIncome->khat_id == 440 ? $nonTaxIncome->amount :0;

                                                            ?>
                                                            <tr>
                                                                <td class="text-center">{{ enNumberToBn(date('d-m-Y',strtotime($nonTaxIncome->date))) }}</td>
                                                                <td class="text-center">{{ enNumberToBn($nonTaxIncome->chalan_no) }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->receiver_name }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->khat_des }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->khat_id == 450 ? enNumberToBn(number_format($nonTaxIncome->amount),2) :'' }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->khat_id == 425 ? enNumberToBn(number_format($nonTaxIncome->amount),2) :'' }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->khat_id == 426 ? enNumberToBn(number_format($nonTaxIncome->amount),2) :'' }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->khat_id == 427 ? enNumberToBn(number_format($nonTaxIncome->amount),2) :'' }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->khat_id == 428 ? enNumberToBn(number_format($nonTaxIncome->amount),2) :'' }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->khat_id == 430 ? enNumberToBn(number_format($nonTaxIncome->amount),2) :'' }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->khat_id == 456 ? enNumberToBn(number_format($nonTaxIncome->amount),2) :'' }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->khat_id == 460 ? enNumberToBn(number_format($nonTaxIncome->amount),2) :'' }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->khat_id == 433 ? enNumberToBn(number_format($nonTaxIncome->amount),2) :'' }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->khat_id == 434 ? enNumberToBn(number_format($nonTaxIncome->amount),2) :'' }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->khat_id == 442 ? enNumberToBn(number_format($nonTaxIncome->amount),2) :'' }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->khat_id == 435 ? enNumberToBn(number_format($nonTaxIncome->amount),2) :'' }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->khat_id == 436 ? enNumberToBn(number_format($nonTaxIncome->amount),2) :'' }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->khat_id == 437 ? enNumberToBn(number_format($nonTaxIncome->amount),2) :'' }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->khat_id == 438 ? enNumberToBn(number_format($nonTaxIncome->amount),2) :'' }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->khat_id == 439 ? enNumberToBn(number_format($nonTaxIncome->amount),2) :'' }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->khat_id == 467 ? enNumberToBn(number_format($nonTaxIncome->amount),2) :'' }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->khat_id == 440 ? enNumberToBn(number_format($nonTaxIncome->amount),2) :'' }}</td>
                                                                <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncome->amount,2)) }}</td>
                                                                <td class="text-center">{{ enNumberToBn($nonTaxIncome->check_no) }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->note }}</td>

                                                            </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td colspan="4" class="text-right">মোট</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncomes_1,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncomes_2,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncomes_3,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncomes_4,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncomes_5,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncomes_6,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncomes_7,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncomes_8,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncomes_9,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncomes_10,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncomes_11,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncomes_12,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncomes_13,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncomes_14,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncomes_15,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncomes_16,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncomes_17,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncomes_18,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncomes->sum('amount'),2)) }}</td>
                                                            <td colspan="2"></td>
                                                        </tr>
                                                        <tr class="bottom-content">
                                                            <td class="text-center" style="border-right-color: #fff !important;" colspan="7">
                                                                কোষাধ্যক্ষ<br>
                                                                দোহার পৌরসভা
                                                            </td>
                                                            <td class="text-center" style="border-right-color: #fff !important;" colspan="6">
                                                                হিসাব রক্ষণ কর্মকর্তা / হিসাব রক্ষক<br>
                                                                দোহার পৌরসভা
                                                            </td>
                                                            <td class="text-center" style="border-right-color: #fff !important;" colspan="6">
                                                                প্রধান নির্বাহী কর্মকর্তা / সচিব<br>
                                                                দোহার পৌরসভা
                                                            </td>
                                                            <td class="text-center" colspan="6">
                                                                মেয়র<br>
                                                                দোহার পৌরসভা
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div id="printarea3">
                            @if (count($nonTaxIncomes2) > 0)
                                <button type="button" class="btn btn-success btn-sm extra_column" onclick="getprint('printarea3')">Print</button>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <section class="panel">

                                            <header class="panel-heading">

                                                <h4 style="text-align: center;"><strong>দোহার পৌরসভা,ফরিদপুর</strong></h4>

                                                <h4 style="text-align: center;"><strong> কোষাধ্যক্ষের ক্যাশ বহি</strong></h4>
                                                <h4 style="text-align: center;">উপাংশ ১ ( সাধারন সংস্থাপন )</h4>
                                                <h4 style="text-align: center;">(নন-ট্যাক্সেস)রেট ,ফিস ,অন্যান্য </h4>

                                            </header>

                                            <div class="panel-body">
                                                <div class="adv-table">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <td width="8%" style="vertical-align: middle" class="text-center">তারিখ</td>
                                                            <td style="vertical-align: middle" class="text-center">বিবিধ রশিদ</td>
                                                            <td style="vertical-align: middle" class="text-center">কাহার নিকট হতে গ্রহীত</td>
                                                            <td style="vertical-align: middle" class="text-center">কি বাবদ</td>
                                                            <td style="vertical-align: middle" class="text-center">রোড রোলারসহ অন্যান্য যানবাহন ভাড়া</td>
                                                            <td style="vertical-align: middle" class="text-center">পৌর সম্পত্তি ভাড়া(জায়গা)</td>
                                                            <td style="vertical-align: middle" class="text-center">বিভিন্ন সংস্থা / ব্যাক্তি কর্তৃক রাস্তা কর্তনের জন্য ক্ষতিপুরন</td>
                                                            <td style="vertical-align: middle" class="text-center">বিভিন্ন সার্টিফিকেট</td>
                                                            <td style="vertical-align: middle" class="text-center">বিভিন্ন ফরম</td>
                                                            <td style="vertical-align: middle" class="text-center">দরপত্র</td>
                                                            <td style="vertical-align: middle" class="text-center">সারচার্জ</td>
                                                            <td style="vertical-align: middle" class="text-center">সেফটিট্যাংক পরিস্কার ফি সহ</td>
                                                            <td style="vertical-align: middle" class="text-center">ইপিআই</td>
                                                            <td style="vertical-align: middle" class="text-center">হল ভাড়া</td>
                                                            <td style="vertical-align: middle" class="text-center">পুরাতন ভবন / পুরাতান মালামাল নিলামে বিক্রয়</td>
                                                            <td style="vertical-align: middle" class="text-center">টয়লেট ইজারা</td>
                                                            <td style="vertical-align: middle" class="text-center">টোল আদায় / ইজারা</td>
                                                            <td style="vertical-align: middle" class="text-center">ডিজিএফ পরিবহন বাবদ আয়</td>
                                                            <td style="vertical-align: middle" class="text-center">শিশু পার্কের ভাড়া</td>
                                                            <td style="vertical-align: middle" class="text-center">উন্নয়ন খাত বাতিত সরকারী অনুদান</td>
                                                            <td style="vertical-align: middle" class="text-center">জন্ম মৃত্যু নিবন্ধনের জন্য খরচ বাবদ বরাদ্দ</td>
                                                            <td style="vertical-align: middle" class="text-center">বিদ্যালয়</td>
                                                            <td style="vertical-align: middle" class="text-center">অন্যান্য</td>
                                                            <td style="vertical-align: middle" class="text-center">চালান অনুযায়ী  কোষাধ্যক্ষের জমা(মোট টাকা)</td>
                                                            <td style="vertical-align: middle" class="text-center">চালান চেক নং</td>
                                                            <td style="vertical-align: middle" class="text-center">মন্তব্য</td>
                                                        </tr>
                                                        <?php
                                                        $nonTaxIncomes2_1 = 0;
                                                        $nonTaxIncomes2_1_2 = 0;
                                                        $nonTaxIncomes2_1_3 = 0;
                                                        $nonTaxIncomes2_2 = 0;
                                                        $nonTaxIncomes2_3 = 0;
                                                        $nonTaxIncomes2_4 = 0;
                                                        $nonTaxIncomes2_5 = 0;
                                                        $nonTaxIncomes2_6 = 0;
                                                        $nonTaxIncomes2_7 = 0;
                                                        $nonTaxIncomes2_8 = 0;
                                                        $nonTaxIncomes2_9 = 0;
                                                        $nonTaxIncomes2_10 = 0;
                                                        $nonTaxIncomes2_11 = 0;
                                                        $nonTaxIncomes2_12 = 0;
                                                        $nonTaxIncomes2_13 = 0;
                                                        $nonTaxIncomes2_14 = 0;
                                                        $nonTaxIncomes2_15 = 0;
                                                        $nonTaxIncomes2_16 = 0;
                                                        $nonTaxIncomes2_17 = 0;
                                                        // $nonTaxIncomes2_18 = 0;
                                                        ?>
                                                        @foreach($nonTaxIncomes2 as $nonTaxIncome)
                                                            <?php

                                                            $nonTaxIncomes2_1 += $nonTaxIncome->khat_id == 441 ? $nonTaxIncome->amount :0;
                                                            $nonTaxIncomes2_1_2 += $nonTaxIncome->khat_id == 468 ? $nonTaxIncome->amount :0;
                                                            $nonTaxIncomes2_1_3 += $nonTaxIncome->khat_id == 443 ? $nonTaxIncome->amount :0;
                                                            $nonTaxIncomes2_2 += $nonTaxIncome->khat_id == 444 ? $nonTaxIncome->amount :0;
                                                            $nonTaxIncomes2_3 += $nonTaxIncome->khat_id == 445 ? $nonTaxIncome->amount :0;
                                                            $nonTaxIncomes2_4 += $nonTaxIncome->khat_id == 446 ? $nonTaxIncome->amount :0;
                                                            $nonTaxIncomes2_5 += $nonTaxIncome->khat_id == 429 ? $nonTaxIncome->amount :0;
                                                            $nonTaxIncomes2_6 += $nonTaxIncome->khat_id == 469 ? $nonTaxIncome->amount :0;
                                                            $nonTaxIncomes2_7 += $nonTaxIncome->khat_id == 447 ? $nonTaxIncome->amount :0;
                                                            $nonTaxIncomes2_8 += $nonTaxIncome->khat_id == 448 ? $nonTaxIncome->amount :0;
                                                            $nonTaxIncomes2_9 += $nonTaxIncome->khat_id == 466 ? $nonTaxIncome->amount :0;
                                                            $nonTaxIncomes2_10 += $nonTaxIncome->khat_id == 470 ? $nonTaxIncome->amount :0;
                                                            $nonTaxIncomes2_11 += $nonTaxIncome->khat_id == 471 ? $nonTaxIncome->amount :0;
                                                            $nonTaxIncomes2_12 += $nonTaxIncome->khat_id == 472 ? $nonTaxIncome->amount :0;
                                                            $nonTaxIncomes2_13 += $nonTaxIncome->khat_id == 477 ? $nonTaxIncome->amount :0;
                                                            $nonTaxIncomes2_14 += $nonTaxIncome->khat_id == 464 ? $nonTaxIncome->amount :0;
                                                            $nonTaxIncomes2_15 += $nonTaxIncome->khat_id == 462 ? $nonTaxIncome->amount :0;
                                                            $nonTaxIncomes2_16 += $nonTaxIncome->khat_id == 463 ? $nonTaxIncome->amount :0;
                                                            $nonTaxIncomes2_17 += $nonTaxIncome->khat_id == 465 ? $nonTaxIncome->amount :0;

                                                            ?>
                                                            <tr>
                                                                <td class="text-center">{{ enNumberToBn(date('d-m-Y',strtotime($nonTaxIncome->date))) }}</td>
                                                                <td class="text-center">{{ enNumberToBn($nonTaxIncome->chalan_no) }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->receiver_name }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->khat_des }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->khat_id == 441 ? enNumberToBn(number_format($nonTaxIncome->amount,2)) :'' }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->khat_id == 468 ? enNumberToBn(number_format($nonTaxIncome->amount,2)) :'' }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->khat_id == 443 ? enNumberToBn(number_format($nonTaxIncome->amount,2)) :'' }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->khat_id == 444 ? enNumberToBn(number_format($nonTaxIncome->amount,2)) :'' }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->khat_id == 445 ? enNumberToBn(number_format($nonTaxIncome->amount,2)) :'' }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->khat_id == 446 ? enNumberToBn(number_format($nonTaxIncome->amount,2)) :'' }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->khat_id == 429 ? enNumberToBn(number_format($nonTaxIncome->amount,2)) :'' }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->khat_id == 469 ? enNumberToBn(number_format($nonTaxIncome->amount,2)) :'' }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->khat_id == 447 ? enNumberToBn(number_format($nonTaxIncome->amount,2)) :'' }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->khat_id == 448 ? enNumberToBn(number_format($nonTaxIncome->amount,2)) :'' }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->khat_id == 466 ? enNumberToBn(number_format($nonTaxIncome->amount,2)) :'' }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->khat_id == 470 ? enNumberToBn(number_format($nonTaxIncome->amount,2)) :'' }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->khat_id == 471 ? enNumberToBn(number_format($nonTaxIncome->amount,2)) :'' }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->khat_id == 472 ? enNumberToBn(number_format($nonTaxIncome->amount,2)) :'' }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->khat_id == 477 ? enNumberToBn(number_format($nonTaxIncome->amount,2)) :'' }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->khat_id == 464 ? enNumberToBn(number_format($nonTaxIncome->amount,2)) :'' }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->khat_id == 462 ? enNumberToBn(number_format($nonTaxIncome->amount,2)) :'' }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->khat_id == 463 ? enNumberToBn(number_format($nonTaxIncome->amount,2)) :'' }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->khat_id == 465 ? enNumberToBn(number_format($nonTaxIncome->amount,2)) :'' }}</td>
                                                                <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncome->amount,2)) }}</td>
                                                                <td class="text-center">{{ enNumberToBn($nonTaxIncome->check_no) }}</td>
                                                                <td class="text-center">{{ $nonTaxIncome->note }}</td>

                                                            </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td colspan="4" class="text-right">মোট</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncomes2_1,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncomes2_1_2,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncomes2_1_3,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncomes2_2,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncomes2_3,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncomes2_4,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncomes2_5,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncomes2_6,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncomes2_7,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncomes2_8,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncomes2_9,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncomes2_10,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncomes2_11,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncomes2_12,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncomes2_13,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncomes2_14,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncomes2_15,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncomes2_16,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncomes2_17,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($nonTaxIncomes2->sum('amount'),2)) }}</td>
                                                            <td colspan="2"></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" class="text-right">সর্বমোট</td>
                                                            <td colspan="19" class="text-right">
                                                                @if (count($nonTaxIncomes) > 0)
                                                                    {{ enNumberToBn(number_format($nonTaxIncomes->sum('amount'),2)).'+'.enNumberToBn(number_format($nonTaxIncomes2->sum('amount'),2)) }} =

                                                                @else
                                                                    {{ enNumberToBn(number_format('0 +'.$nonTaxIncomes2->sum('amount'),2))  }} =
                                                                @endif

                                                            </td>
                                                            <td class="text-center">
                                                                @if (count($nonTaxIncomes) > 0)
                                                                    {{ enNumberToBn(number_format($nonTaxIncomes->sum('amount') + $nonTaxIncomes2->sum('amount'),2))  }}

                                                                @else
                                                                    {{ enNumberToBn(number_format($nonTaxIncomes2->sum('amount'),2))  }}

                                                                @endif
                                                            </td>
                                                            <td colspan="2"></td>
                                                        </tr>

                                                        <tr class="bottom-content">
                                                            <td class="text-center" style="border-right-color: #fff !important;" colspan="7">
                                                                কোষাধ্যক্ষ<br>
                                                                দোহার পৌরসভা
                                                            </td>
                                                            <td class="text-center" style="border-right-color: #fff !important;" colspan="6">
                                                                হিসাব রক্ষণ কর্মকর্তা / হিসাব রক্ষক<br>
                                                                দোহার পৌরসভা
                                                            </td>
                                                            <td class="text-center" style="border-right-color: #fff !important;" colspan="6">
                                                                প্রধান নির্বাহী কর্মকর্তা / সচিব<br>
                                                                দোহার পৌরসভা
                                                            </td>
                                                            <td class="text-center" colspan="7">
                                                                মেয়র<br>
                                                                দোহার পৌরসভা
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div id="printarea4">
                            @if (count($upangsho_two_in_one) > 0)
                                <button type="button" class="btn btn-success btn-sm extra_column" onclick="getprint('printarea4')">Print</button>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <section class="panel">

                                            <header class="panel-heading">

                                                <h4 style="text-align: center;"><strong>দোহার পৌরসভা,ফরিদপুর</strong></h4>

                                                <h4 style="text-align: center;"><strong> কোষাধ্যক্ষের ক্যাশ বহি(ফর্ম নং-৭৮ রুল-২০৩)</strong></h4>
                                                <h4 style="text-align: center;">উপাংশ ২ (পানি সরবরাহ)</h4>
                                                <h4 style="text-align: center;">পানি সরবরাহ</h4>

                                            </header>

                                            <div class="panel-body">
                                                <div class="adv-table">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <td width="8%" style="vertical-align: middle" class="text-center">তারিখ</td>
                                                            <td style="vertical-align: middle" class="text-center">বিবিধ রশিদ</td>
                                                            <td style="vertical-align: middle" class="text-center">কাহার নিকট হতে গ্রহীত</td>
                                                            <td style="vertical-align: middle" class="text-center">কি বাবদ</td>
                                                            <td style="vertical-align: middle" class="text-center">পৌরকর হইতে প্রাপ্ত পানিকর ( চলতি )</td>
                                                            <td style="vertical-align: middle" class="text-center">পৌরকর হইতে প্রাপ্ত পানিকর ( বকেয়া ) </td>
                                                            <td style="vertical-align: middle" class="text-center">সংযোগ ফিস</td>
                                                            <td style="vertical-align: middle" class="text-center">পুনঃ সংযোগ ফিস</td>
                                                            <td style="vertical-align: middle" class="text-center">সারচার্জ</td>
                                                            <td style="vertical-align: middle" class="text-center">চালান অনুযায়ী  কোষাধ্যক্ষের জমা(মোট টাকা)</td>
                                                            <td style="vertical-align: middle" class="text-center">চালান চেক নং</td>
                                                            <td style="vertical-align: middle" class="text-center">মন্তব্য</td>
                                                        </tr>
                                                        <?php
                                                        $upangsho_two_in_one_1 = 0;
                                                        $upangsho_two_in_one_2 = 0;
                                                        $upangsho_two_in_one_3 = 0;
                                                        $upangsho_two_in_one_4 = 0;
                                                        $upangsho_two_in_one_5 = 0;


                                                        ?>
                                                        @foreach($upangsho_two_in_one as $upangsho_two_in_one_item)
                                                            <?php

                                                            $upangsho_two_in_one_1 += $upangsho_two_in_one_item->khat_id == 418 ? $upangsho_two_in_one_item->amount : 0;
                                                            $upangsho_two_in_one_2 += $upangsho_two_in_one_item->khat_id == 419 ? $upangsho_two_in_one_item->amount : 0;
                                                            $upangsho_two_in_one_3 += $upangsho_two_in_one_item->khat_id == 420 ? $upangsho_two_in_one_item->amount : 0;
                                                            $upangsho_two_in_one_4 += $upangsho_two_in_one_item->khat_id == 421 ? $upangsho_two_in_one_item->amount : 0;
                                                            $upangsho_two_in_one_5 += $upangsho_two_in_one_item->khat_id == 422 ? $upangsho_two_in_one_item->amount : 0;
                                                            ?>
                                                            <tr>
                                                                <td class="text-center">{{ enNumberToBn(date('d-m-Y',strtotime($upangsho_two_in_one_item->date))) }}</td>
                                                                <td class="text-center">{{ enNumberToBn($upangsho_two_in_one_item->chalan_no) }}</td>
                                                                <td class="text-center">{{ $upangsho_two_in_one_item->receiver_name }}</td>
                                                                <td class="text-center">{{ $upangsho_two_in_one_item->khat_des }}</td>
                                                                <td class="text-center">{{ $upangsho_two_in_one_item->khat_id == 418 ? enNumberToBn(number_format($upangsho_two_in_one_item->amount,2)) :'' }}</td>
                                                                <td class="text-center">{{ $upangsho_two_in_one_item->khat_id == 419 ? enNumberToBn(number_format($upangsho_two_in_one_item->amount,2)) :'' }}</td>
                                                                <td class="text-center">{{ $upangsho_two_in_one_item->khat_id == 420 ? enNumberToBn(number_format($upangsho_two_in_one_item->amount,2)) :'' }}</td>
                                                                <td class="text-center">{{ $upangsho_two_in_one_item->khat_id == 421 ? enNumberToBn(number_format($upangsho_two_in_one_item->amount,2)) :'' }}</td>
                                                                <td class="text-center">{{ $upangsho_two_in_one_item->khat_id == 422 ? enNumberToBn(number_format($upangsho_two_in_one_item->amount,2)) :'' }}</td>
                                                                <td class="text-center">{{ enNumberToBn(number_format($upangsho_two_in_one_item->amount,2)) }}</td>
                                                                <td class="text-center">{{ enNumberToBn($upangsho_two_in_one_item->check_no) }}</td>
                                                                <td class="text-center">{{ $upangsho_two_in_one_item->note }}</td>

                                                            </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td colspan="4" class="text-right">মোট</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($upangsho_two_in_one_1,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($upangsho_two_in_one_2,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($upangsho_two_in_one_3,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($upangsho_two_in_one_4,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($upangsho_two_in_one_5,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($upangsho_two_in_one->sum('amount'),2)) }}</td>
                                                            <td colspan="2"></td>
                                                        </tr>
                                                        <tr class="bottom-content">
                                                            <td class="text-center" style="border-right-color: #fff !important;" colspan="3">
                                                                কোষাধ্যক্ষ<br>
                                                                দোহার পৌরসভা
                                                            </td>
                                                            <td class="text-center" style="border-right-color: #fff !important;" colspan="3">
                                                                হিসাব রক্ষণ কর্মকর্তা / হিসাব রক্ষক<br>
                                                                দোহার পৌরসভা
                                                            </td>
                                                            <td class="text-center" style="border-right-color: #fff !important;" colspan="3">
                                                                প্রধান নির্বাহী কর্মকর্তা / সচিব<br>
                                                                দোহার পৌরসভা
                                                            </td>
                                                            <td class="text-center" colspan="3">
                                                                মেয়র<br>
                                                                দোহার পৌরসভা
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div id="printarea5">
                            @if (count($upangsho_two_in_two) > 0)
                                <button type="button" class="btn btn-success btn-sm extra_column" onclick="getprint('printarea5')">Print</button>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <section class="panel">

                                            <header class="panel-heading">

                                                <h4 style="text-align: center;"><strong>দোহার পৌরসভা,ফরিদপুর</strong></h4>

                                                <h4 style="text-align: center;"><strong> কোষাধ্যক্ষের ক্যাশ বহি</strong></h4>
                                                <h4 style="text-align: center;">উপাংশ ২ (পানি সরবরাহ)</h4>
                                                <h4 style="text-align: center;">পানি সরবরাহ</h4>

                                            </header>

                                            <div class="panel-body">
                                                <div class="adv-table">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <td width="8%" style="vertical-align: middle" class="text-center">তারিখ</td>
                                                            <td style="vertical-align: middle" class="text-center">বিবিধ রশিদ</td>
                                                            <td style="vertical-align: middle" class="text-center">কাহার নিকট হতে গ্রহীত</td>
                                                            <td style="vertical-align: middle" class="text-center">কি বাবদ</td>
                                                            <td style="vertical-align: middle" class="text-center">ফরম বিক্রয়</td>
                                                            <td style="vertical-align: middle" class="text-center">পানি সরবরাহ বিল (ট্যারিফ) চলতি</td>
                                                            <td style="vertical-align: middle" class="text-center">পানি সরবরাহ বিল (ট্যারিফ) বকেয়া</td>
                                                            <td style="vertical-align: middle" class="text-center">পানির মিটার বাবদ</td>
                                                            <td style="vertical-align: middle" class="text-center">অন্যান্য</td>
                                                            <td style="vertical-align: middle" class="text-center">চালান অনুযায়ী  কোষাধ্যক্ষের জমা(মোট টাকা)</td>
                                                            <td style="vertical-align: middle" class="text-center">চালান চেক নং</td>
                                                            <td style="vertical-align: middle" class="text-center">মন্তব্য</td>
                                                        </tr>
                                                        <?php
                                                        $upangsho_two_in_two_1 = 0;
                                                        $upangsho_two_in_two_2 = 0;
                                                        $upangsho_two_in_two_3 = 0;
                                                        $upangsho_two_in_two_4 = 0;
                                                        $upangsho_two_in_two_5 = 0;

                                                        ?>
                                                        @foreach($upangsho_two_in_two as $upangsho_two_in_two_item)
                                                            <?php
                                                            $upangsho_two_in_two_1 += $upangsho_two_in_two_item->khat_id == 449 ? $upangsho_two_in_two_item->amount : 0;
                                                            $upangsho_two_in_two_2 += $upangsho_two_in_two_item->khat_id == 451 ? $upangsho_two_in_two_item->amount : 0;
                                                            $upangsho_two_in_two_3 += $upangsho_two_in_two_item->khat_id == 452 ? $upangsho_two_in_two_item->amount : 0;
                                                            $upangsho_two_in_two_4 += $upangsho_two_in_two_item->khat_id == 453 ? $upangsho_two_in_two_item->amount : 0;
                                                            $upangsho_two_in_two_5 += $upangsho_two_in_two_item->khat_id == 459 ? $upangsho_two_in_two_item->amount : 0;
                                                            ?>
                                                            <tr>
                                                                <td class="text-center">{{ enNumberToBn(date('d-m-Y',strtotime($upangsho_two_in_two_item->date)))  }}</td>
                                                                <td class="text-center">{{ enNumberToBn($upangsho_two_in_two_item->chalan_no) }}</td>
                                                                <td class="text-center">{{ $upangsho_two_in_two_item->receiver_name }}</td>
                                                                <td class="text-center">{{ $upangsho_two_in_two_item->khat_des }}</td>
                                                                <td class="text-center">{{ $upangsho_two_in_two_item->khat_id == 449 ? enNumberToBn(number_format($upangsho_two_in_two_item->amount),2) :'' }}</td>
                                                                <td class="text-center">{{ $upangsho_two_in_two_item->khat_id == 451 ? enNumberToBn(number_format($upangsho_two_in_two_item->amount),2) :'' }}</td>
                                                                <td class="text-center">{{ $upangsho_two_in_two_item->khat_id == 452 ? enNumberToBn(number_format($upangsho_two_in_two_item->amount),2) :'' }}</td>
                                                                <td class="text-center">{{ $upangsho_two_in_two_item->khat_id == 453 ? enNumberToBn(number_format($upangsho_two_in_two_item->amount),2) :'' }}</td>
                                                                <td class="text-center">{{ $upangsho_two_in_two_item->khat_id == 459 ? enNumberToBn(number_format($upangsho_two_in_two_item->amount),2) :'' }}</td>
                                                                <td class="text-center">{{ enNumberToBn(number_format($upangsho_two_in_two_item->amount,2)) }}</td>
                                                                <td class="text-center">{{ enNumberToBn($upangsho_two_in_two_item->check_no) }}</td>
                                                                <td class="text-center">{{ $upangsho_two_in_two_item->note }}</td>

                                                            </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td colspan="4" class="text-right">মোট</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($upangsho_two_in_two_1,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($upangsho_two_in_two_2,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($upangsho_two_in_two_3,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($upangsho_two_in_two_4,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($upangsho_two_in_two_5,2)) }}</td>
                                                            <td class="text-center">{{ enNumberToBn(number_format($upangsho_two_in_two->sum('amount'),2))  }}</td>
                                                            <td colspan="2"></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" class="text-right">সর্বমোট</td>

                                                            <td colspan="5" class="text-right">(ট্যাক্স + নন ট্যাক্স)
                                                                @if (count($upangsho_two_in_one) > 0)
                                                                    {{enNumberToBn(number_format($upangsho_two_in_one->sum('amount'),2)).'+'.enNumberToBn(number_format($upangsho_two_in_two->sum('amount'),2))}} =
                                                                @else
                                                                    {{ enNumberToBn(0).' + '.enNumberToBn(number_format($upangsho_two_in_two->sum('amount'),2))  }} =

                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                @if (count($upangsho_two_in_one) > 0)
                                                                    {{ enNumberToBn(number_format($upangsho_two_in_one->sum('amount') + $upangsho_two_in_two->sum('amount'),2))  }}
                                                                @else
                                                                    {{ enNumberToBn(number_format($upangsho_two_in_two->sum('amount'),2)) }}
                                                                @endif
                                                            </td>
                                                            <td colspan="2"></td>
                                                        </tr>
                                                        <tr class="bottom-content">
                                                            <td class="text-center" style="border-right-color: #fff !important;" colspan="3">
                                                                কোষাধ্যক্ষ<br>
                                                                দোহার পৌরসভা
                                                            </td>
                                                            <td class="text-center" style="border-right-color: #fff !important;" colspan="3">
                                                                হিসাব রক্ষণ কর্মকর্তা / হিসাব রক্ষক<br>
                                                                দোহার পৌরসভা
                                                            </td>
                                                            <td class="text-center" style="border-right-color: #fff !important;" colspan="3">
                                                                প্রধান নির্বাহী কর্মকর্তা / সচিব<br>
                                                                দোহার পৌরসভা
                                                            </td>
                                                            <td class="text-center" colspan="3">
                                                                মেয়র<br>
                                                                দোহার পৌরসভা
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            @endif
                        </div>


                    </div>
                </div>
            </div>
        </div>
    @else
        @if(request('start_date'))
            <div class="alert alert-warning text-center"><h4>কোনো তথ্য পাওয়া যায়নি !</h4></div>
        @endif
    @endif
@endsection
@section('script')
    <script>
        $(function () {

        })
        var APP_URL = '{!! url()->full()  !!}';
        function getprint(print) {
            $('.print-heading').css('display', 'block');
            $('.extra_column').remove();
            $('body').html($('#' + print).html());
            window.print();
            window.location.replace(APP_URL)
        }
    </script>
@endsection
