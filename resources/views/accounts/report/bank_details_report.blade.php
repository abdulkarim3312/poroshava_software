@extends('layouts.app')
@section('title','ব্যাংক বিবরণ রিপোর্ট')
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
                <form action="{{ route('report.bank_details_report') }}">
                    <div class="card-body">
                        <div class="row">
                            {{-- <div class="col-md-3">
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
                            </div> --}}
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
                                        <option value="">অর্থ বছর নির্ধারণ</option>
                                        @foreach($years as $year)
                                            <option>{{ enNumberToBn($year->year) }}</option>
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
    <div class="card">
        <div class="card-header">
            <button class="btn btn-success bg-gradient-success btn-sm" onclick="getprint('printarea')"><i
                class="fa fa-print"></i></button>
        </div>
        <div class="card-body">
            <div id="printarea">
                <div class="row">
                    <div class="col-sm-12">
                        <section class="panel">
                            <header class="panel-heading">

                                    <h4 style="text-align: center;"><strong>দোহার পৌরসভা,দোহা</strong></h4>

                                    <h4 style="text-align: center;"><strong>ব্যাংক বিবরণ</strong></h4>

                                <span class="tools pull-right">

                                </span>
                            </header>
                            <div class="panel-body">
                                <div class="adv-table">

                                        <table class="display table table-bordered" id="">
                                            <thead>
                                                <tr>
                                                    <th>ক্রঃ নং</th>
                                                    <th>ব্যাংকের নাম </th>
                                                    <th>হিসাব নং</th>
                                                    <th>বিবরণ</th>
                                                    <th>স্থিতি</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($bankDetails as $item)
                                                    <tr>
                                                        <td>{{ enNumberToBn($loop->iteration) }}</td>
                                                        <td>{{ $item->bank->bank_name.', '.$item->branch->branch_name }}</td>
                                                        <td>{{ $item->acc_no }}</td>
                                                        <td>{{ $item->acc_details }}</td>
                                                        <td>{{ enNumberToBn(number_format($item->update_balance, 2)) }}</td>
                                                    </tr>
                                                @empty

                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
            </div>
        </div>
    </div>
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
