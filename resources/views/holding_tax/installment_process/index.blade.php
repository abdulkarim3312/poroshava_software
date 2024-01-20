@extends('layouts.app')
@section('title','কিস্তি বিল প্রক্রিয়া')
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
            font-size: 15px !important;
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
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('installment_process.post') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="type">ধরণ <span class="text-danger">*</span></label>
                                    <select required name="upangsho" class="form-control select2" id="type">
                                        <option value="">সিলেক্ট করুণ</option>
                                        <option value="1">১ম চলতি</option>
                                        <option value="2">২য় চলতি</option>
                                        <option value="3">৩য় চলতি</option>
                                        <option value="4">৪র্থ চলতি</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="start_date">বিল ইস্যুর তারিখ <span class="text-danger">*</span></label>
                                    <input required type="text" id="issue_date" autocomplete="off" name="issue_date" class="form-control date-picker"
                                           placeholder="শুরুর তারিখ লিখুন" value="{{ request()->get('issue_date')  }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="end_date">জমাদানের শেষ তারিখ <span class="text-danger">*</span></label>
                                    <input required type="text" id="last_date" autocomplete="off"
                                           name="last_date" class="form-control date-picker"
                                           placeholder="শেষের তারিখ লিখুন" value="{{ request()->get('last_date')  }}">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <input type="submit" class="btn btn-success bg-gradient-success form-control" value="প্রক্রিয়া">
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
@endsection

