@extends('layouts.app')
@section('title','ঠিকাদার হালনাগাদ')
@section('style')
    <style>
        @media (min-width: 768px){
            .col-form-label {
                text-align: left;
            }
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-default">
                <div class="card-header">
                  <div class="card-title">ঠিকাদার হালনাগাদ তথ্য</div>
                </div>
                <!-- /.card-header -->
                <form enctype="multipart/form-data" action="{{ route('contractor.edit',['contractor'=>$contractor->eid]) }}" class="form-horizontal"
                      method="post">
                    @csrf
                <div class="card-body">
                    <div class="form-group row {{ $errors->has('id_no') ? 'has-error' :'' }}">
                        <label for="id_no" class="col-sm-3 col-form-label">আইডি নং <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" readonly value="{{ old('id_no',enNumberToBn($contractor->emp_id)) }}" name="id_no" class="form-control"
                                   id="id_no" placeholder="আইডি নং">
                            @error('id_no')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('name') ? 'has-error' :'' }}">
                        <label for="name" class="col-sm-3 col-form-label">ঠিকাদারের নাম <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" value="{{ old('name',$contractor->name) }}" name="name" class="form-control"
                                   id="name" placeholder="ঠিকাদারের নাম">
                            @error('name')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('proprietor_name') ? 'has-error' :'' }}">
                        <label for="proprietor_name" class="col-sm-3 col-form-label">প্রোপ্রাইটর নাম <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" value="{{ old('proprietor_name',$contractor->fname) }}" name="proprietor_name" class="form-control"
                                   id="proprietor_name" placeholder="প্রোপ্রাইটর নাম">
                            @error('proprietor_name')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('nid_no') ? 'has-error' :'' }}">
                        <label for="nid_no" class="col-sm-3 col-form-label">জাতীয় পরিচয় পত্র নং <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" value="{{ old('nid_no',$contractor->nid) }}" name="nid_no" class="form-control"
                                   id="nid_no" placeholder="জাতীয় পরিচয় পত্র নং">
                            @error('nid_no')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('tin_no') ? 'has-error' :'' }}">
                        <label for="tin_no" class="col-sm-3 col-form-label">টিআইএন নং</label>
                        <div class="col-sm-9">
                            <input type="text" value="{{ old('tin_no',$contractor->tin) }}" name="tin_no" class="form-control"
                                   id="tin_no" placeholder="টিআইএন নং">
                            @error('tin_no')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('mobile_no') ? 'has-error' :'' }}">
                        <label for="mobile_no" class="col-sm-3 col-form-label">মোবাইল নং</label>
                        <div class="col-sm-9">
                            <input type="text" value="{{ old('mobile_no',$contractor->mob) }}" name="mobile_no" class="form-control"
                                   id="mobile_no" placeholder="মোবাইল নং">
                            @error('mobile_no')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('email') ? 'has-error' :'' }}">
                        <label for="email" class="col-sm-3 col-form-label">ই-মেইল</label>
                        <div class="col-sm-9">
                            <input type="email" value="{{ old('email',$contractor->email) }}" name="email" class="form-control"
                                   id="mobile_no" placeholder="ই-মেইল">
                            @error('email')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('address') ? 'has-error' :'' }}">
                        <label for="address" class="col-sm-3 col-form-label">ঠিকানা <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <textarea type="text" name="address" class="form-control"
                                      id="address" placeholder="বেতন হিসাব নং">{{ old('address',$contractor->salaryaccno) }}</textarea>
                            @error('address')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('photo') ? 'has-error' :'' }}">
                        <label for="photo" class="col-sm-3 col-form-label">ছবি</label>
                        <div class="col-sm-9">
                            <input type="file" name="photo" class="form-control"
                                   id="photo">
                            @error('photo')
                            <span class="help-block">{{ $message }}</span>
                            @enderror
                            <div id="image-preview">
                                <img style="width:150px;margin-top: 10px" src="{{ asset($contractor->photo) }}" alt="">
                            </div>
                        </div>
                    </div>

                </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" id="submit-btn" class="btn btn-success bg-gradient-success">সংরক্ষণ করুন</button>
                        <a href="{{ route('contractor') }}" class="btn btn-default float-right">বাতিল করুন</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function () {

            $(document).ready(function() {
                $('#photo').on('change', function(e) {
                    var file = e.target.files[0];
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        var imageSrc = e.target.result;
                        $('#image-preview').html('<img style="width: 150px;margin-top: 8px" src="' + imageSrc + '" alt="Preview">');
                    };

                    reader.readAsDataURL(file);
                });
            });
        })

    </script>
@endsection
