@extends('layouts.app')

@section('style')
    <style>
        #printable{
            background-image: url({{ asset('public/bimage.png') }})!important;
            width: 100%;
            height: 678px;
            background-repeat: no-repeat !important;
            background-size: 100% 100%!important;
            padding-bottom: 51px;
        }
        @media print {
            * {
                -webkit-print-color-adjust: exact !important;
            }
        }
    </style>

@endsection
@section('content')
    <?php
    $bn = array('১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০');
    $en = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0');
    ?>
    <section class="wrapper site-min-height" style="background: #fff;">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">

                    <div class="panel-body" style="background: #fff; color:#000">
                        <button class="btn btn-default pull-right" onclick="getprint('printable')">Print</button><br><hr><br>

                        <div id="printable" class="print-area">

                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>

@endsection
@section('script')
    <script>
        var APP_URL = {!! json_encode(url('/')) !!};
        function getprint(id){

            $('body').html($('#'+id).html());
            window.print();
            window.location.replace(APP_URL+"/vehicle-license")
        }

    </script>
@endsection
