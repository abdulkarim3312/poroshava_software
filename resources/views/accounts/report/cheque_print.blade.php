@extends('layouts.app')
@section('title')
    চেক প্রিন্টঃ ভাউচার নং {{ enNumberToBn($incomeExpense->vourcher_no) }}, চেক নং {{ enNumberToBn($incomeExpense->check_no) }}
@endsection
@section('style')
    <style>
        #printArea{
            background: #fff5e4;
            margin: 0 auto;
            width: 7.5in !important;
            height: 3.5in  !important;
        }
        .cheque-date {
            letter-spacing: 22px;
            color: #191919;
            font-weight: 500;
        }
        @page {
            size:7.4in 3.5in !important;
            margin: 0 !important;

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
                <div class="card-body">
                    <div id="printArea">
                        <div class="row">
                            <div class="col-6 text-right pr-0">
                                <div style="margin-top: 2.3cm !important;margin-right: 0!important;">
                                    <b style="font-size: 25px!important;opacity: .3;">NOT OVER TK</b><b style="font-size: 25px!important;"> = {{ enNumberToBn(number_format($incomeExpense->amount,2)) }}</b>
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                <div class="cheque-date" style="margin-top: 1.5cm !important;margin-right: -21px;padding-left:30px;font-size: 28px;">
                                    {{ enNumberToBn(\Carbon\Carbon::parse($incomeExpense->date)->format('dmY')) }}
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="payee_name" style="margin-top: 38px;margin-left: 1.9cm !important;font-size: 20px;font-weight: 700">
                                    {{ $incomeExpense->receiver_name }}
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="payee_name" style="margin-top: 21px;margin-left: 4.1cm !important;font-size: 20px;font-weight: 700">
                                    {{  $incomeExpense->amount_in_word }} টাকা মাত্র।
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="payee_name" style="margin-top: 28px;margin-left: 1.5cm !important;font-size: 25px;font-weight: 700">
                                    ={{ (enNumberToBn(number_format($incomeExpense->amount,2))) }}
                                </div>
                            </div>
                        </div>

                    </div>
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
