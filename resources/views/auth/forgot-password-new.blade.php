{{-- <x-guest-layout> --}}
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @include('layouts.partial.__favicon')

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
        <style>
            .login-box {
                margin-top: 40px;
                border-radius: 0.5rem;
                height: auto;
                background: #1A2226;
                text-align: center;
                box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
            }

            .login-key {
                height: 100px;
                font-size: 80px;
                line-height: 100px;
                background: -webkit-linear-gradient(#27EF9F, #0DB8DE);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }

            .login-title {
                margin-top: 15px;
                text-align: center;
                font-size: 30px;
                letter-spacing: 2px;
                margin-top: 15px;
                font-weight: bold;
                color: #ECF0F5;
            }

            .login-form {
                margin-top: 25px;
                text-align: left;
            }

            input[type=email] {
                background-color: #1A2226;
                border: none;
                border: 1px solid #0DB8DE;
                border-radius: 5px;
                font-weight: bold;
                outline: 0;
                color: #ECF0F5;
            }

            .form-group {
                margin-bottom: 40px;
                outline: 0px;
            }

            .form-control:focus {
                border-color: inherit;
                -webkit-box-shadow: none;
                box-shadow: none;
                border: 1px solid #0DB8DE;
                outline: 0;
                background-color: #1A2226;
                color: #ECF0F5;
            }

            input:focus {
                outline: none;
                box-shadow: 0 0 0;
            }

            label {
                margin-bottom: 0px;
            }

            .form-control-label {
                font-size: 12px;
                color: #6C6C6C;
                font-weight: bold;
                letter-spacing: 1px;
            }

            .btn-outline-primary {
                border-color: #0DB8DE;
                color: #0DB8DE;
                border-radius: 0px;
                font-weight: bold;
                letter-spacing: 1px;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            }

            .btn-outline-primary:hover {
                background-color: #0DB8DE;
                right: 0px;
            }

            .login-btm {
                float: left;
            }

            .login-button {
                padding-right: 0px;
                /* text-align: right; */
                margin-bottom: 25px;
            }

            .login-text {
                text-align: left;
                padding-left: 0px;
                color: #A2A4A4;
            }

            .loginbttm {
                padding: 0px;
            }

            .help-block {
                color: red;
            }
            .rotate{
                animation: rotation 5s infinite linear;
            }
            @keyframes rotation {
                from {
                    transform: rotate(0deg);
                }
                to {
                    transform: rotate(359deg);
                }
            }
        </style>
    </head>
    <body style="height: 100vh; background: url({{ asset('img/bg.jpg') }});background-size: cover;background-repeat: no-repeat;">
        <div class="container">
            <div class="row">
                <div class="col-1 col-sm-2 col-md-3 col-lg-4"></div>
                <div class="col-10 col-sm-8 col-md-6 col-lg-4 login-box">
                    <div class="col-lg-12 login-key d-flex justify-content-center">
                        <a href="/">
                            <x-application-logo class="w-20 mx-auto d-block h-20 fill-current text-gray-500" />
                        </a>
                    </div>
                    <div class="col-lg-12 login-title">
                        অ্যাডমিন প্যানেল
                    </div>

                    <div class="col-lg-12 login-form">
                        <div class="col-lg-12 login-form">
                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <p style="color: #ECF0F5;">আপনি কি পাসওয়ার্ড ভুলে গেছেন? সমস্যা নেই. শুধু আমাদের আপনার ইমেল ঠিকানা জানান এবং আমরা আপনাকে একটি পাসওয়ার্ড রিসেট লিঙ্ক ইমেল করব যা আপনাকে একটি নতুন চয়ন করার অনুমতি দেবে৷</p>
                                <div class="form-group {{ $errors->has('email') ? 'has-error' :'' }}">
                                    <label class="form-control-label" style="color: #ECF0F5;">ইমেইল</label>
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                    @error('email')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-lg-12 loginbttm">
                                    <div class="col-lg-6 login-btm login-text">
                                        <!-- Error Message -->
                                    </div>
                                    <div class="col-lg-12 login-btm login-button">
                                        <button type="submit" class="btn btn-outline-primary">ইমেল পাসওয়ার্ড রিসেট লিঙ্ক</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3"></div>
                </div>
            </div>
        </div>
    </body>
</html>
{{-- </x-guest-layout> --}}
