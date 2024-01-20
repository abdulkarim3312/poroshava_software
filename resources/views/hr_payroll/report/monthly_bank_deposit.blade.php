@extends('layouts.app')
@section('title','মাসিক বেতন ব্যাংক জমা')
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
                <form action="{{ route('report.employee_monthly_salary_bank_deposit') }}">
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
                                    <h3 class="text-center m-0 mb-2" style="font-size: 19px !important;">মাসিক বেতন ব্যাংক জমা</h3>
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
                                        <th>ক্রমিক নং </th>
                                        <th>উপাংশ</th>
                                        <th>কর্মকর্তা/কর্মচারী নাম </th>
                                        <th>পদবি</th>
                                        <th>হিসেব নং</th>
                                        <th>টাকা</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $i=1;$total=0;
                                    @endphp


                                    @foreach($salaries as $salary)


                                        <?php    $pf_found=0;
                                        if($salary->pfaccno == 0){
                                            $pf_found=0;

                                        }else{
                                            $pf_found=$salary->pf_found ;
                                        }



                                        $grataccno=0;
                                        if($salary->grataccnos == 0){
                                            $grataccno=0;
                                        }else{
                                            $grataccno=$salary->graduaty  ;
                                        }

                                        ?>
                                        <tr class="gradeX">
                                            <td>{{ enNumberToBn($i) }}</td>
                                            <td>
                                                @if($salary->upanansos==1)
                                                    উপাংশ-১  ( সাধারন )
                                                @elseif($salary->upanansos==3)
                                                    উপাংশ-১  ( শিক্ষা )
                                                @elseif($salary->upanansos==2)
                                                    উপাংশ-২
                                                @endif
                                            </td>

                                            <td>{{ $salary->name }}</td>
                                            <td>{{ $salary->designation }}</td>
                                            <td>{{ enNumberToBn($salary->salaryaccno) }}</td>

                                            <?php  $totalsalery= (int)$salary->salary + (int)$salary->houserent + (int)$salary->special_benefits + (int)$salary->treatment + (int)$salary->tifin + (int)$salary->wash + (int)$salary->education  +  (int)$salary->others - (int) $salary->tax;
                                            $netpayable =(int)$totalsalery -  (int)$pf_found - (int)$salary->pfloanadvance - (int)$salary->otherloan;


                                            ?>

                                            <td style="text-align: right">
                                               {{ enNumberToBn(number_format($netpayable,2)) }}
                                            </td>

                                        </tr>
                                        @php
                                            $total+=$netpayable;
                                            $i++;
                                        @endphp
                                    @endforeach
                                    <tr>

                                        <td colspan="4">সর্বমোট :</td>
                                        <td colspan="2" style="text-align: right;" >{{  enNumberToBn(number_format($total,2)) }}</td>
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
