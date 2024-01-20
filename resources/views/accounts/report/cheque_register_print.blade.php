@extends('layouts.app')
@section('title','চেক রেজিস্টার বিস্তারিত')
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
                    <div class="table-responsive-sm" id="printArea">
                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-6 text-center">
                                <h1 class="text-center m-0" style="font-size: 20px !important;font-weight: bold">
                                    <img height="50px" src="{{ asset('img/logo.png') }}" alt="">
                                    {{ config('app.full_name') }}
                                </h1>
                                <p class="text-center">
                                    ডেবিট ভাউচার {{ $incomeExpense->upangsho->upangsho_name ?? '' }}
                                </p>
                                <p class="text-center"> (চেক পরিশোধের জন্য)</p>
                            </div>

                            <div class="col-4" style="color: red !important;">

                                <p style="color: red !important;">
                                    <strong style="color: red !important;">
                                        ভাউচার নং: {{  enNumberToBn($incomeExpense->vourcher_no) }}
                                        @if($vat)
                                            {{ enNumberToBn($vat->vourcher_no) }}
                                        @endif
                                        @if($tax)
                                            {{ enNumberToBn($tax->vourcher_no) }}
                                        @endif
                                        @if($jamanot)
                                            {{ enNumberToBn($jamanot->vourcher_no) }}
                                        @endif
                                    </strong>
                                </p>
                                <p><strong style="color: red !important;"> তারিখঃ {{ enNumberToBn($incomeExpense->receive_datwe) }}  </strong>
                                </p>
                                <p><strong style="color: red !important;">
                                        চেক নং:{{ enNumberToBn($incomeExpense->check_no) }}
                                        @if($vat)
                                            {{ enNumberToBn($vat->check_no) }}
                                        @endif
                                        @if($tax)
                                            {{ enNumberToBn($tax->check_no) }}
                                        @endif
                                        @if($jamanot)
                                            {{ enNumberToBn($jamanot->check_no) }}
                                        @endif
                                    </strong>
                                </p>
                                <p>
                                    <strong style="color: red !important;">
                                        ব্যাংকঃ {{ $incomeExpense->bank->bank_name ?? '' }}
                                    </strong></p>
                                <p>
                                    <strong style="color: red !important;">
                                        হিসাব নং {{ enNumberToBn($incomeExpense->bankAccount->acc_no ?? null)  }}
                                    </strong>
                                </p>
                            </div>

                        </div>
                        <br/><br/><br/>
                        <span>যাহাকে পরিশোধ করা হচ্ছে &nbsp    :: <strong>&nbsp    {{ $incomeExpense->receiver_name }}</strong> </span>
                        <br/><br/>
                        <div class="" style="width:100%">
                            <table class="table table-bordered">
                                <tr>
                                    <th colspan="">হিসাবের খাত</th>
                                    <th colspan="">বিবরন</th>
                                    <th colspan="">টাকা</th>
                                </tr>
                                <tr>
                                    <td>{{ $incomeExpense->sector->khat_name ?? '' }} </td>
                                    <td>{{ $incomeExpense->khat_des }}</td>
                                    <td align="right"
                                        style="color:red;">{{ enNumberToBn(number_format($incomeExpense->amount,2))  }}</td>
                                </tr>
                                @php
                                    $sum= $incomeExpense->amount;
                                @endphp
                                @if($vat)
                                    <tr>
                                        <td></td>
                                        <td>{{ $vat->khat_des }}</td>
                                        <td align="right"
                                            style="color:red;">{{ enNumberToBn(number_format($vat->amount,2)) }}</td>
                                    </tr>
                                    <?php
                                    $sum = $incomeExpense->amount;
                                    if (isset($vat)){
                                        $sum= $sum + (int)$vat->amount;
                                    }
                                    if(isset($tax)){
                                        $sum= $sum +(int)$tax->amount;
                                    }
                                    if(isset($jamanot)){
                                        $sum= $sum +(int)$jamanot->amount;
                                    }
                                    ?>

                                @endif
                                @if($tax)
                                    @isset($tax)
                                        <tr>
                                            <td></td>
                                            <td>{{ $tax->khat_des }}</td>
                                            <td align="right"
                                                style="color: red !important;">{{ enNumberToBn(number_format($tax->amount,2)) }}</td>
                                        </tr>
                                    @endisset
                                @endif
                                @if($jamanot)
                                    @isset($jamanot)
                                        <tr>
                                            <td></td>
                                            <td>{{ $jamanot->khat_des }}</td>
                                            <td align="right"
                                                style="color: red !important;">{{ enNumberToBn(number_format($jamanot->amount,2)) }}</td>
                                        </tr>
                                    @endisset
                                @endif
                                <tr>
                                    <td colspan="2">মোট =</td>
                                    <td align="right" style="color: red !important;"><strong
                                            style="color: red !important;">   {{ enNumberToBn(number_format($sum,2)) }} </strong>
                                    </td>
                                </tr>
                            </table>

                        </div>
                        <br><br><br><br>
                        <div class="row">

                            <table width="100%">

                                <tr>
                                    <td width="20%" style="text-align:center"> গ্রহিতার স্বাক্ষর</td>
                                    <td width="30%" style="text-align:center"> হিসাব রক্ষক কর্মকর্তা / হিসাব রক্ষক <br/>
                                        দোহার পৌরসভা |
                                    </td>
                                    <td width="25%" style="text-align:center"> প্রধান নির্বাহী কর্মকর্তা / সচিব <br/>
                                        দোহার পৌরসভা |
                                    </td>
                                    <td width="25%" style="text-align:center"> মেয়র <br/> দোহার পৌরসভা |</td>
                                </tr>
                            </table>


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function getprint(print) {
            $('.print-heading').css('display', 'block');
            $('.extra_column').remove();
            $('body').html($('#' + print).html());
            window.print();
            window.location.replace(APP_URL)
        }
    </script>
@endsection
