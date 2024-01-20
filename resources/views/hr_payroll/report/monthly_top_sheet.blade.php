@extends('layouts.app')
@section('title','কর্মকর্তা/কর্মচারী মাসিক বেতন টপশিট')
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
                <form action="{{ route('report.employee_monthly_salary_top_sheet') }}">
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
                                    <label for="year">বছর <span
                                            class="text-danger">*</span></label>
                                    <select required name="year" class="form-control select2" id="year">
                                        <option value="">বছর নির্ধারণ</option>
                                        @for($i=$lastProcessYear; $i <= date('Y'); $i++)
                                            <option
                                                value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>{{ enNumberToBn($i) }}</option>
                                        @endfor

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="month">মাসের নাম <span
                                            class="text-danger">*</span></label>
                                    <select required name="month" class="form-control select2" id="month">
                                        <option value="">মাসের নাম নির্ধারণ</option>
                                        @foreach($months as $month)
                                            <option
                                                {{ request('month') == $month ? 'selected' : '' }} value="{{ $month }}">{{ $month }}</option>
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
    @if(count($salaries) > 0)
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
                                    <h3 class="text-center m-0 mb-2" style="font-size: 19px !important;">কর্মকর্ম র্তা
                                        /কর্মচার্ম রী মাসিক বেতন বিল</h3>
                                    <h3 class="text-center m-0 mb-2"
                                        style="font-size: 19px !important;">{{ $selectUpangsho->upangsho_name }}</h3>
                                    <h3 class="text-center m-0 mb-2" style="font-size: 19px !important;">
                                        মাসের নামঃ {{ enNumberToBn($yearMonth) }}</h3>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>ক্রমিক নং</th>
                                        <th>কর্মকর্তা/কর্মচারী সংখ্যা</th>
                                        <th>বেতন</th>
                                        <th>আয়কর</th>
                                        <th>ভবিষ্য তহবিল</th>
                                        <th>আনুতোষিক</th>
                                        <th>মোট বেতন ভাতা</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                    $i=1;
                                    $employetotalsalary=0;
                                    $totalTax=0;
                                    $totaldivision=0;
                                    $totalpf_fund=0;
                                    $graduaity=0;
                                    $total=0;
                                    $upanan="";

                                    @endphp
                                    @foreach($salaries as $salary)
                                        @php
                                            $totaldivision += $salary->division_count;
                                            $totalTax += $salary->total_tax;
                                            $employetotalsalary=$employetotalsalary+$salary->employsalary;
                                            $upanansos=$salary->upanansos;
                                            $totalpf_fund += $salary->pf_fund;
                                            $graduaity +=$salary->graduaty;
                                            $total=$total+$salary->employsalary +  $salary->graduaty + $salary->pf_fund;

                                        @endphp
                                        <tr>
                                            <td>{{ enNumberToBn( $i) }}</td>
                                            <td class="text-left">{{ \App\Models\Department::find($salary->branchid)->name ?? '' }} - {{ enNumberToBn( $salary->division_count) }} জন</td>
                                            <td style="text-align: right;">{{ enNumberToBn(number_format($salary->employsalary,2)) }}</td>
                                            <td style="text-align: right;">{{ enNumberToBn(number_format($salary->total_tax,2)) }}</td>
                                            <td style="text-align: right;">{{ enNumberToBn(number_format($salary->pf_fund,2)) }}</td>
                                            <td style="text-align: right;">{{ enNumberToBn(number_format($salary->graduaty,2)) }}</td>
                                            <td style="text-align: right;">{{ enNumberToBn(number_format($salary->employsalary +  $salary->graduaty + $salary->pf_fund,2)) }}</td>
                                        </tr>
                                        @php $i++  @endphp
                                    @endforeach
                                    <td>মোট=</td>

                                    <td class="text-left">{{  enNumberToBn(number_format($totaldivision)) }} জন</td>
                                    <td style="text-align: right;">{{  enNumberToBn(number_format($employetotalsalary,2)) }}</td>
                                    <td style="text-align: right;">{{  enNumberToBn(number_format($totalTax,2)) }}</td>
                                    <td style="text-align: right;">{{  enNumberToBn(number_format($totalpf_fund,2)) }}</td>
                                    <td style="text-align: right;">{{  enNumberToBn(number_format($graduaity,2)) }}</td>
                                    <td style="text-align: right;">{{  enNumberToBn(number_format($total,2)) }}</td>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        @if(request('year'))
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
