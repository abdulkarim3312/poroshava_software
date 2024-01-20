@extends('layouts.app')
@section('title','পেমেন্ট সার্টিফিকেট')
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
                <form action="{{ route('report.project_payment_certificate') }}">
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
                                    <label for="financial_year">অর্থ বছর <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control select2" name="financial_year" id="financial_year">
                                        <option value="">অর্থ বছর নির্ধারণ</option>
                                        @for($i=2019; $i <= date('Y'); $i++)
                                            <option
                                                value="{{ $i }}-{{ $i+1 }}" {{ request('financial_year') == $i.'-'.$i+1 ? 'selected' : '' }}>{{ enNumberToBn($i) }}-{{ enNumberToBn($i+1) }}</option>
                                        @endfor
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
    @if(count($projects) > 0)
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-default">
                <div class="card-header">
                    <a href="#" onclick="getprint('printArea')" class="btn btn-success bg-gradient-success btn-sm"><i
                            class="fa fa-print"></i></a>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div id="printArea">
                        <div class="row">
                            <div class="col-12">
                                <h1 class="text-center m-0" style="margin-bottom: 5px !important;font-size: 20px !important;font-weight: bold">
                                    {{ config('app.full_name') }}
                                </h1>
                                <h3 class="text-center" style="font-size: 19px !important;">পেমেন্ট সার্টিফিকেট</h3>
                                <h3 class="text-center m-0 mb-2" style="font-size: 14px !important;">
                                    এই মর্মে প্রত্যয়ন করা যাচ্ছে যে ,{{ $selectContractor->name }} {{ enNumberToBn(request('financial_year')) }} অর্থ বছরে নিম্মোক্ত কাজ সমূহ সম্পাদন করেছেন  এবং মূ:স:ক ও আয়কর কর্তন পূর্বক নিম্মোবর্নিত বিলসমূহ  প্রদান করা হয়েছে|
                                </h3>
                            </div>
                        </div>
                        <div class="table-responsive">
                            ঠিকাদারের নাম : {{ $selectContractor->name }}<br>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>ক্রমিক নং</th>
                                    <th>কাজের নাম</th>
                                    <th>মোট বিল</th>
                                    <th>জামানত</th>
                                    <th>ভ্যাট </th>
                                    <th>আয় কর</th>
                                    <th>পরিশোধিত অর্থ</th>
                                    <th>মন্তব্য</th>

                                </tr>
                                </thead>
                                <tbody>
                                @php $i=1;  $dsd=0; $total_bill=0; $total_sucurity=0; $total_vat=0;$total_incom=0;
                                    $total_bill_amount=0;
                                @endphp
                                @foreach($projects  as $project)

                                    <tr class="gradeX">
                                        <td width=1%>{{  enNumberToBn( $i) }}</td>
                                        <td class="text-left">{{ enNumberToBn( $project->project_id)  }}</td>
                                        <td>{{ enNumberToBn(number_format($project->total_bill,2)) }} </td>
                                        <td>{{ enNumberToBn(number_format($project->security_money,2)) }} </td>
                                        <td>{{ enNumberToBn(number_format($project->vat,2)) }} </td>
                                        <td>{{ enNumberToBn(number_format($project->incometax,2)) }} </td>
                                        <td>{{ enNumberToBn(number_format($project->bill_amnt,2)) }} </td>
                                        <td>{{ enNumberToBn($project->acc_no) }}</td>
                                    </tr>
                                    @php $i++; $total_bill +=$project->total_bill;  $total_sucurity += $project->security_money; $total_vat +=$project->vat;
                                        $total_incom += $project->incometax; $total_bill_amount +=  $project->bill_amnt;
                                    @endphp
                                @endforeach
                                <tr>
                                    <td> </td>
                                    <td>মোট</td>
                                    <td>{{  enNumberToBn(number_format($total_bill,2)) }}</td>
                                    <td> {{ enNumberToBn(number_format($total_sucurity,2)) }}</td>
                                    <td>{{ enNumberToBn(number_format($total_vat,2)) }}</td>
                                    <td>{{ enNumberToBn(number_format($total_incom,2)) }}</td>
                                    <td>{{ enNumberToBn(number_format($total_bill_amount,2)) }}</td>
                                    <td></td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                        <div class="row" style="margin-top: 90px">
                            <div class="col-6">
                                <h6 class="text-center">
                                    হিসাবরক্ষন কর্মকর্মর্তা /হিসাবরক্ষক <br>
                                    দোহার পৌরসভা,দোহা
                                </h6>
                            </div>
                            <div class="col-6">
                                <h6 class="text-center">
                                    মেয়র <br>
                                    দোহার পৌরসভা,দোহা
                                </h6>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    @else
        @if(request('contractor') != '')
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
