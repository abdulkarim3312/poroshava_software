@extends('layouts.app')
@section('title','ব্যয় বাজেট')
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
                <form action="{{ route('report.expenditure_budget') }}">
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
                                    <label for="branch">অর্থ বছর <span
                                            class="text-danger">*</span></label>
                                    <select required name="financial_year" class="form-control select2" id="branch">
                                        <option value="">অর্থ বছর নির্ধারণ</option>
                                        @foreach($financial_year as $item)
                                            <option value="{{ $item->year }}" {{ request('financial_year')==$item->year?'selected':'' }}>{{ enNumberToBn($item->year) }}</option>
                                        @endforeach
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
    @if(count($khattypes) > 0 )
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
                                    <h3 class="text-center m-0 mb-2" style="font-size: 19px !important;">ব্যয় বাজেট</h3>
                                    <h6 style="text-align: center;"><strong>(বিধি ২৪৮ ও ২৮৯ দ্রষ্টব্য)</strong></h6>
                                    <h6 style="text-align: center;">{{ enNumberToBn($selected_financial_year??'') }} অর্থ বছরের জন্য প্রস্তুতকৃত দোহার পৌরসভার ব্যয় বাজেট বিবরণী</h6>
                                    <h3 class="text-center m-0 mb-2"
                                        style="font-size: 19px !important;">{{ $selectUpangsho->upangsho_name??'' }}</h3>
                                    @php
                                        $y = explode('-', $selected_financial_year??'');
                                        $next_year = ($y[0]+1).'-'.($y[1]+1);
                                        $prev_year = ($y[0]-1).'-'.($y[1]-1);
                                    @endphp

                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" style="margin:0;">
                                    <thead>
                                        <tr>
                                            <th width="5%">ক্রঃ নং </th>
                                            <th width="50%">ব্যায়ের খাত</th>
                                            <th width="15%">পুর্ববর্তী বছরের প্রকৃত
                                                <br>{{  enNumberToBn($prev_year) }}
                                            </th>
                                            <th width="15%">চলতি বছরের বাজেট বা চলতি বছরের সংশোধিত বাজেট
                                                <br>{{  enNumberToBn($selected_financial_year) }}
                                            </th>
                                            <th width="15%">পরবর্তী বছরের বাজেট
                                                <br>{{  enNumberToBn($next_year) }}
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>১</th>
                                            <th>২</th>
                                            <th>৩</th>
                                            <th>৪</th>
                                            <th>৫</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @isset($badget)

                                            <tr class="gradeX">
                                                {!! $badget !!}
                                            </tr>
                                        @endisset
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
