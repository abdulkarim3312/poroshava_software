@extends('layouts.app')
@section('title','বাৎসরিক আয় ব্যয় হিসাব')
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
                <form action="{{ route('report.yearly_income_expenditure') }}">
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
                            {{-- <div class="col-md-3">
                                <div class="form-group">
                                    <label for="bank">ব্যাংক <span
                                            class="text-danger">*</span></label>
                                    <select required name="bank" class="form-control select2" id="bank">
                                        <option value="">ব্যাংক নির্ধারণ</option>
                                        @foreach($banks as $bank)
                                            <option {{ request('bank') == $bank->bank_id ? 'selected' : '' }} value="{{ $bank->bank_id }}">{{ $bank->bank_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="branch">অর্থ বছর <span
                                            class="text-danger">*</span></label>
                                    <select required name="financial_year" class="form-control select2" id="branch">
                                        <option value="2022-07-01/2023-06-30/২০২২-২০২৩" {{ $financial_year == '২০২২-২০২৩' ? 'selected' : '' }}>২০২২-২০২৩</option>
                                        <option value="2023-07-01/2024-06-30/২০২৩-২০২৪" {{ $financial_year == '২০২৩-২০২৪' ? 'selected' : '' }}>২০২৩-২০২৪</option>
                                    </select>
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
    @if(count($getIncomes) > 0 || count($getExpenses) > 0)
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
                                    <h3 class="text-center m-0 mb-2" style="font-size: 19px !important;">বাৎসরিক আয় ব্যয় হিসাব</h3>
                                    <h6 style="text-align: center;"><strong>(বিধি ২৪৮ ও ২৮৯ দ্রষ্টব্য)</strong></h6>
                                    <h6 style="text-align: center;">{{ $financial_year }} অর্থ বছরের জন্য প্রস্তুতকৃত দোহার পৌরসভার বার্ষিক হিসাব বিবরণী</h6>
                                    <h3 class="text-center m-0 mb-2"
                                        style="font-size: 19px !important;">{{ $selectUpangsho->upangsho_name }}</h3>
                                    {{-- <h3 class="text-center m-0 mb-2" style="font-size: 15px !important;">
                                        সময়কালঃ {{ enNumberToBn(\Carbon\Carbon::parse(request('start_date'))->format('d/m/Y')) }}
                                        - {{ enNumberToBn(\Carbon\Carbon::parse(request('end_date'))->format('d/m/Y')) }}</h3> --}}

                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" style="width:50%; margin:0; float:left;">
                                    <thead>
                                        <tr>
                                            <th colspan="5">প্রাপ্তি</th>
                                        </tr>
                                        <tr>
                                            <th colspan="5">১</th>
                                        </tr>
                                        <tr>
                                            <th> ক্রঃ নং </th>
                                            <th> খাত </th>
                                            <th> বাজেট </th>
                                            <th> প্রকৃত  </th>
                                            <th> পার্থক্য </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                                    $incomeblankrows=''; $expeneblankrows=''; $in=1; $ex=1;
                                    $inamnt = 0; $examnt = 0;
                                    $inAmount = 0;
                                    $outAmount = 0;
                                    $totalBudgetIncome = 0;
                                    $totalRemainIncome = 0;

                                    ?>
                                    @foreach($getIncomes as $getIncome)
                                        <tr>
                                            <td >{{ enNumberToBn($loop->iteration) }}</td>
                                            <td class="text-left">{{ $getIncome->sector->khat_name ?? '' }}</td>
                                            <?php
                                            $getkhatIncomeExpenseAcc = \App\Models\Incoexpense::where('khat_id', $getIncome->khat_id)
                                                ->where('status', 1)
                                                ->whereBetween('receive_datwe', [$sd, $ed])
                                                ->sum('amount');

                                            $diff = $getIncome->budget - $getkhatIncomeExpenseAcc;
                                            ?>
                                            <td class="text-right">{{ str_replace($en, $bn, number_format($getIncome->budget,2)) }}</td>
                                            <td class="text-right">{{ str_replace($en, $bn, number_format($getkhatIncomeExpenseAcc,2)) }}</td>
                                            <td class="text-right">{{ str_replace($en, $bn, number_format($diff,2)) }}</td>

                                        </tr>
                                        <?php
                                        $inamnt += $getkhatIncomeExpenseAcc;
                                        $totalBudgetIncome += $getIncome->budget;
                                        $totalRemainIncome += $diff;

                                        ?>
                                    @endforeach
                                    {!! $incomeBlankRows !!}
                                    <tr>
                                        <td ></td>
                                        <td  class="text-right"><strong>মোট</strong></td>
                                        <td  class="text-right"><strong>{{ str_replace($en, $bn, number_format($totalBudgetIncome,2)) }}</strong></td>
                                        <td  class="text-right"><strong>{{ str_replace($en, $bn, number_format($inamnt,2)) }}</strong></td>
                                        <td  class="text-right"><strong>{{ str_replace($en, $bn, number_format($totalRemainIncome,2)) }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td ></td>
                                        <td  class="text-right"><strong>প্রারম্ভিক জের</strong></td>
                                        <td  class="text-right"><strong></strong></td>
                                        <td  class="text-right"><strong></strong></td>
                                        <td  class="text-right"><strong></strong></td>
                                    </tr>
                                    <tr>
                                        <td ></td>
                                        <td  class="text-right"><strong>সর্বমোট</strong></td>
                                        <td  class="text-right"><strong></strong></td>
                                        <td  class="text-right"><strong></strong></td>
                                        <td  class="text-right"><strong></strong></td>
                                    </tr>
                                    </tbody>
                                </table>

                                <table class="table table-bordered" style="width:50%; margin:0; float:left;">
                                    <thead>
                                        <tr>
                                            <th colspan="5">পরিশোধ</th>
                                        </tr>
                                        <tr>
                                            <th colspan="5">২</th>
                                        </tr>
                                        <tr>
                                            <th> ক্রঃ নং </th>
                                            <th> খাত </th>
                                            <th> বাজেট </th>
                                            <th> প্রকৃত  </th>
                                            <th> পার্থক্য </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $incomeblankrows=''; $expeneblankrows=''; $in=1; $ex=1;
                                        $inamnt = 0; $examnt = 0;
                                        $inAmount = 0;
                                        $outAmount = 0;
                                        $totalBudgetIncome = 0;
                                        $totalRemainIncome = 0;

                                        ?>
                                    @foreach($getExpenses as $getExpense)
                                        <tr>
                                            <td >{{ enNumberToBn($loop->iteration) }}</td>
                                            <td class="text-left">{{ $getExpense->sector->khat_name ?? '' }}</td>
                                            <?php
                                            $getkhatIncomeExpenseAcc = \App\Models\Incoexpense::where('khat_id', $getExpense->khat_id)
                                                ->where('status', 1)
                                                ->whereBetween('receive_datwe', [$sd, $ed])
                                                ->sum('amount');

                                            $diff = $getExpense->budget - $getkhatIncomeExpenseAcc;
                                            ?>
                                            <td class="text-right">{{ str_replace($en, $bn, number_format($getExpense->budget,2)) }}</td>
                                            <td class="text-right">{{ str_replace($en, $bn, number_format($getkhatIncomeExpenseAcc,2)) }}</td>
                                            <td class="text-right">{{ str_replace($en, $bn, number_format($diff,2)) }}</td>
                                        </tr>
                                        <?php
                                        $inamnt += $getkhatIncomeExpenseAcc;
                                        $totalBudgetIncome += $getExpense->budget;
                                        $totalRemainIncome += $diff;
                                        ?>
                                    @endforeach
                                    {!! $expenseBlankRows !!}
                                    <td ></td>
                                        <td  class="text-right"><strong>মোট</strong></td>
                                        <td  class="text-right"><strong>{{ str_replace($en, $bn, number_format($totalBudgetIncome,2)) }}</strong></td>
                                        <td  class="text-right"><strong>{{ str_replace($en, $bn, number_format($inamnt,2)) }}</strong></td>
                                        <td  class="text-right"><strong>{{ str_replace($en, $bn, number_format($totalRemainIncome,2)) }}</strong></td>
                                        <tr>
                                            <td ></td>
                                            <td  class="text-right"><strong>প্রারম্ভিক জের</strong></td>
                                            <td  class="text-right"><strong></strong></td>
                                            <td  class="text-right"><strong></strong></td>
                                            <td  class="text-right"><strong></strong></td>
                                        </tr>
                                        <tr>
                                            <td ></td>
                                            <td  class="text-right"><strong>সর্বমোট</strong></td>
                                            <td  class="text-right"><strong></strong></td>
                                            <td  class="text-right"><strong></strong></td>
                                            <td  class="text-right"><strong></strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="row" style="float: left;width: 100%;padding-top: 108px;">
                                    <table width="100%">
                                        <tr>

                                            <td width="25%" style="text-align:center">  হিসাব রক্ষক <br/> দোহার পৌরসভা </td>
                                            <td width="25%"  style="text-align:center">  হিসাব রক্ষণ কর্মকর্তা  <br/> দোহার পৌরসভা </td>
                                            <td width="25%"  style="text-align:center"> প্রধান নির্বাহী কর্মকর্তা / সচিব  <br/> দোহার পৌরসভা </td>
                                            <td width="25%"  style="text-align:center"> মেয়র <br/>  দোহার পৌরসভা </td>
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
            var branchSelected = '{{ request('branch') }}'
            $("#bank").change(function (){
                let bankId = $(this).val();
                $('#branch').html('<option value="">শাখা নির্ধারণ</option>');
                if(bankId != ''){
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_branches') }}",
                        data: { bankId: bankId }
                    }).done(function( data ) {
                        $.each(data, function( index, item ) {
                            if (branchSelected == item.branch_id)
                                $('#branch').append('<option value="'+item.branch_id+'" selected>'+item.branch_name+'</option>');
                            else
                                $('#branch').append('<option value="'+item.branch_id+'">'+item.branch_name+'</option>');
                        });
                        $('#branch').trigger('change');
                    });
                }
            })
            $('#bank').trigger('change');

            var bankAccountSelected = '{{ request('bank_account') }}'
            $("#branch").change(function (){
                let branchId = $(this).val();
                $('#bank_account').html('<option value="">ব্যাংক একাউন্ট নম্বর নির্ধারণ</option>');
                if(branchId != ''){
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_bank_accounts') }}",
                        data: { branchId: branchId }
                    }).done(function( data ) {
                        $.each(data, function( index, item ) {
                            if (bankAccountSelected == item.bank_details_id)
                                $('#bank_account').append('<option value="'+item.bank_details_id+'" selected>'+item.acc_no+'</option>');
                            else
                                $('#bank_account').append('<option value="'+item.bank_details_id+'">'+item.acc_no+'</option>');
                        });
                    });
                }
            })
            $('#branch').trigger('change');
            $('body').on('click', '.btn-cash-confirm', function () {
                var incomeExpenseId = $(this).data('id');
                Swal.fire({
                    title: 'আপনি কি নিশ্চিত?',
                    text: "আপনি এটিকে ফিরিয়ে আনতে পারবেন না!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#d33',
                    confirmButtonText:'হ্যাঁ,নিশ্চিত করুন!',
                    cancelButtonText: 'বাতিল',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: "Post",
                            url: "{{ route('report.cashbook_expense.cash_confirm') }}",
                            data: { incomeExpenseId: incomeExpenseId }
                        }).done(function( response ) {
                            if (response.success) {
                                Swal.fire(
                                    'অনুমোদিত!',
                                    response.message,
                                    'success'
                                ).then((result) => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: response.message,
                                });
                            }
                        });

                    }
                })

            });
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
