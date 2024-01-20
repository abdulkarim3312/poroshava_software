@extends('layouts.app')
@section('title','আদায় পরিবর্তন করুন')
@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">আদায়ের তথ্য</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form  enctype="multipart/form-data" action="{{ route('collection.update',['collection'=>$collection->id]) }}" class="form-horizontal" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row {{ $errors->has('name') ? 'has-error' :'' }}">
                            <label for="name" class="col-sm-2 col-form-label">প্রদানকারীর নাম <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ old('name',$collection->name) }}" name="name" class="form-control" id="name" placeholder="নাম">
                                @error('name')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('mobile_no') ? 'has-error' :'' }}">
                            <label for="mobile_no" class="col-sm-2 col-form-label">প্রদানকারীর মোবাইল নম্বর <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ old('mobile_no',$collection->mobile_no) }}" name="mobile_no" class="form-control" id="mobile_no" placeholder="প্রদানকারীর মোবাইল নম্বর">
                                @error('mobile_no')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('holding_no') ? 'has-error' :'' }}">
                            <label for="holding_no" class="col-sm-2 col-form-label">প্রদানকারীর হোল্ডিং নম্বর</label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ old('holding_no',$collection->holding_no) }}" name="holding_no" class="form-control" id="holding_no" placeholder="প্রদানকারীর হোল্ডিং নম্বর">
                                @error('holding_no')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('area') ? 'has-error' :'' }}">
                            <label for="area" class="col-sm-2 col-form-label">প্রদানকারীর মহল্লা <span class="text-danger"> *</span></label>
                            <div class="col-sm-10">
                                <select class="form-control select2" id="area" name="area">
                                    <option value="">মহল্লা বাছাই করুন</option>
                                    @foreach($areas as $area)
                                        <option {{ $collection->area_id == $area->id ? 'selected' : '' }} value="{{ $area->id }}">{{ $area->area_name }}</option>
                                    @endforeach
                                </select>
                                @error('area')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('type') ? 'has-error' :'' }}">
                            <label for="type" class="col-sm-2 col-form-label">প্রদানের খাত <span class="text-danger"> *</span></label>
                            <div class="col-sm-10">
                                <select class="form-control select2" id="type" name="type">
                                    <option value="">খাত বাছাই করুন</option>
                                    @foreach($types as $type)
                                        <option {{ $collection->type_id == $type->id ? 'selected' : '' }} value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                @error('type')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('sub_type') ? 'has-error' :'' }}">
                            <label for="sub_type" class="col-sm-2 col-form-label">প্রদানের উপ খাত <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select class="form-control select2" id="sub_type" name="sub_type">
                                    <option value="">উপ খাত বাছাই করুন</option>
                                </select>
                                @error('sub_type')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('fees') ? 'has-error' :'' }}">
                            <label for="fees" class="col-sm-2 col-form-label">প্রদানের ফি <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ old('fees',$collection->fees) }}" name="fees" class="form-control" id="fees" placeholder="ফি">
                                @error('fees')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('vat') ? 'has-error' :'' }}">
                            <label for="vat" class="col-sm-2 col-form-label">ভ্যাট (%) <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ old('vat',$collection->vat_percent) }}" name="vat" class="form-control" id="vat" placeholder="ভ্যাট">
                                @error('vat')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                                <span>ভ্যাট এমাউন্ট: <span id="vat-amount">0</span></span>
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('sub_total') ? 'has-error' :'' }}">
                            <label for="sub_total" class="col-sm-2 col-form-label">সাব টোটাল <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" readonly value="{{ old('sub_total',$collection->sub_total) }}" name="sub_total" class="form-control" id="sub_total" placeholder="সাব টোটাল">
                                @error('sub_total')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('discount_type') ? 'has-error' :'' }}">
                            <label for="discount_type" class="col-sm-2 col-form-label">ডিসকাউন্টের ধরণ</label>
                            <div class="col-sm-10">
                                <select name="discount_type" id="discount_type" class="form-control">
                                    <option {{ $collection->discount_type == 1 ? 'selected' : '' }} value="1">শতাংশ</option>
                                    <option {{ $collection->discount_type == 2 ? 'selected' : '' }} value="2">পরিমাণ</option>
                                </select>
                                @error('discount_type')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('discount') ? 'has-error' :'' }}">
                            <label for="discount" class="col-sm-2 col-form-label">ডিসকাউন্ট পরিমাণ</label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ old('discount',($collection->discount_type == 1 ? $collection->discount_percent : $collection->discount)) }}" name="discount" class="form-control" id="discount" placeholder="ডিসকাউন্ট">
                                @error('discount')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                                <span id="discount-area" style="display:none">ডিসকাউন্ট এমাউন্ট: <span  id="discount-amount">0</span></span>

                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('grand_total') ? 'has-error' :'' }}">
                            <label for="grand_total" class="col-sm-2 col-form-label">গ্রান্ড টোটাল <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" readonly value="{{ old('grand_total',$collection->grand_total) }}" name="grand_total" class="form-control" id="grand_total" placeholder="গ্রান্ড টোটাল">
                                @error('grand_total')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('date') ? 'has-error' :'' }}">
                            <label for="date" class="col-sm-2 col-form-label">তারিখ <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" autocomplete="off" value="{{ old('date',\Carbon\Carbon::parse($collection->date)->format('d-m-Y')) }}" name="date" class="form-control date-picker" id="date" placeholder="তারিখ">
                                @error('date')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">সংরক্ষণ</button>
                        <a href="{{ route('collection.all') }}" class="btn btn-default float-right">বাতিল</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
            <!-- /.card -->
        </div>
        <!--/.col (left) -->
    </div>
@endsection
@section('script')
    <script>
        $(function (){

            var selectedSubTYpe = '{{ $collection->sub_type_id }}';
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

            $('#sub_type').change(function (){
                var subTypeId = $(this).val();

                if (subTypeId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('collection.get_fees') }}",
                        data: {subTypeId:subTypeId}
                    }).done(function( response ) {
                        if(response.fees > 0)
                            $('#fees').val(response);

                        calculate();
                    });
                }
            });
            $('#sub_type').trigger("change");

            $('body').on('keyup', '#fees,#vat,#discount', function () {
                calculate();
            });
            $('body').on('change','#discount_type', function () {
                calculate();
            });
        })

        function calculate() {

            var vat = $('#vat').val();
            var discount = $('#discount').val();
            var discountType = $('#discount_type').val();
            var fees = $('#fees').val();

            vat = replaceNumbers(vat);
            discount = replaceNumbers(discount);
            fees = replaceNumbers(fees);

            if (vat == '' || vat < 0 || !$.isNumeric(vat))
                vat = 0;

            if (discount == '' || discount < 0 || !$.isNumeric(discount))
                discount = 0;

            if (fees == '' || fees < 0 || !$.isNumeric(fees))
                fees = 0;


            if(discountType == 1){
                discount = (fees * discount) / 100;
                $("#discount-amount").html(discount);
                $("#discount-area").show();
            }else {
                $("#discount-area").hide();
            }

            var totalVat = (fees * vat) / 100;

            var subTotal = parseFloat(totalVat) + parseFloat(fees);

            $("#sub_total").val(subTotal);
            $("#vat-amount").html(totalVat);
            $("#grand_total").val(parseFloat(subTotal) - parseFloat(discount));

        }
        var numbers = {
            '০': 0,
            '১': 1,
            '২': 2,
            '৩': 3,
            '৪': 4,
            '৫': 5,
            '৬': 6,
            '৭': 7,
            '৮': 8,
            '৯': 9
        };
        function replaceNumbers(input) {
            var output = [];
            for (var i = 0; i < input.length; ++i) {
                if (numbers.hasOwnProperty(input[i])) {
                    output.push(numbers[input[i]]);
                } else {
                    output.push(input[i]);
                }
            }
            return output.join('');
        }
    </script>
@endsection
