@extends('layouts.app')
@section('title')
    বোনাস প্রস্তুত করুন
@endsection

@section('content')

<?php
    $en = [1,2,3,4,5,6,7,8,9,0];
    $bn = ['১','২','৩','৪','৫','৬','৭','৮','৯','০'];

?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">বোনাস প্রস্তুত করুন</h3>
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                    <form action="{{ route('cleaner_bonus_process') }}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>বোনাস</label>

                                    <select class="form-control" name="bonus" id="bonus" required>
                                        <option value="">বোনাস নির্ধারণ</option>
                                        <option value="1">ঈদ উল ফিতর</option>
                                        <option value="2">ঈদ উল আজহা</option>
                                        <option value="3">পহেলা বৈশাখ</option>
                                        <option value="4">দূর্গা পুজা</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>প্রস্তুত তারিখ</label>

                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right"
                                               id="date" name="date" value="{{ date('Y-m-d')  }}" autocomplete="off" required>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>

                            <div class="col-md-4 pull-right">
                                <div class="form-group">
                                    <label>	&nbsp;</label>

                                    <input class="btn btn-success bg-gradient-success form-control" type="submit" value="প্রস্তুত করুন">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <script>
        $(function () {
            //Date picker
            $('#date').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd',
                orientation: 'bottom'
            });
        });
    </script>
@endsection

