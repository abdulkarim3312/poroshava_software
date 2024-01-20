@extends('layouts.app')
@section('title','ব্যবহারকারী হালনাগাদ')
@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-outline card-default">
                <div class="card-header">
                    <h3 class="card-title"> ব্যবহারকারীর তথ্য</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form enctype="multipart/form-data" action="{{ route('user.edit',['user'=>$user->id]) }}" class="form-horizontal" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row {{ $errors->has('role') ? 'has-error' :'' }}">
                            <label for="role" class="col-sm-2 col-form-label">মডিউল পারমিশন <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select name="role" id="role" class="form-control select2">
                                    <option value="">মডিউল পারমিশন নিরধারন</option>
                                    <option {{ old('role',$user->role) == 1 ? 'selected' : '' }} value="1">আডমিন</option>
                                    @foreach($sisterConcerns as $sisterConcern)
                                        <option {{ old('role',$user->role) == $sisterConcern->role ? 'selected' : '' }} value="{{ $sisterConcern->role }}">{{ $sisterConcern->name }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('sub_role') ? 'has-error' :'' }}">
                            <label for="sub_role" class="col-sm-2 col-form-label">এক্সেস পারমিশন <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select name="sub_role" id="sub_role" class="form-control select2">
                                    <option value="">এক্সেস পারমিশন নিরধারন</option>
                                    <option {{ old('sub_role',$user->sub_role) == 1 ? 'selected' : '' }} value="1">আডমিন</option>
                                    @if(auth()->user()->role == \App\Enumeration\Role::$COLLECTION)
                                        <option {{ old('sub_role',$user->sub_role) == 2 ? 'selected' : '' }} value="2">আদায়কারী</option>
                                        <option {{ old('sub_role',$user->sub_role) == 3 ? 'selected' : '' }} value="3">ক্যাশিয়ার</option>
                                    @endif
                                </select>
                                @error('sub_role')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('name') ? 'has-error' :'' }}">
                            <label for="name" class="col-sm-2 col-form-label">নাম <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ old('name',$user->name) }}" name="name" class="form-control" id="name" placeholder="নাম লিখন">
                                @error('name')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('username') ? 'has-error' :'' }}">
                            <label for="username" class="col-sm-2 col-form-label">লগিন ইউজার নাম <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ old('username',$user->username) }}" name="username" class="form-control" id="username" placeholder="লগিন ইউজার নাম লিখন">
                                @error('username')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('email') ? 'has-error' :'' }}">
                            <label for="email" class="col-sm-2 col-form-label">ইমেইল</label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ old('email',$user->email) }}" name="email" class="form-control" id="email" placeholder="Enter Email">
                                @error('email')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('password') ? 'has-error' :'' }}">
                            <label for="password" class="col-sm-2 col-form-label">পাসওয়াড</label>
                            <div class="col-sm-10">
                                <input type="password"  autocomplete="off" name="password" class="form-control" id="password" placeholder="পাসওয়াড লিখন">
                                @error('password')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('password_confirmation') ? 'has-error' :'' }}">
                            <label for="password_confirmation" class="col-sm-2 col-form-label">পাসওয়াড নিশ্চিতকরণ</label>
                            <div class="col-sm-10">
                                <input type="password"  name="password_confirmation" class="form-control" id="password_confirmation" placeholder="পাসওয়াড নিশ্চিতকরণ">
                                @error('password_confirmation')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('status') ? 'has-error' :'' }}">
                            <label class="col-sm-2 col-form-label">স্ট্যাটাস <span class="text-danger">*</span></label>

                            <div class="col-sm-10">

                                <div class="icheck-success d-inline">
                                    <input checked type="radio" id="active" name="status" value="1" {{ empty(old('status')) ? ($errors->has('status') ? '' : ($user->status == '1' ? 'checked' : '')) :
                                            (old('status') == '1' ? 'checked' : '') }}>
                                    <label for="active">
                                        সক্রিয়
                                    </label>
                                </div>

                                <div class="icheck-danger d-inline">
                                    <input type="radio" id="inactive" name="status" value="0" {{ empty(old('status')) ? ($errors->has('status') ? '' : ($user->status == '0' ? 'checked' : '')) :
                                            (old('status') == '0' ? 'checked' : '') }}>
                                    <label for="inactive">
                                        নিষ্ক্রিয়
                                    </label>
                                </div>

                                @error('status')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success bg-gradient-success">সংরক্ষণ করুন</button>
                        <a href="{{ route('user') }}" class="btn btn-default float-right">বাতিল করুন</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
            <!-- /.card -->
        </div>
        <!--/.col (left) -->
    </div>
@endsection
