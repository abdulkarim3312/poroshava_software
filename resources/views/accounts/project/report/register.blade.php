@extends('layouts.app')
@section('title','ঠিকাদার বিল প্রদানের বিস্তারিত তথ্য')
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
                <form action="{{ route('report.project_payment_register') }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="contractor">ঠিকাদার <span
                                            class="text-danger">*</span></label>
                                    <select required name="contractor" class="form-control select2" id="contractor">
                                        <option value="">ঠিকাদার নির্ধারণ</option>
                                        @foreach($contractors as $contractor)
                                            <option
                                                {{ request('contractor') == $contractor->eid ? 'selected' : '' }} value="{{ $contractor->eid }}">{{ $contractor->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="project">প্রকল্প <span
                                            class="text-danger">*</span></label>
                                    <select required name="project" class="form-control select2" id="project">
                                        <option value="">প্রকল্প নির্ধারণ</option>
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
    @if(count($projectPayments) > 0)
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-default">
                <div class="card-header">
                    <a href="#" onclick="getprint('printArea')" class="btn btn-success bg-gradient-success btn-sm"><i
                            class="fa fa-print"></i></a>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive" id="printArea">
                        ঠিকাদারের নাম : {{ $selectContractor->name }}
                        <br/>
                        আইডি নং- : {{ enNumberToBn($selectContractor->emp_id) }}
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>ক্রমিক নং</th>
                                <th>প্রকল্পের নাম</th>
                                <th>প্রাক্কলিত ব্যয়</th>
                                <th>চুক্তি মূল্য</th>
                                <th>বিলের ধরন</th>
                                <th>মোট বিল</th>
                                <th>জামানত</th>
                                <th>ভ্যাট</th>
                                <th>ভ্যাটের হার</th>
                                <th>আয়কর</th>
                                <th>আয়কর হার</th>
                                <th>নীট বিল</th>
                                <th>পরিশোধিত বিল </th>
                                <th>পরিশোধিত বিলের  মোট</th>
                                <th> অবশিষ্ট বিল</th>
                                <th>পরিশোধের তারিখ</th>
                                <th> ব্যাংক হিসাব নং </th>
                                <th> চেক নং  </th>
                                <th> ভাউচার নং   </th>
                                <th>মন্তব্য</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $dsd = 0;
                                $totalpay = 0
                             @endphp
                            @foreach($projectPayments  as $key => $projectPayment)
                                <tr class="gradeX">
                                    <td>{{ enNumberToBn($key + 1) }}</td>
                                    <td>{{ enNumberToBn($projectPayment->project_id) }}</td>
                                    <td>{{ enNumberToBn($projectPayment->project_price) }}</td>
                                    <td>{{ enNumberToBn(number_format((float) $projectPayment->contact_price,2)) }}</td>
                                    <td>{{ enNumberToBn($projectPayment->bill_type) }}</td>
                                    <td>{{ enNumberToBn(number_format((float) $projectPayment->total_bill,2)) }}</td>
                                    <td>{{ enNumberToBn(number_format((float) $projectPayment->security_money,2)) }}</td>
                                    <td>{{ enNumberToBn($projectPayment->vat) }}</td>
                                    <td>{{ enNumberToBn(number_format(((float) $projectPayment->vat * 100) / (float) $projectPayment->total_bill,2)) }}%</td>

                                    <td>{{ enNumberToBn(number_format($projectPayment->incometax,2)) }}</td>
                                    <td>{{ enNumberToBn(number_format(((float) $projectPayment->incometax * 100) / (float) $projectPayment->total_bill,2)) }}%</td>
                                    <td>{{ enNumberToBn(number_format((float) $projectPayment->bill_amnt,2)) }}</td>
                                    <td>{{ enNumberToBn(number_format((float) $projectPayment->payment,2)) }}</td>
                                    <td>{{ enNumberToBn($totalpay += (float) $projectPayment->payment) }}</td>
                                    <td>{{ enNumberToBn(number_format((float)$projectPayment->bill_amnt - (float)$totalpay,2))  }}</td>
                                    <td>{{ enNumberToBn($projectPayment->payment_date) }} </td>
                                    <td>{{ enNumberToBn($projectPayment->acc_no) }} </td>
                                    <td>{{ enNumberToBn($projectPayment->check_nos )  }}</td>
                                    <td>{{ enNumberToBn($projectPayment->voucher_no )  }}</td>
                                    <td>{{ enNumberToBn($projectPayment->commints) }}</td>

                                </tr>
                                @php
                                    $dsd= $dsd + $projectPayment->payment;
                                @endphp
                            @endforeach
                            @if (count($projectPayments) > 1)
                                <tr>
                                    <td colspan="12">পরিশোধিত মোট  </td>
                                    <td colspan="5">{{ enNumberToBn(number_format(floatval($dsd),2)) }} টাকা</td>
                                </tr>
                            @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @else
        @if(request('project') != '')
            <div class="alert alert-warning text-center"><h4>কোনো তথ্য পাওয়া যায়নি !</h4></div>
        @endif
    @endif
@endsection
@section('script')
    <script>
        $(function (){
            var projectSelected = '{{ request('project') }}'
            $("#contractor").change(function (){
                let contractorId = $(this).val();
                $('#project').html('<option value="">প্রকল্প নির্ধারণ</option>');
                if(contractorId != ''){
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_contractor_wise_projects') }}",
                        data: { contractorId: contractorId }
                    }).done(function( data ) {
                        $.each(data, function( index, item ) {
                            if (projectSelected == item.conacc_id)
                                $('#project').append('<option value="'+item.conacc_id+'" selected>'+item.project_id+'</option>');
                            else
                                $('#project').append('<option value="'+item.conacc_id+'">'+item.project_id+'</option>');
                        });
                    });
                }
            })
            $('#contractor').trigger('change');
        })
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
