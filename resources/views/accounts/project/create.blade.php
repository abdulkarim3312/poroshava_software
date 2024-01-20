@extends('layouts.app')
@section('title','প্রকল্প সংযুক্তি')
@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-outline card-default">
                <div class="card-header">
                    <h3 class="card-title">প্রকল্প সংযুক্তির তথ্য</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form enctype="multipart/form-data" action="{{ route('project.create') }}" class="form-horizontal"
                      method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row {{ $errors->has('upangsho') ? 'has-error' :'' }}">
                            <label for="upangsho" class="col-sm-2 col-form-label">উপাংশ <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select name="upangsho" class="form-control select2" id="upangsho">
                                    <option value="">উপাংশ নির্ধারণ</option>
                                    @foreach($sections as $section)
                                        <option
                                            {{ old('upangsho') == $section->upangsho_id ? 'selected' : '' }} value="{{ $section->upangsho_id }}">{{ $section->upangsho_name }}</option>
                                    @endforeach
                                </select>
                                @error('upangsho')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('contractor') ? 'has-error' :'' }}">
                            <label for="contractor" class="col-sm-2 col-form-label">ঠিকাদার</label>
                            <div class="col-sm-10">
                                <select name="contractor" class="form-control select2" id="contractor">
                                    <option value="">ঠিকাদার নির্ধারণ</option>
                                    @foreach($contractors as $contractor)
                                        <option {{ old('contractor') == $contractor->eid ? 'selected' : '' }} value="{{ $contractor->eid }}">{{ $contractor->name }}</option>
                                    @endforeach
                                </select>
                                @error('contractor')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('financial_year') ? 'has-error' :'' }}">
                            <label for="financial_year" class="col-sm-2 col-form-label">অর্থ বছর <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select class="form-control select2" name="financial_year" id="financial_year">
                                    <option value="">অর্থ বছর নির্ধারণ</option>
                                    @for($i=2019; $i <= date('Y'); $i++)
                                        <option
                                            value="{{ $i }}-{{ substr($i+1, -2) }}" {{ old('financial_year') == $i.'-'.substr($i+1, -2) ? 'selected' : '' }}>{{ enNumberToBn($i) }}-{{ enNumberToBn(substr($i+1, -2)) }}</option>
                                    @endfor
                                </select>
                                @error('financial_year')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('project_name') ? 'has-error' :'' }}">
                            <label for="project_name" class="col-sm-2 col-form-label">প্রকল্পের নাম <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ old('project_name') }}" name="project_name" class="form-control"
                                       id="project_name" placeholder="প্রকল্পের নাম">
                                @error('project_name')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('estimate_section') ? 'has-error' :'' }}">
                            <label for="estimate_section" class="col-sm-2 col-form-label">বরাদ্দ খাত <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select name="estimate_section" class="form-control select2" id="estimate_section">
                                    <option value="">বরাদ্দ খাত নির্ধারণ</option>
                                    @foreach($sections as $section)
                                        <option
                                            {{ old('estimate_section') == $section->upangsho_id ? 'selected' : '' }} value="{{ $section->upangsho_id }}">{{ $section->upangsho_name }}</option>
                                    @endforeach
                                </select>
                                @error('estimate_section')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('project_amount') ? 'has-error' :'' }}">
                            <label for="project_amount" class="col-sm-2 col-form-label">প্রকল্পের মূল্য <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ old('project_amount') }}" name="project_amount" class="form-control"
                                       id="project_amount" placeholder="প্রকল্পের মূল্য">
                                @error('project_amount')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('contract_amount') ? 'has-error' :'' }}">
                            <label for="contract_amount" class="col-sm-2 col-form-label">চুক্তি মূল্য <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ old('contract_amount') }}" name="contract_amount" class="form-control"
                                       id="project_amount" placeholder="চুক্তি মূল্য">
                                @error('contract_amount')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('contract_date') ? 'has-error' :'' }}">
                            <label for="contract_date" class="col-sm-2 col-form-label">চুক্তির তারিখ <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ old('contract_date') }}" autocomplete="off" name="contract_date" class="form-control date-picker"
                                       id="contract_date" placeholder="চুক্তির তারিখ">
                                @error('contract_date')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('total_bill') ? 'has-error' :'' }}">
                            <label for="total_bill" class="col-sm-2 col-form-label">মোট বিল <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ old('total_bill') }}" onkeyup="sum();"  name="total_bill" class="form-control"
                                       id="total_bill" placeholder="মোট বিল">
                                @error('total_bill')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('guarantee_amount') ? 'has-error' :'' }}">
                            <label for="guarantee_amount" class="col-sm-2 col-form-label">জামানতের পরিমান <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ old('guarantee_amount') }}" onkeyup="sum();"  name="guarantee_amount" class="form-control"
                                       id="guarantee_amount" placeholder="জামানতের পরিমান">
                                <strong>Calculative security money : <span id="guarantee_amount_calculate">0</span></strong>
                                @error('guarantee_amount')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('vat') ? 'has-error' :'' }}">
                            <label for="vat" class="col-sm-2 col-form-label">ভ্যাট <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ old('vat') }}" onkeyup="sum();"  name="vat" class="form-control"
                                       id="vat" placeholder="ভ্যাট">
                                <strong> Calculative vat : <span id="vat_calculate">0</span></strong>
                                @error('vat')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('tax') ? 'has-error' :'' }}">
                            <label for="tax" class="col-sm-2 col-form-label">আয় কর <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ old('tax') }}" onkeyup="sum();"  name="tax" class="form-control"
                                       id="tax" placeholder="আয় কর">
                                @error('tax')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('net_bill') ? 'has-error' :'' }}">
                            <label for="net_bill" class="col-sm-2 col-form-label">নীট বিল <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ old('net_bill') }}" onkeyup="sum();"  name="net_bill" class="form-control"
                                       id="net_bill" placeholder="নীট বিল">
                                @error('net_bill')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('note') ? 'has-error' :'' }}">
                            <label for="note" class="col-sm-2 col-form-label">মন্তব্য</label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ old('note') }}" name="note" class="form-control"
                                       id="note" placeholder="মন্তব্য লিখুন">
                                @error('note')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" id="submit-btn" class="btn btn-success bg-gradient-success">সংরক্ষণ করুন</button>
                        <a href="{{ route('dashboard') }}" class="btn btn-default float-right">বাতিল করুন</a>
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
        $(function () {


        })
        function sum() {
            var incometax = document.getElementById('tax').value;
            var vat = document.getElementById('vat').value;
            var security_money = document.getElementById('guarantee_amount').value;

            var security_money_cal = 0;
            var vat_money_cal = 0;
            var result2 = 0;
            var total_bill = document.getElementById('total_bill').value;
            $("#guarantee_amount_calculate").html(security_money_cal = security_money);
            $("#vat_calculate").html(vat_money_cal = vat );

            $('#total_amount').html(result2 = ((parseInt(incometax) + parseInt(security_money_cal)+parseInt(vat_money_cal))));

            var  result =  parseInt(total_bill) - result2;
            if (!isNaN(result) ) {
                document.getElementById('net_bill').value = result;
            }
        }
    </script>
@endsection
