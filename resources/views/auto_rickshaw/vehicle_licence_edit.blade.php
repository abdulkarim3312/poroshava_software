@extends('layouts.app')
@section('title','যানবাহন চালকের লাইসেন্স যুক্তকরন')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <section class="card">
                <header class="card-heading">
                    <h3>যানবাহন চালকের লাইসেন্স যুক্তকরন</h3>
                </header>
                <form role="form" class="cmxform form-horizontal tasi-form" id="MenuForm" method="post" id="commentForm"
                      action="{{ route('auto_rickshaw.vehicle_edit',['driverLicense'=>$driverLicense->id]) }}">
                    @csrf
                    <div class="card-body">

                        <div class="form-group row">
                            <label for="inputSuccess" class="col-sm-2 control-label col-lg-2"><strong> ধরন
                                    *</strong></label>
                            <div class="col-lg-10">
                                <select class="form-control m-bot15 select2" name="type" id="type">
                                    <option value="">লাইসেন্স নির্ধারন</option>
                                    @foreach($types as $type)
                                        @if ($type->name_change_fees > 0)
                                            <option value="{{ $type->id }}" {{ empty(old('$type')) ? ($errors->has('type') ? '' : ($driverLicense->type_id == $type->id ? 'selected' : '')) :
                                            (old('$type') == $type->id ? 'selected' : '') }}>{{ $type->name }} (নাম
                                                পরিবর্তন সহ)
                                            </option>
                                        @else
                                            <option value="{{ $type->id }}" {{ empty(old('$type')) ? ($errors->has('type') ? '' : ($driverLicense->type_id == $type->id ? 'selected' : '')) :
                                            (old('$type') == $type->id ? 'selected' : '') }}>{{ $type->name }} (নাম
                                                পরিবর্তন ছাড়া)
                                            </option>
                                        @endif

                                    @endforeach
                                </select>
                                @error('type')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <div class="type-info" id="type-info">
                                    <div class="col-md-4" style="padding: 0">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>ধার্যকৃত লাইসেন্স ফি</th>
                                                <td id="fees"></td>
                                            </tr>
                                            <tr>
                                                <th>১৫% ভ্যাট</th>
                                                <td id="vat"></td>
                                            </tr>
                                            <tr>
                                                <th>মোট টাকা</th>
                                                <td id="total"></td>
                                            </tr>
                                            <tr>
                                                <th>নাম পরিবর্তন ফি</th>
                                                <td id="name_change_fees"></td>
                                            </tr>

                                            <tr>
                                                <th>অন্যান্য</th>
                                                <td id="others"></td>
                                            </tr>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputSuccess" class="col-sm-2 control-label col-lg-2"><strong>অর্থ বছর
                                    *</strong></label>
                            <div class="col-lg-10">
                                <select class="form-control m-bot15 select2" name="fiscal_year">
                                    <option value="">অর্থ বছর নির্ধারন</option>
                                    @for($i=2021; $i <= date('Y'); $i++)
                                        <option value="{{ $i }}-{{ $i+1 }}" {{ old('fiscal_year',$driverLicense->year) == ($i.'-'.$i+1) ? 'selected' : '' }}>{{ $i }}-{{ $i+1 }}</option>
                                    @endfor
                                </select>
                                @error('fiscal_year')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('driver_name') ? 'has-error' :'' }}">
                            <label for="inputSuccess" class="col-sm-2 control-label col-lg-2"><strong>চালকের নাম
                                    *</strong></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" placeholder="চালকের নাম" id="driver_name"
                                       name="driver_name"
                                       value="{{ empty(old('driver_name')) ? ($errors->has('driver_name') ? '' : $driverLicense->name) : old('driver_name') }}">
                                @error('driver_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('father_name') ? 'has-error' :'' }}">
                            <label for="inputSuccess" class="col-sm-2 control-label col-lg-2"><strong>পিতার নাম
                                    *</strong></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" placeholder="পিতার নাম" id="father_name"
                                       name="father_name"
                                       value="{{ empty(old('father_name')) ? ($errors->has('father_name') ? '' : $driverLicense->fname) : old('father_name') }}">
                                @error('father_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('mother_name') ? 'has-error' :'' }}">
                            <label for="inputSuccess" class="col-sm-2 control-label col-lg-2"><strong>মাতার নাম
                                    *</strong></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" placeholder="মাতার নাম" id="mother_name"
                                       name="mother_name"
                                       value="{{ empty(old('mother_name')) ? ($errors->has('mother_name') ? '' : $driverLicense->mname) : old('mother_name') }}">
                                @error('mother_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('age') ? 'has-error' :'' }}">
                            <label for="inputSuccess" class="col-sm-2 control-label col-lg-2"><strong>চালকের বয়স
                                    *</strong></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" placeholder="চালকের বয়স" id="age" name="age"
                                       value="{{ empty(old('age')) ? ($errors->has('age') ? '' : $driverLicense->age) : old('age') }}">
                                @error('age')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('nid') ? 'has-error' :'' }}">
                            <label for="inputSuccess" class="col-sm-2 control-label col-lg-2"><strong>জাতীয় পরিচয়পত্র
                                    নম্বর *</strong></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" placeholder="জাতীয় পরিচয়পত্র নম্বর" id="nid"
                                       name="nid"
                                       value="{{ empty(old('nid')) ? ($errors->has('nid') ? '' : $driverLicense->nid) : old('nid') }}">
                                @error('nid')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('address') ? 'has-error' :'' }}">
                            <label for="inputSuccess" class="col-sm-2 control-label col-lg-2"><strong>স্থায়ী
                                    ঠিকানা*</strong></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" placeholder="চালকের ঠিকানা স্থায়ী  ঠিকানা"
                                       id="address" name="address"
                                       value="{{ empty(old('address')) ? ($errors->has('address') ? '' : $driverLicense->address) : old('address') }}">
                                @error('address')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('current_address') ? 'has-error' :'' }}">
                            <label for="inputSuccess" class="col-sm-2 control-label col-lg-2"><strong>বর্তমান ঠিকানা
                                    *</strong></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" placeholder="চালকের বর্তমান ঠিকানা"
                                       id="current_address" name="current_address"
                                       value="{{ empty(old('current_address')) ? ($errors->has('current_address') ? '' : $driverLicense->current_address) : old('current_address') }}">
                                @error('current_address')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('upazila') ? 'has-error' :'' }}">
                            <label for="inputSuccess" class="col-sm-2 control-label col-lg-2"><strong>উপজেলা *</strong></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" placeholder="উপজেলা" id="upazila" name="upazila"
                                       value="{{ empty(old('upazila')) ? ($errors->has('upazila') ? '' : $driverLicense->upjela) : old('upazila') }}">
                                @error('upazila')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('post') ? 'has-error' :'' }}">
                            <label for="inputSuccess" class="col-sm-2 control-label col-lg-2"><strong>পোস্ট
                                    *</strong></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" placeholder="পোস্ট" id="post" name="post"
                                       value="{{ empty(old('post')) ? ($errors->has('post') ? '' : $driverLicense->post) : old('post') }}">
                                @error('post')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('license_no') ? 'has-error' :'' }}">
                            <label for="inputSuccess" class="col-sm-2 control-label col-lg-2"><strong>লাইসেন্স নম্বর
                                    *</strong></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" placeholder="লাইসেন্স নম্বর" id="license_no"
                                       name="license_no"
                                       value="{{ empty(old('license_no')) ? ($errors->has('license_no') ? '' : $driverLicense->licenseno) : old('license_no') }}">
                                @error('license_no')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('taka_receive_no') ? 'has-error' :'' }}">
                            <label for="inputSuccess" class="col-sm-2 control-label col-lg-2"><strong>টাকার রিসিভ নং
                                    *</strong></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" placeholder="টাকার রিসিভ নং"
                                       id="taka_receive_no" name="taka_receive_no"
                                       value="{{ empty(old('taka_receive_no')) ? ($errors->has('taka_receive_no') ? '' : $driverLicense->taka_receive_no) : old('taka_receive_no') }}">
                                @error('taka_receive_no')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputSuccess" class="col-sm-2 control-label col-lg-2"><strong>ডেলিভারি তারিখ
                                    *</strong></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control date-picker" name="delivery_date"
                                       value="{{ empty(old('delivery_date')) ? ($errors->has('delivery_date') ? '' : \Carbon\Carbon::parse($driverLicense->delivery_date)->format('d-m-Y')) : old('delivery_date') }}">
                                @error('delivery_date')
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
        $(function () {

            $("#type-info").hide();

            $("#type").change(function () {
                var typeId = $(this).val();
                $("#type-info").hide();
                if (typeId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('auto_rickshaw.get_type_details') }}",
                        data: {typeId: typeId}
                    }).done(function (data) {

                        var vatTotal = (parseFloat(data.fees) / 100) * parseFloat(data.vat);

                        $("#fees").html(data.fees);
                        $("#vat").html(vatTotal);
                        $("#total").html(data.total);
                        $("#name_change_fees").html(data.name_change_fees);
                        $("#others").html(data.others);
                        $("#type-info").show();
                    });
                }

            });
            $('#type').trigger('change');
        });

    </script>
@endsection
