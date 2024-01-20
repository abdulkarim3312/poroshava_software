@extends('layouts.app')
@section('title','এ্যাবস্ট্রাক্ট রেজিস্টার')
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
                <form action="{{ route('report.abstract_register') }}">
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
                                        @for($i=2019; $i <= date('Y'); $i++)
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
                                        @foreach($banglaMonths as $banglaMonth)
                                            <option
                                                {{ request('month') == $banglaMonth ? 'selected' : '' }} value="{{ $banglaMonth }}">{{ $banglaMonth }}</option>
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
    @if(count($expdates1) > 0 || count($expdates1) > 0)
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
                                    <h3 class="text-center m-0 mb-2" style="font-size: 19px !important;">মাসিক বেতন
                                        ব্যাংক জমা</h3>
                                    <h3 class="text-center m-0 mb-2"
                                        style="font-size: 19px !important;">{{ $selectUpangsho->upangsho_name }}</h3>
                                    <h3 class="text-center m-0 mb-2" style="font-size: 19px !important;">
                                        মাসের নামঃ {{ enNumberToBn($yearMonth) }}</h3>
                                </div>
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th rowspan="2" style="vertical-align: middle;">তারিখ</th>
                                    @foreach($mainheads1 as $mh)
                                        @if($mh->subormain!=1)
                                            <th colspan="{{ colspan($mh->tax_id) }}">{{ $mh->tax_name }}</th>
                                        @else
                                            <th colspan="{{ colspan($mh->tax_id) }}" rowspan="2">{{ $mh->tax_name }}</th>
                                        @endif
                                    @endforeach
                                </tr>
                                <tr>
                                    @foreach($mainheads1 as $mh)
                                        @if($mh->subormain!=1)
                                            {!! getheads($mh->tax_id)  !!}
                                        @endif
                                    @endforeach
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($expdates1 as $ed)
                                    <tr>
                                        <td>{{ enNumberToBn(\Carbon\Carbon::parse($ed->date)->format('d-m-Y')) }}</td>
                                        @foreach($mainheads1 as $mh)
                                            {!! getrows($mh->tax_id, $ed->date) !!}
                                        @endforeach
                                    </tr>
                                @endforeach
                                <tr>
                                    <td>মোট</td>
                                    @foreach($mainheads1 as $mh)
                                        <?php

                                        $khats = App\Models\Khat::where('tax_type_id', $mh->tax_id)->get();
                                        ?>
                                        @foreach($khats as $kt)
                                            <td align="right">{{ enNumberToBn((getTotal($kt->khat_id, $month))) }}</td>
                                        @endforeach
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>গত মাসের জের</td>
                                    @foreach($mainheads1 as $mh)
                                        <?php
                                        $khats = App\Models\Khat::where('tax_type_id', $mh->tax_id)->get();
                                        ?>
                                        @foreach($khats as $kt)
                                            <td align="right">{{ enNumberToBn(getPrevTotal($kt->khat_id, $month,2)) }}</td>
                                        @endforeach
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>সর্ব মোট</td>
                                    @foreach($mainheads1 as $mh)
                                        <?php
                                        $khats = App\Models\Khat::where('tax_type_id', $mh->tax_id)->get();
                                        ?>
                                        @foreach($khats as $kt)
                                            <td align="right">{{ enNumberToBn((getGrandTotal($kt->khat_id, $month))) }}</td>
                                        @endforeach
                                    @endforeach
                                </tr>
                                </tbody>
                            </table>
                            <table class="display table table-bordered">
                                <thead>
                                <tr>
                                    <th rowspan="2" style="vertical-align: middle;">তারিখ</th>
                                    @foreach($mainheads2 as $mh)
                                        @if($mh->subormain!=1)
                                            <th colspan="{{ colspan($mh->tax_id) }}">{{ $mh->tax_name }}</th>
                                        @else
                                            <th colspan="{{ colspan($mh->tax_id) }}" rowspan="2">{{ $mh->tax_name }}</th>
                                        @endif
                                    @endforeach
                                </tr>
                                <tr>
                                    @foreach($mainheads2 as $mh)
                                        @if($mh->subormain!=1){
                                        {!! getheads($mh->tax_id) !!}
                                        @endif
                                    @endforeach
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($expdates2 as $ed)
                                    <tr>
                                        <td>{{ enNumberToBn(\Carbon\Carbon::parse($ed->date)->format('d-m-Y')) }}</td>
                                        @foreach($mainheads2 as $mh)
                                            {!! getrows($mh->tax_id, $ed->date) !!}
                                        @endforeach
                                    </tr>
                                @endforeach
                                <tr>
                                    <td>মোট</td>
                                    @foreach($mainheads2 as $mh)
                                        <?php
                                        $khats = App\Models\Khat::where('tax_type_id', $mh->tax_id)->get();
                                        ?>
                                        @foreach($khats as $kt)
                                            <td align="right"{{ getTotal($kt->khat_id, $month) }}</td>
                                        @endforeach
                                    @endforeach

                                </tr>
                                <tr>
                                    <td>গত মাসের জের</td>
                                    @foreach($mainheads2 as $mh)
                                        <?php
                                        $khats = App\Models\Khat::where('tax_type_id', $mh->tax_id)->get();
                                        ?>
                                        @foreach($khats as $kt)
                                            <td align="right">{{ getPrevTotal($kt->khat_id, $month) }}</td>
                                        @endforeach
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>সর্ব মোট</td>
                                    @foreach($mainheads2 as $mh)
                                        <?php
                                        $khats = App\Models\Khat::where('tax_type_id', $mh->tax_id)->get();
                                        ?>
                                        @foreach($khats as $kt)
                                            <td align="right">{{ getGrandTotal($kt->khat_id, $month) }}</td>
                                        @endforeach
                                    @endforeach
                                </tr>
                                </tbody>
                            </table>
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
