@extends('layouts.app')
@section('title','কর্মচারীর বেতন জমা')
@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-outline card-default">
                <div class="card-header">
                    <h3 class="card-title">কর্মচারীর বেতন জমা দেওয়ার তথ্য</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('employee_salary_deposit') }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="year">বছর<span
                                            class="text-danger">*</span></label>
                                    <select required name="year" class="form-control select2" id="year">
                                        <option value="">বছর নির্ধারণ</option>
                                        @for($i=$lastProcessYear; $i <= date('Y'); $i++)
                                            <option
                                                value="{{ $i }}" {{ old('year') == $i ? 'selected' : '' }}>{{ enNumberToBn($i) }}</option>
                                        @endfor

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="month">মাসের নাম <span
                                            class="text-danger">*</span></label>
                                    <select required name="month" class="form-control select2" id="month">
                                        <option value="">মাসের নাম নির্ধারণ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group {{ $errors->has('financial_year') ? 'has-error' :'' }}">
                                    <label for="financial_year" >অর্থ বছর <span
                                            class="text-danger">*</span></label>
                                        <select required class="form-control select2" name="financial_year" id="financial_year">
                                            <option value="">অর্থ বছর নির্ধারণ</option>
                                            @for($i=$lastProcessYear; $i <= date('Y'); $i++)
                                                <option
                                                    value="{{ $i }}-{{ $i+1 }}" {{ old('financial_year') == $i.'-'.($i+1) ? 'selected' : '' }}>{{ enNumberToBn($i) }}-{{ enNumberToBn($i+1) }}</option>
                                            @endfor
                                        </select>
                                </div>

                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="process_date">জমা দেওয়ার তারিখ <span class="text-danger">*</span></label>
                                    <input required type="text" id="process_date" autocomplete="off"
                                           name="process_date" class="form-control date-picker"
                                           placeholder="জমা দেওয়ার তারিখ লিখুন" value="{{ request()->get('process_date')  }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <input type="submit" name="search"
                                           class="btn btn-success bg-gradient-success form-control" value="জমা দিন">
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

@section('script')
    <script>
        $(function (){
            var monthSelected = '{{ old('month') }}'
            $("#year").change(function (){
                let year = $(this).val();
                $('#month').html('<option value="">মাসের নাম নির্ধারণ</option>');
                if(year != ''){
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_salary_deposit_months') }}",
                        data: { year: year }
                    }).done(function( data ) {
                        $.each(data, function( index, item ) {
                            if (monthSelected == item)
                                $('#month').append('<option value="'+item+'" selected>'+item+'</option>');
                            else
                                $('#month').append('<option value="'+item+'">'+item+'</option>');
                        });
                    });
                }
            })
            $('#year').trigger('change');
        })
    </script>
@endsection
