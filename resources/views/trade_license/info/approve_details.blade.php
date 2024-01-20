@extends('layouts.app')

@section('title')
    ট্রেড লাইসেন্স নিবন্ধন তথ্য
@endsection
@section('style')
    <style>
        .form-control{
            font-size: 12px !important;
            height: fit-content;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header with-border" style="background-color: #0e5b44;color: white;">
                    <h3 class="card-title">ট্রেড লাইসেন্স নিবন্ধন তথ্য আপডেট</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ route('trade_license_add_license',['tradeUser'=>$tradeUser->id]) }}" style="font-size: 12px;">
                    @csrf

                    <div class="card-body">
                        <div class="row">
                            <label class="col-sm-2 col-form-label">লাইসেন্স নাম্বার</label>
                            <div class="col-sm-4 form-group {{ $errors->has('licence_id') ? 'has-error' :'' }}">
                                <input type="hidden" name="licence_id" value="{{ $tradeUser->licence_id }}">
                                <input type="text" class="form-control" placeholder=""
                                       name="licence_no" value="{{ enNumberToBn(old('licence_no',$tradeUser->licence_no)) }}">

                                @error('licence_id')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <label class="col-sm-2 col-form-label">প্রতিষ্ঠানের নাম</label>
                            <div class="col-sm-4 form-group {{ $errors->has('organization_name') ? 'has-error' :'' }}">
                                <input type="text" class="form-control" placeholder=""
                                       name="organization_name" value="{{ old('organization_name',$tradeUser->organization_name) }}">

                                @error('organization_name')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label">মালিকের নাম</label>
                            <div class="col-sm-4 form-group {{ $errors->has('name') ? 'has-error' :'' }}">
                                <input type="text" class="form-control" placeholder=""
                                       name="name" value="{{ old('name',$tradeUser->name) }}">

                                @error('name')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <label class="col-sm-2 col-form-label">পিতা/ স্বামীর নাম</label>
                            <div class="col-sm-4 form-group {{ $errors->has('father_husband_name') ? 'has-error' :'' }}">
                                <input type="text" class="form-control" placeholder=""
                                       name="father_husband_name" value="{{ old('father_husband_name',$tradeUser->father_husband_name) }}">

                                @error('father_husband_name')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label">মাতার নাম</label>
                            <div class="col-sm-4 form-group {{ $errors->has('mother_name') ? 'has-error' :'' }}">
                                <input type="text" class="form-control" placeholder=""
                                       name="mother_name" value="{{ old('mother_name',$tradeUser->mother_name) }}">

                                @error('mother_name')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <label class="col-sm-2 col-form-label">এন আই ডি</label>
                            <div class="col-sm-4 form-group {{ $errors->has('nid_no') ? 'has-error' :'' }}">
                                <input type="text" class="form-control" placeholder=""
                                       name="nid_no" value="{{ enNumberToBn(old('nid_no',$tradeUser->nid_no)) }}">

                                @error('nid_no')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label">মোবাইল নাম্বার</label>
                            <div class="col-sm-4 form-group {{ $errors->has('mobile_no') ? 'has-error' :'' }}">
                                <input type="text" class="form-control" placeholder=""
                                       name="mobile_no" value="{{ enNumberToBn(old('mobile_no',$tradeUser->mobile_no)) }}">

                                @error('mobile_no')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <label class="col-sm-2 col-form-label">প্রতিষ্ঠানের ঠিকানা</label>
                            <div class="col-sm-4 form-group {{ $errors->has('organization_address') ? 'has-error' :'' }}">
                                <input type="text" class="form-control" placeholder=""
                                       name="organization_address" value="{{ old('organization_address',$tradeUser->organization_address) }}">

                                @error('organization_address')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-sm-2 col-form-label">হোল্ডিং নং</label>
                            <div class="col-sm-4 form-group {{ $errors->has('holding_no') ? 'has-error' :'' }}">
                                <input type="hidden" name="holding_no_name" class="holding_no_name">
                                <select name="holding_no" class="form-control select2 holding_no">
                                    <option value="">নির্বাচন করুন</option>
                                    @if (old('holding_no') != '')
                                        <option value="{{ old('holding_no') }}" selected>{{ enNumberToBn(old('holding_no_name')) }}</option>
                                    @endif
                                    @if ($tradeUser->holding_no)
                                        <option value="{{ $tradeUser->holding_no }}" selected>{{ enNumberToBn($tradeUser->holding_no) }}</option>
                                    @endif
                                </select>
                                @error('holding_no')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <label class="col-sm-2 col-form-label">দোকান নং</label>
                            <div class="col-sm-4 form-group {{ $errors->has('shop_no') ? 'has-error' :'' }}">
                                <input type="text" class="form-control" placeholder=""
                                       name="shop_no" value="{{ enNumberToBn(old('shop_no',$tradeUser->shop_no)) }}">

                                @error('shop_no')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-sm-2 col-form-label">মালিকের বর্তমান ঠিকানা</label>
                            <div class="col-sm-4 form-group {{ $errors->has('holding_no') ? 'has-error' :'' }}">
                                <textarea name="present_address" class="form-control">{{ old('present_address',$tradeUser->present_address) }}</textarea>
                                @error('present_address')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <label class="col-sm-2 col-form-label">মালিকের স্থায়ী ঠিকানা</label>
                            <div class="col-sm-4 form-group {{ $errors->has('permanent_address') ? 'has-error' :'' }}">
                                <textarea name="permanent_address" class="form-control">{{ old('permanent_address',$tradeUser->permanent_address) }}</textarea>

                                @error('permanent_address')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label">ওয়ার্ড নং</label>
                            <div class="col-sm-4 form-group {{ $errors->has('ward_id') ? 'has-error' :'' }}">
                                <select name="ward_id" class="form-control select2">
                                    <option value="">নির্বাচন করুন</option>
                                    @foreach($wardInfos as $wardInfo)
                                        <option value="{{ $wardInfo->id }}" {{$wardInfo->id==$tradeUser->ward_id?'selected':''}}>{{ enNumberToBn($wardInfo->ward_no) }}</option>
                                    @endforeach
                                </select>
                                @error('ward_id')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <label class="col-sm-2 col-form-label">মহল্লা/সার্কেল/রাস্তার নাম</label>
                            <div class="col-sm-4 form-group {{ $errors->has('road_id') ? 'has-error' :'' }}">
                                <select name="road_id" class="form-control select2">
                                    <option value="">নির্বাচন করুন</option>
                                    @foreach($areas as $area)
                                        <option value="{{ $area->id }}" {{$area->id==$tradeUser->road_id?'selected':''}}>{{ $area->road_name }}</option>
                                    @endforeach
                                </select>
                                @error('road_id')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label">ব্যবসার ধরন</label>
                            <div class="col-sm-4 form-group {{ $errors->has('business_type') ? 'has-error' :'' }}">
                                <select name="business_type" class="form-control business_type select2">
                                    <option value="">নির্বাচন করুন</option>
                                    @foreach($businessTypes as $businessType)
                                        <option value="{{ $businessType->id }}" data-rate="{{ $businessType->type_rate }}" {{ $businessType->id==old('business_type',$tradeUser->business_type_id)?'selected':'' }}>{{ $businessType->business_type }}</option>
                                    @endforeach
                                </select>
                                <span>{{ $tradeUser->business_type_name }}</span>
                                @error('business_type')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <label class="col-sm-2 col-form-label">লাইসেন্স ইস্যুর তারিখ</label>
                            <div class="col-sm-4 form-group {{ $errors->has('issue_date') ? 'has-error' :'' }}">
                                @if($tradeUser->licence_issue_date)
                                     <input required type="text" id="issue_date" autocomplete="off" name="issue_date" class="form-control date-picker" placeholder="লাইসেন্স ইস্যুর তারিখ" value="{{ date("d-m-Y", strtotime($tradeUser->licence_issue_date)) }}">
                                @else
                                    <input required type="text" id="issue_date" autocomplete="off" name="issue_date" class="form-control date-picker" placeholder="লাইসেন্স ইস্যুর তারিখ" value="{{ old('issue_date') }}">
                                @endif
                                @error('issue_date')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label">সাইনবোর্ডের ধরন</label>
                            <div class="col-sm-4 form-group {{ $errors->has('signboard_type') ? 'has-error' :'' }}">
                                <select name="signboard_type" class="form-control signboard_type select2">
                                    <option value="">নির্বাচন করুন</option>
                                    @foreach($signBoards as $signBoard)
                                        <option value="{{ $signBoard->id }}" data-rate="{{ $signBoard->sign_board_rate }}" {{$signBoard->id==old('signboard_type',$tradeUser->signboard_id)?'selected':''}}>{{ $signBoard->sign_board_type }}</option>
                                    @endforeach
                                </select>
                                @error('signboard_type')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <label class="col-sm-2 col-form-label">সাইনবোর্ড সাইজ(ব.ফু)</label>
                            <div class="col-sm-4 form-group {{ $errors->has('signboard_size') ? 'has-error' :'' }}">
                                <input required type="text" name="signboard_size" class="form-control signboard_size" placeholder="" value="{{ enNumberToBn(old('signboard_size',$tradeUser->signboard_size)) }}">
                                @error('signboard_size')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-sm-2 col-form-label">লাইসেন্স ফি</label>
                            <div class="col-sm-4 form-group {{ $errors->has('licence_fee') ? 'has-error' :'' }}">
                                <input type="text" name="licence_fee" class="form-control licence_fee" placeholder="" readonly="readonly" value="{{ enNumberToBn(old('licence_fee',$tradeUser->licence_fee)) }}">
                                @error('licence_fee')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <label class="col-sm-2 col-form-label">সাইনবোর্ড ফি</label>
                            <div class="col-sm-4 form-group {{ $errors->has('signboard_fee') ? 'has-error' :'' }}">
                                <input type="text" name="signboard_fee" class="form-control signboard_fee" placeholder="" readonly="readonly" value="{{ enNumberToBn(old('signboard_fee',$tradeUser->signboard_fee)) }}">
                                @error('signboard_fee')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label">লাইসেন্স ফি (বকেয়া)</label>
                            <div class="col-sm-4 form-group {{ $errors->has('licenc_arrears') ? 'has-error' :'' }}">
                                <input type="text" name="licenc_arrears" class="form-control" placeholder="" value="{{ enNumberToBn(old('licenc_arrears',$tradeUser->arrears)) }}">
                                @error('licenc_arrears')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <label class="col-sm-2 col-form-label">বিবিধ</label>
                            <div class="col-sm-4 form-group {{ $errors->has('extra') ? 'has-error' :'' }}">
                                <input type="text" name="extra" class="form-control extra" placeholder="" value="{{ enNumberToBn(old('extra',$tradeUser->extra_rate)) }}" readonly="readonly">
                                @error('extra')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label">অর্থ বছর</label>
                            <div class="col-sm-4 form-group {{ $errors->has('financial_year') ? 'has-error' :'' }}">
{{--                                <input type="text" name="financial_year" class="form-control" placeholder="" value="{{ enNumberToBn(old('financial_year',$tradeUser->financial_year)) }}">--}}
                                @php
                                    $m = date('m');
                                    $y = date('Y');
                                @endphp
                                <select class="form-control select2" name="financial_year">
                                    <option value="">নির্বাচন করুন</option>
                                    @if($m > 6)
                                        <option value="{{ $y }}-{{ $y+1 }}" {{ old('financial_year',$tradeUser->financial_year)== $y.'-'.($y+1)?'selected':''}}>{{ enNumberToBn($y) }}-{{ enNumberToBn($y+1) }}</option>
                                    @else
                                        <option value="{{ $y-1 }}-{{ $y }}" {{ old('financial_year',$tradeUser->financial_year)== ($y-1).'-'.$y?'selected':''}}>{{ enNumberToBn($y-1) }}-{{ enNumberToBn($y) }}</option>
                                    @endif
                                </select>
                                @error('financial_year')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <label class="col-sm-2 col-form-label">বকেয়ার বছর</label>
                            <div class="col-sm-4 form-group {{ $errors->has('arrears_year') ? 'has-error' :'' }}">
                                <input type="text" name="arrears_year" class="form-control" placeholder="" value="{{ enNumberToBn(old('arrears_year', $tradeUser->arrears_year)) }}">
                                @error('arrears_year')
                                 <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-success bg-gradient-success">সংরক্ষণ করুন</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('.business_type').change(function () {
                calculate();
            });
            $('.signboard_type').change(function () {
                calculate();
            });
            $('.signboard_size').keyup(function () {
                calculate();
            });
            $('.signboard_size').keydown(function () {
                calculate();
            });

            const toEn = n => n.replace(/[০-৯]/g, d => "০১২৩৪৫৬৭৮৯".indexOf(d));
            let toBn={'0':'০','1':'১','2':'২','3':'৩','4':'৪','5':'৫','6':'৬','7':'৭','8':'৮','9':'৯'};
            String.prototype.getEntoBn = function() {
                var retStr = this;
                for (var x in toBn) {
                    retStr = retStr.replace(new RegExp(x, 'g'), toBn[x]);
                }
                return retStr;
            };

            function calculate() {
                let license_rate = $('.business_type option:selected').attr('data-rate')??'0';
                let signboard_rate = $('.signboard_type option:selected').attr('data-rate')??'0';
                let signBoardValue = $('.signboard_size').val()?$('.signboard_size').val():'0';

                let license_fee = parseFloat(toEn(license_rate));
                let signboard_fee = parseFloat(toEn(signboard_rate));
                let signboard_size = parseFloat(toEn(signBoardValue));

                let totalSignBoardFee = signboard_fee * signboard_size;
                let totalFee = license_fee + totalSignBoardFee;
                let totalExtraFee = (totalFee * 0.15)+500;
                // console.log(toBn(license_fee));
                console.log(license_fee);
                console.log(totalSignBoardFee);
                console.log(totalFee);
                console.log(totalExtraFee);

                var toBnc = license_fee.toString().getEntoBn();
                console.log(toBnc);
                $('.licence_fee').val(license_fee.toString().getEntoBn());
                $('.signboard_fee').val(totalSignBoardFee.toString().getEntoBn());
                $('.extra').val(totalExtraFee.toString().getEntoBn());


            }

            $('.holding_no').select2({
                ajax: {
                    url: "{{ route('holding_no_json') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            searchTerm: params.term // search term
                        };
                    },
                    processResults: function (response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });
            $('.holding_no').on('select2:select', function (e) {
                let data = e.params.data;
                let index = $(".holding_no").index(this);
                $('.holding_no_name').val(data.text)
            });
        });
    </script>
@endsection
