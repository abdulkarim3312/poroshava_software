@extends('layouts.app')
@section('title','যানবাহন লাইসেন্সের ধরণ যুক্তকরন')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <section class="card card-default">
                <header class="card-header">
                    <h3 class="card-title">যানবাহন লাইসেন্সের ধরণ যুক্তকরন</h3>
                </header>
                <form role="form" class="cmxform form-horizontal tasi-form" id="MenuForm"  method="post"  id="commentForm" action="{{ route('auto_rickshaw.type.add') }}">
                    @csrf
                <div class="card-body">

                        <div class="form-group row">
                            <label for="inputSuccess" class="col-sm-2 control-label col-lg-2"><strong>ধরণ*</strong></label>
                            <div class="col-lg-10">
                                <select name="type" class="form-control" >
                                    <option value="">ধরণ নির্ধারণ</option>
                                    <option {{ old('type') == 1 ? 'selected' : '' }} value="1">মালিক</option>
                                    <option {{ old('type') == 2 ? 'selected' : '' }} value="2">চালক</option>
                                </select>
                                @error('type')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputSuccess" class="col-sm-2 control-label col-lg-2"><strong>খাতের নাম *</strong></label>
                            <div class="col-lg-10">
                                <input type="text" value="{{ old('name') }}" class="form-control" placeholder="খাতের নাম" id="" name="name" >
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputSuccess" class="col-sm-2 control-label col-lg-2"><strong>ধার্যকৃত লাইসেন্স ফি *</strong></label>
                            <div class="col-lg-10">
                                <input type="text" value="{{ old('fees') }}" class="form-control" placeholder="ধার্যকৃত লাইসেন্স ফি" id="fees" name="fees" >
                                @error('fees')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputSuccess" class="col-sm-2 control-label col-lg-2"><strong>১৫% ভ্যাট *</strong></label>
                            <div class="col-lg-10">
                                <input readonly value="15" type="text" class="form-control" placeholder="১৫% ভ্যাট" id="vat" name="vat" >
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="inputSuccess" class="col-sm-2 control-label col-lg-2"><strong>টিন প্লেটের মূল্য</strong></label>
                            <div class="col-lg-10">
                                <input type="text" value="{{ old('tin_plate') }}" class="form-control" placeholder="টিন প্লেটের মূল্য" id="tin_plate" name="tin_plate">
                                @error('tin_plate')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputSuccess" class="col-sm-2 control-label col-lg-2"><strong>মোট টাকা *</strong></label>
                            <div class="col-lg-10">
                                <input readonly type="text" class="form-control" value="{{ old('total') }}" placeholder="মোট টাকা" id="total" name="total" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputSuccess" class="col-sm-2 control-label col-lg-2"><strong>নাম পরিবর্তন ফি</strong></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" value="{{ old('name_change_fees') }}" placeholder="নাম পরিবর্তন ফি" id="name_change_fees" name="name_change_fees">
                                @error('name_change_fees')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputSuccess" class="col-sm-2 control-label col-lg-2"><strong>অন্যান্য</strong></label>
                            <div class="col-lg-10">
                                <input type="text" value="{{ old('others') }}" class="form-control" placeholder="অন্যান্য মূল্য" id="others" name="others">
                                @error('others')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>





                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success bg-gradient-success">দাখিল করুন</button>
                </div>
                </form>
            </section>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function (){
            $('body').on('keyup', '#fees, #vat,#tin_plate,#others', function () {
                calculate();
            });
        });

        function calculate(){
            var total = 0;
            var fees = $('#fees').val();
            var vat = $('#vat').val();
            var tin_plate = $('#tin_plate').val();
            var others = $('#others').val();

            if (fees == '' || fees < 0 || !$.isNumeric(fees))
                fees = 0;

            if (vat == '' || vat < 0 || !$.isNumeric(vat))
                vat = 0;

            if (tin_plate == '' || tin_plate < 0 || !$.isNumeric(tin_plate))
                tin_plate = 0;

            if (others == '' || others < 0 || !$.isNumeric(others))
                others = 0;


            var vatTotal = (parseFloat(fees) / 100) * parseFloat(vat);
            total =  parseFloat(fees) + parseFloat(vatTotal) + parseFloat(tin_plate) + parseFloat(others);
            $('#total').val(parseFloat(total));
        }
    </script>
@endsection
