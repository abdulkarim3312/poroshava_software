@extends('layouts.app')
@section('title','চালকের লাইসেন্স রিপোর্ট')
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
    <div class="row">
        <div class="col-lg-12">
            <section class="card">
                <header class="card-header">
                    <h3 class="card-title">ফিল্টারিং</h3>
                </header>
                <div class="card-body">
                    <form action="{{ route('auto_rickshaw.report_vehicle_license') }}">
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
                                <select class="form-control" name="fiscal_year" id="">
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
                                <h4>যানবাহন চালকের লাইসেন্স রিপোর্ট</h4>
                                <br>
                            </div>
                            <table class="display table table-bordered" id="table">
                                <thead>
                                <tr>
                                    <th>ক্রমিক নং</th>
                                    <th>ধরন</th>
                                    <th>অর্থ বছর</th>
                                    <th>নাম</th>
                                    <th>পিতার নাম</th>
                                    <th>স্থায়ী  ঠিকানা</th>
                                    <th>বর্তমান ঠিকানা</th>
                                    <th>লাইসেন্স নং</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($licences as $licence)
                                    <tr>
                                        <td>{{ $licence->slno }}</td>
                                        <td>{{ $licence->type->name }}</td>
                                        <td>{{ $licence->year }}</td>
                                        <td>{{ $licence->name }}</td>
                                        <td>{{ $licence->fname }}</td>
                                        <td>{{ $licence->address }}</td>
                                        <td>{{ $licence->current_address }}</td>
                                        <td>{{ $licence->licenseno }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
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

