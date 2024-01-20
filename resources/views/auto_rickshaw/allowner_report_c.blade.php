@extends('layouts.app')
@section('title','মালিকের লাইসেন্স আদায়')
@section('style')
    <style>
        .table-bordered td, .table-bordered th {
            border: 1px solid #000000 !important;
        }
        .table thead th {
            border-bottom: 2px solid #000000 !important;
        }
    </style>
@endsection
@section('content')
    <?php
    $bn = array('১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০');
    $en = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0');
    ?>
    <div class="row">
        <div class="col-lg-12">
            <section class="card">
                <header class="card-header">
                    <h3 class="card-title">ফিল্টারিং</h3>
                </header>
                <div class="card-body">
                    <form action="{{ route('auto_rickshaw.report_owner_license_collection') }}">
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label for="">ধরন</label>
                                <select class="form-control select2" name="type" id="">
                                    <option value="">ধরন নির্ধারণ</option>
                                    @foreach($types as $type)
                                        <option {{ request()->get('type') == $type->id ? 'selected' : '' }} value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="">অর্থবছর</label>
                                <select class="form-control select2" name="fiscal_year" id="">
                                    <option value="">অর্থবছর নির্ধারণ</option>
                                    @for($i=2021; $i <= date('Y'); $i++)
                                        <option value="{{ $i }}-{{ $i+1 }}" {{ old('fiscal_year',request()->get('fiscal_year')) == ($i.'-'.$i+1) ? 'selected' : '' }}>{{ $i }}-{{ $i+1 }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="">তারিখ শুরু <span class="text-danger">*</span></label>
                                <input type="text" autocomplete="off" class="form-control date-picker" placeholder="তারিখ শুরু" name="start_date" value="{{ request()->get('start_date') }}" required>
                            </div>
                            <div class="col-md-3">
                                <label for="">তারিখ শেষ <span class="text-danger">*</span></label>
                                <input type="text" autocomplete="off" class="form-control date-picker" placeholder="তারিখ শেষ" name="end_date" value="{{ request()->get('end_date') }}" required>
                            </div>
                            <div class="col-md-12">
                                <label for=""></label>
                                <br>
                                <input type="submit" name="submit" class="btn btn-primary pull-right mt-3" value="খুজুন">
                            </div>

                        </div>
                    </form>
                </div>
            </section>
            @if(count($licences) > 0)
                <section class="card">
                    <header class="card-header">
                        <a href="#" onclick="getprint('printable')" class="btn btn-primary btn-sm">Print</a>
                    </header>
                    <div class="card-body">
                        <div class="table-responsive" id="printable">
                            <div class="report-info text-center">
                                <h2>{{ config('app.full_name') }}</h2>
                                <h4>যানবাহন মালিকের লাইসেন্স আদায় রিপোর্ট</h4>
                                <br>
                            </div>
                            <table class="display table table-bordered" id="table">
                                <thead>
                                <tr>
                                    <th class="text-center">ক্রমিক নং</th>
                                    <th class="text-center">ধরন</th>
                                    <th class="text-center">অর্থ বছর</th>
                                    <th class="text-center">নাম</th>
                                    <th class="text-center">লাইসেন্স নং</th>
                                    <th class="text-center">টিন প্লেট নং</th>
                                    <th class="text-center">ফি</th>
                                    <th class="text-center">১৫% ভ্যাট</th>
                                    <th class="text-center">টিন প্লেট মূল্য</th>
                                    <th class="text-center">নাম পরিবর্তন</th>
                                    <th class="text-center">মোট টাকা</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($licences as $licence)
                                    <tr>
                                        <td>{{ $licence->slno }}</td>
                                        <td>{{ $licence->type->name }}</td>
                                        <td>{{ $licence->year }}</td>
                                        <td>{{ $licence->name }}</td>
                                        <td>{{ $licence->licenseno }}</td>
                                        <td>{{ $licence->plate_no }}</td>
                                        <td class="text-right">{{ str_replace($en, $bn,number_format($licence->licensefee,2)) }}</td>
                                        <td class="text-right">{{ str_replace($en, $bn,$licence->vat) }}</td>
                                        <td class="text-right">{{ str_replace($en, $bn,number_format($licence->tinplate,2)) }}</td>
                                        <td class="text-right">{{ str_replace($en, $bn,number_format($licence->name_change_fees,2)) }}</td>
                                        <td class="text-right">{{ str_replace($en, $bn,number_format($licence->total + $licence->name_change_fees,2)) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th colspan="6" class="text-right">মোট </th>
                                    <th class="text-right">{{ str_replace($en, $bn,number_format($licence->sum('licensefee'),2)) }}</th>
                                    <th class="text-right">{{ str_replace($en, $bn,$licence->sum('vat')) }}</th>
                                    <th class="text-right">{{ str_replace($en, $bn,number_format($licence->sum('tinplate'),2)) }}</th>
                                    <th class="text-right">{{ str_replace($en, $bn,number_format($licence->sum('name_change_fees'),2)) }}</th>
                                    <th class="text-right">{{ str_replace($en, $bn,number_format($licence->sum('total') + $licence->sum('name_change_fees'),2)) }}</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </section>
            @endif
        </div>
    </div>
@endsection
@section('script')
    <script>
        var APP_URL = '{!! url()->full()  !!}';
        function getprint(id){

            $('body').html($('#'+id).html());
            window.print();
            window.location.replace(APP_URL)
        }

    </script>
@endsection

