@extends('layouts.app')
@section('title','ক্যাশবই')
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
            font-size: 15px !important;
        }

        .table-bordered-modal td, .table-bordered-modal th {
            border: 1px solid #dee2e6 !important;
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
                <form action="{{ route('report.cashbook') }}">
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
                                    <label for="start_date">শুরুর তারিখ <span class="text-danger">*</span></label>
                                    <input required type="text" id="start_date" autocomplete="off"
                                           name="start_date" class="form-control date-picker"
                                           placeholder="শুরুর তারিখ লিখুন" value="{{ request()->get('start_date')  }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="end_date">শেষের তারিখ <span class="text-danger">*</span></label>
                                    <input required type="text" id="end_date" autocomplete="off"
                                           name="end_date" class="form-control date-picker"
                                           placeholder="শেষের তারিখ লিখুন" value="{{ request()->get('end_date')  }}">
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
    @if(count($expenses) > 0 || count($incomes) > 0)
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-default">
                    <div class="card-header">
                        <a href="#" onclick="getprint('printArea')"
                           class="btn btn-success bg-gradient-success btn-sm"><i
                                class="fa fa-print"></i></a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive-sm" id="printArea">
                            <div class="row print-heading">
                                <div class="col-12">
                                    <h1 class="text-center m-0" style="font-size: 20px !important;font-weight: bold">
                                        <img height="50px"
                                             src="{{ asset('img/logo.png') }}"
                                             alt="">
                                        {{ config('app.full_name') }}
                                    </h1>
                                    <h3 class="text-center m-0 mb-2" style="font-size: 19px !important;">ক্যাশবই</h3>
                                    <h3 class="text-center m-0 mb-2" style="font-size: 19px !important;">ফরম নং -
                                        ৮৩</h3>
                                    <h3 class="text-center m-0 mb-2"
                                        style="font-size: 19px !important;">{{ $selectUpangsho->upangsho_name }}</h3>
                                    <h3 class="text-center m-0 mb-2" style="font-size: 19px !important;">
                                        সময়কালঃ {{ enNumberToBn(\Carbon\Carbon::parse(request('start_date'))->format('d/m/Y')) }}
                                        - {{ enNumberToBn(\Carbon\Carbon::parse(request('end_date'))->format('d/m/Y')) }}</h3>

                                </div>
                            </div>
                            <div class="table-responsive">
                                <?php
                                $incomeblankrows = ''; $expeneblankrows = ''; $in = 1; $ex = 1;
                                $incnt = $incomes->count(); $excnt = $expenses->count();
                                $diff = $incnt - $excnt;
                                for ($i = 0; $i < abs($diff); $i++) {
                                    if ($incnt < $excnt) {
                                        $incomeblankrows .= '<tr><td>-<br>-</td><td></td><td></td><td></td><td></td></tr>';
                                    } else {
                                        $expeneblankrows .= '<tr><td>-<br>-</td><td></td><td></td><td></td><td></td><td></td></tr>';
                                    }
                                }
                                ?>
                                <div class="row">
                                    <div class="col-md-6 " style="margin-bottom:5px">
                                        <span><strong>ডেবিট(প্রাপ্তি) </strong></span>
                                    </div>
                                    <div class="col-md-6" style="text-align: right; margin-bootom:5px">
                                        <span><strong> ক্রেডিট (পরিশোধ)</strong></span>
                                    </div>
                                </div>
                                <table class="table table-bordered" style="width:45%; margin:0; float:left; border:1px solid #000" id="my Table">
                                    <thead>
                                        <tr>
                                            <th> তারিখ</th>
                                            <th> খাত</th>
                                            <th> টাকার পরিমান</th>
                                            <th> চেক নং</th>
                                            <th> ব্যাংকের নাম ও হিসাব নং</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $inamnt = 0; $examnt = 0;
                                    ?>
                                    @foreach($incomes as $income)
                                    <tr>
                                        <td>{{ enNumberToBn(\Carbon\Carbon::parse($income->receive_datwe)->format('d-m-Y')) }}</td>
                                        <td>{{ $income->sector->khat_name ?? '' }}</td>
                                        <td align="right">{{ enNumberToBn(number_format($income->amount,2)) }}</td>
                                        <td>{{ $income->check_no }}</td>
                                        <td>{{ ($income->bank->bank_name ?? '').' '.($income->bankAccount->acc_no ?? '') }}</td>
                                    </tr>

                                    <?php
                                        $inamnt += $income->amount;
                                        $inandbal = $inamnt + $balance;
                                    ?>
                                    @endforeach
                                    {!! $expeneblankrows !!}
                                    <tr>
                                        <td></td>
                                        <td align="right"><strong>মোট আয়</strong></td>
                                        <td align="right"><strong>{{ enNumberToBn(number_format($inamnt,2)) }}</strong></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td align="right"><strong>প্রারম্ভিক স্থিতি</strong></td>
                                        <td align="right"><strong>{{ enNumberToBn(number_format($balance,2)) }}</strong></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td align="right"><strong>সর্বমোট</strong></td>
                                        <td align="right"><strong>{{ enNumberToBn(number_format($inandbal,2)) }}</strong></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table class="table table-bordered"
                                       style="width:55%; margin:0px; float:left; border:1px solid #000" id="my Table">
                                    <thead>
                                    <tr>
                                        <th> তারিখ</th>
                                        <th> খাত</th>
                                        <th> ভাউচার নং</th>
                                        <th> চেক নং</th>
                                        <th> টাকার পরিমান</th>
                                        <th> ব্যাংকের নাম ও হিসাব নং</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($expenses as $expense)
                                    <tr>
                                        <td style="border: 1px solid #000;">{{ enNumberToBn(\Carbon\Carbon::parse($expense->receive_datwe)->format('d-m-Y')) }}</td>
                                        <td style="border: 1px solid #000;">{{ $expense->sector->khat_name }}</td>
                                        <td style="border: 1px solid #000;">{{ $expense->vourcher_no }}</td>
                                        <td style="border: 1px solid #000;">{{ $expense->check_no }}</td>
                                        <td style="border: 1px solid #000;" align="right">{{ enNumberToBn(number_format($expense->amount),2) }}</td>

                                        <td style="border: 1px solid #000;">{{ ($expense->bank->bank_name ?? '') . ($expense->bankAccount->acc_no ?? '') }}</td>
                                    </tr>
                                    {!! $incomeblankrows !!}

                                    <?php
                                    $examnt += $expense->amount;

                                    if($inandbal < $examnt){
                                        $bal = $examnt - $inandbal;
                                        $sign = '-';
                                    }else{
                                            $bal = $inandbal - $examnt;
                                            $sign = '+';
                                        }
                                    ?>
                                    @endforeach
                                    <tr>

                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td align="right"><strong>মোট ব্যয় </strong></td>
                                        <td align="right"><strong>{{ enNumberToBn(number_format($examnt,2)) }}</strong></td>
                                        <td></td>

                                    </tr>
                                    <tr>

                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td align="right"><strong>সমাপনী স্থিতি</strong></td>
                                        <td align="right"><strong>{{ enNumberToBn(number_format($bal ?? '0', 2)) }}</strong></td>
                                        <td></td>
                                    </tr>
                                    <tr>

                                        <td style="border: 1px solid #000;"></td>
                                        <td style="border: 1px solid #000;"></td>
                                        <td style="border: 1px solid #000;"></td>
                                        <td style="border: 1px solid #000;" align="right"><strong>সর্বমোট</strong></td>
                                        <td align="right"><strong>{{ enNumberToBn(number_format($examnt+($bal ?? '0'),2)) }}</strong></td>
                                        <td style="border: 1px solid #000;"></td>

                                    </tr>
                                    </tbody>
                                </table>

                                <div class="row" style="float: left;width: 100%;padding-top: 108px;">
                                    <table width="100%">
                                        <tr>
                                            <td width="25%" style="text-align:center"> হিসাব রক্ষক <br/> দোহার পৌরসভা
                                            </td>
                                            <td width="25%" style="text-align:center"> হিসাব রক্ষন কর্মকর্তা <br/>
                                                দোহার পৌরসভা
                                            </td>
                                            <td width="25%" style="text-align:center"> প্রধান নির্বাহী কর্মকর্তা / সচিব
                                                <br/> দোহার পৌরসভা
                                            </td>
                                            <td width="25%" style="text-align:center"> মেয়র <br/> দোহার পৌরসভা</td>
                                        </tr>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    @else
        @if(request('start_date') != '')
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
