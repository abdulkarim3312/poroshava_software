@extends('layouts.app')
@section('title','ব্যবহারকারী হালনাগতকারী লগ রিপোর্ট')
@section('style')
    <style>
        .table-bordered td, .table-bordered th {
            vertical-align: middle !important;
        }
        .table td, .table th {
            padding: 3px;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-default">
                <div class="card-header">
                    <div class="card-title">ফিল্টার</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('collection.report.user_log') }}" method="get">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="start">শুরুর তারিখ <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ request('start') }}" required autocomplete="off" id="start" name="start" class="form-control date-picker" placeholder="শুরুর তারিখ">

                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="end">শেষ তারিখ <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ request('end') }}" required autocomplete="off" id="end" name="end" class="form-control date-picker" placeholder="শেষ তারিখ">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="type">খাত</label>
                                    <select class="form-control select2" id="type" name="type">
                                        <option value="">খাত বাছাই করুন</option>
                                        @foreach($types as $type)
                                            <option {{ request()->get('type') == $type->id ? 'selected' : '' }} value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="sub_type">উপ খাত</label>
                                    <select class="form-control select2" id="sub_type" name="sub_type">
                                        <option value="">উপ খাত বাছাই করুন</option>
                                    </select>
                                </div>
                            </div>
                            @if(\Illuminate\Support\Facades\Auth::user()->sub_role != \App\Enumeration\SubRole::$COLLECTOR)
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="collector">আদায়কারী</label>
                                        <select class="form-control select2" id="collector" name="collector">
                                            <option value="">আদায়কারী বাছাই করুন</option>
                                            @foreach($users as $user)
                                                <option {{ request()->get('collector') == $user->id ? 'selected' : '' }} value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <input type="submit" name="search" class="btn btn-success bg-gradient-success form-control" value="সার্চ">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @if(count($collections) > 0)
        <div class="col-12">
            <div class="card card-default">

                <div class="card-header">
                    <a role="button" onclick="getprint('prinarea')"  class="btn btn-default pull-right"><i class="fas fa-print"></i></a>
                </div>
                <!-- /.card-header -->
                <div class="card-body"  id="prinarea">
                    <div class="text-center">
                        <h2>{{ config('app.name') }}</h2>
                        <h5>আদায় হালনাগত লগ রিপোর্ট</h5>
                        @if(request('start') != '' && request('end') != '')
                            <h5>তারিখ: {{ bn_number(request('start')) }} - {{ bn_number(request('end')) }}</h5>
                        @endif
                    </div>
                    <div class="table-responsive">
                        <table id="table" class="table table-bordered">
                              <tr>
                                    <th class="text-center">ক্রমিক নং</th>
                                    <th class="text-center">তারিখ</th>
                                    <th class="text-center">খাত</th>
                                    <th class="text-center">উপ খাত</th>
                                    <th class="text-center">আগের গ্রান্ড টোটাল</th>
                                    <th class="text-center">হালনাগতকারী</th>
                                    <th class="text-center">হালনাগাদ তারিখ</th>
                                    <th class="text-center">হালনাগাদ গ্রান্ড টোটাল</th>
                                </tr>
                            @if(count($collections) > 0)
                                @foreach($collections as $collection)
                                <tr>
                                    <td class="text-center">{{ bn_number($collection->receipt_no) }}</td>
                                    <td class="text-center">{{ bn_number(\Carbon\Carbon::parse($collection->date)->format('d-m-Y')) }}</td>
                                    <td class="text-center">{{ $collection->type->name }}</td>
                                    <td class="text-center">{{ $collection->subType->name }}</td>
                                    <td class="text-center">{{ en_to_bn($collection->old_grand_total) }}</td>
                                    <td class="text-center">{{ $collection->updateBy->name }}</td>
                                    <td class="text-center">{{ bn_number($collection->updated_at->format('d-m-Y')) }}</td>
                                    <td class="text-center">{{ en_to_bn($collection->grand_total) }}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <th colspan="4" class="text-right">সর্বমোট:</th>
                                    <td class="text-center">{{ en_to_bn($collections->sum('old_grand_total')) }}</td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-center">{{ en_to_bn($collections->sum('grand_total')) }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="10" class="text-center"><div class="text-danger">কিছুই পাওয়া যায় না!</div></td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        @endif
    </div>
@endsection
@section('script')
    <script>
        $(function () {


            var selectedSubTYpe = '{{ request()->get('sub_type') }}';
            //Select Type
            $('#type').change(function (){
                var typeId = $(this).val();

                $('#sub_type').html('<option value="">উপ খাত বাছাই করুন</option>');

                if (typeId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('collection.get_sub_type') }}",
                        data: {typeId:typeId}
                    }).done(function( data ) {
                        $.each(data, function( index, item ) {
                            if (selectedSubTYpe == item.id)
                                $('#sub_type').append('<option value="'+item.id+'" selected>'+item.name+'</option>');
                            else
                                $('#sub_type').append('<option value="'+item.id+'">'+item.name+'</option>');
                        });
                        $('#sub_type').trigger("change");
                    });

                }
            });
            $('#type').trigger("change");

        });
        function getprint(print) {
            var APP_URL = '{!! url()->full()  !!}';
            $('body').html($('#'+print).html());
            window.print();
            window.location.replace(APP_URL)
        }
    </script>
@endsection
