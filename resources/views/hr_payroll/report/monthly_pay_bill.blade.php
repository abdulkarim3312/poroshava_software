@extends('layouts.app')
@section('title','কর্মকর্তা/কর্মচারী মাসিক বেতন বিল')
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
                <form action="{{ route('report.employee_monthly_pay_bill') }}">
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
                                    <h3 class="text-center m-0 mb-2" style="font-size: 19px !important;">বেতন রিপোর্টস</h3>
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
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th colspan="9">ভাতাদি</th>
                                        <th></th>
                                        <th colspan="3">কর্তন</th>
                                        <th colspan=""></th>
                                        <th colspan="3">ভবিষ্য তহবিল</th>
                                    </tr>
                                    <tr>
                                        <th>আইডি নং</th>
                                        <th>কর্মকর্তা/কর্মচারী নাম ও বেতন স্কেল</th>
                                        <th>পদবি</th>
                                        <td>মূল বেতন</td>
                                        <td>বাড়ী ভাড়া</td>
                                        <td>চিকিৎসা</td>
                                        <td>টিফিন</td>
                                        <td>ধোলাই ভাতা</td>
                                        <td>শিক্ষা ভাতা</td>
                                        <td>বিশেষ সুবিধা</td>
                                        <td>অন্যান্য ভাতা</td>
                                        <td>মোট বেতন</td>
                                        <td>আয়কর</td>
                                        <td>চাঁদা</td>
                                        <td>পি এফ অগ্রিম</td>
                                        <td>অন্যান্য</td>
                                        <td>নীট প্রাপ্য</td>
                                        <td>চাঁদা ও অগ্রিম</td>
                                        <td>অনুদান</td>
                                        <td>মোট</td>
                                        <td>আনুতোষিক</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php

                                        $i=1;
                                        $salary_mul=0;
                                        $salary_korton=0;
                                        $total_anutos=0;
                                        $anutos=0;

                                        $total_basic_salary=0;
                                        $total_house_rent=0;
                                        $total_treatment=0;
                                        $total_tifin=0;
                                        $total_wash=0;
                                        $total_education=0;
                                        $total_special_benefits = 0;
                                        $total_others=0;
                                        $total_salary_mul=0;
                                        $total_pf_found=0;
                                        $total_pfloanadvance=0;
                                        $total_otherloan=0;
                                        $total_net_salary=0;
                                        $total_pf_pfl_otherloan=0;
                                        $total_furture=0;
                                        $total_salary_b=0;
                                        $total_unutoshik=0
                                    @endphp

                                    @foreach($salaries as $salary)

                                        <?php
                                        $salary_mul = $salary->salary + $salary->houserent + $salary->treatment + $salary->tifin + $salary->wash + $salary->education + $salary->others + $salary->special_benefits;

                                        $salary_korton = $salary->pf_found + $salary->pfloanadvance + $salary->otherloan;

                                        $anutos = $salary->salary * .25;
                                        $total_anutos += $anutos;

                                        $total_basic_salary += $salary->salary;
                                        $total_house_rent += $salary->houserent;
                                        $total_treatment += $salary->treatment;
                                        $total_tifin += $salary->tifin;
                                        $total_wash += $salary->wash;
                                        $total_education += $salary->education;
                                        $total_special_benefits+=$salary->special_benefits;
                                        $total_others += $salary->others;
                                        $total_salary_mul += $salary->salary + $salary->treatment + $salary->tifin + $salary->wash + $salary->education;
                                        $total_pf_found += $salary->pf_found;
                                        $total_pfloanadvance += $salary->pfloanadvance;
                                        $total_otherloan += $salary->otherloan;
                                        $total_net_salary += $salary_mul - $salary_korton;
                                        $total_pf_pfl_otherloan += $salary->pf_found + $salary->pfloanadvance;
                                        $total_furture += $salary->pf_found + $salary->pfloanadvance + $salary->pf_found

                                        ?>
                                        <tr>
                                            <td>{{ enNumberToBn($salary->employeeName->emp_id)}}</td>
                                            <td class="text-left">{{ enNumberToBn($salary->employeeName->name)}}
                                                (<span>{{ enNumberToBn($salary->employeeName->SalaryScale->name ?? '') }}</span>)
                                            </td>
                                            <td class="text-left">{{ enNumberToBn($salary->employeeName->designation ?? '')}}</td>
                                            <td>{{  enNumberToBn(number_format($salary->salary,2))}}</td>
                                            <td>{{  enNumberToBn(number_format($salary->houserent,2))}}</td>
                                            <td>{{  enNumberToBn(number_format($salary->treatment,2))}}</td>
                                            <td>{{  enNumberToBn(number_format($salary->tifin,2))}}</td>
                                            <td>{{  enNumberToBn(number_format($salary->wash,2))}}</td>
                                            <td>{{  enNumberToBn(number_format($salary->education,2))}}</td>
                                            <td>{{  enNumberToBn(number_format($salary->special_benefits,2))}}</td>
                                            <td>{{  enNumberToBn(number_format($salary->others,2))}}</td>
                                            <td>
                                                {{  enNumberToBn(number_format($salary_mul,2))}}
                                                @php
                                                    $total_salary_b += $salary_mul
                                                @endphp
                                            </td>
                                            <td>{{  enNumberToBn(number_format($salary->tax,2))}}</td>
                                            <td>{{  enNumberToBn(number_format($salary->pf_found,2))}}</td>
                                            <td>{{  enNumberToBn(number_format($salary->pfloanadvance,2))}}</td>
                                            <td>{{  enNumberToBn(number_format($salary->otherloan,2))}}</td>
                                            <td>{{  enNumberToBn(number_format($salary_mul - $salary_korton-$salary->tax,2))}}</td>
                                            <td>{{  enNumberToBn(number_format($salary->pf_found+$salary->pfloanadvance,2))}}</td>
                                            <td>{{  enNumberToBn(number_format($salary->pf_found,2))}}</td>
                                            <td>{{  enNumberToBn(number_format($salary->pf_found + $salary->pfloanadvance + $salary->pf_found,2))}}</td>
                                            @if($salary->employeeName->grataccno!=0)
                                                <td style="text-align: right">
                                                    {{  enNumberToBn(number_format($anutos,2))}}
                                                    @php
                                                        $total_unutoshik +=  $anutos
                                                    @endphp
                                                </td>
                                            @else
                                                <td style="text-align: right">{{ enNumberToBn(0)}}</td>
                                            @endif

                                        </tr>
                                    @endforeach
                                    <tr class="gradeX">
                                        <td colspan="3" align="center">সর্বমোট :</td>
                                        <td>{{  enNumberToBn(number_format($total_basic_salary,2))}}</td>
                                        <td>{{  enNumberToBn(number_format($total_house_rent,2))}}</td>
                                        <td>{{  enNumberToBn(number_format($total_treatment,2))}}</td>
                                        <td>{{  enNumberToBn(number_format($total_tifin,2))}}</td>
                                        <td>{{  enNumberToBn(number_format($total_wash,2))}}</td>
                                        <td>{{  enNumberToBn(number_format($total_education,2))}}</td>
                                        <td>{{  enNumberToBn(number_format($total_special_benefits,2))}}</td>
                                        <td>{{  enNumberToBn(number_format($total_others,2))}}</td>
                                        <td>{{  enNumberToBn(number_format($total_salary_b,2))}}</td>
                                        <td>{{  enNumberToBn(number_format($salaries->sum('tax'),2))}}</td>
                                        <td>{{  enNumberToBn(number_format($total_pf_found,2))}}</td>
                                        <td>{{  enNumberToBn(number_format($total_pfloanadvance,2))}}</td>
                                        <td>{{  enNumberToBn(number_format($total_otherloan,2))}}</td>
                                        <td>{{  enNumberToBn(number_format($total_net_salary,2))}}</td>
                                        <td>{{  enNumberToBn(number_format($total_pf_pfl_otherloan,2))}}</td>
                                        <td>{{  enNumberToBn(number_format($total_pf_found,2))}}</td>
                                        <td>{{  enNumberToBn(number_format($total_furture,2))}}</td>

                                        <td style="text-align: right">{{  enNumberToBn($total_unutoshik)}}</td>

                                    </tr>
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
