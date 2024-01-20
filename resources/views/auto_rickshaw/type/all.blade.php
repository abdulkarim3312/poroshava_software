@extends('layouts.app')
@section('title','লাইসেন্সের ধরণ')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <section class="card card-default">
                <header class="card-header">
                    <a class="btn btn-success bg-gradient-success" href="{{ route('auto_rickshaw.type.add') }}">লাইসেন্সের ধরণ যুক্তকরন</a>
                </header>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="myTable">
                            <thead>
                            <tr>
                                <th>ক্রমিক নং</th>
                                <th>ধরণ</th>
                                <th>খাতের নাম</th>
                                <th>ধার্যকৃত লাইসেন্স ফি</th>
                                <th>১৫% ভ্যাট</th>
                                <th>টিন প্লেটের মূল্য</th>
                                <th>মোট টাকা</th>
                                <th>নাম পরিবর্তন ফি</th>
                                <th>অন্যান্য মূল্য</th>
                                <th>প্রক্রিয়া</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($types as $type)
                                <tr class="gradeX">
                                    <td>{{str_replace($en, $bn, $loop->iteration)}}</td>
                                    <td>{{ $type->type == 1 ? 'মালিক' : 'চালক' }}</td>
                                    <td>{{ $type->name }}</td>
                                    <td>{{str_replace($en, $bn, $type->fees)}}</td>
                                    <td>{{str_replace($en, $bn, $type->vat)}}</td>
                                    <td>{{str_replace($en, $bn, $type->tin_plate)}}</td>
                                    <td>{{str_replace($en, $bn, $type->total)}}</td>
                                    <td>{{str_replace($en, $bn, $type->name_change_fees)}}</td>
                                    <td>{{str_replace($en, $bn, $type->others)}}</td>
                                    <td width="7%">
                                        <a class="btn btn-success bg-gradient-success btn-sm" href="{{ route('auto_rickshaw.type.edit',['type'=>$type->id]) }}">Edit</a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>

                    </div>

                </div>
            </section>
        </div>
    </div>
@endsection
