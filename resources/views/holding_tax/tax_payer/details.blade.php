@extends('layouts.app')
@section('title','দোহার পৌরসভা')
@section('style')
    <style>

        .table-bordered td, .table-bordered th {
            border: 1px solid #dee2e6;
            vertical-align: middle;
            border-bottom-width: 2px;
            /*text-align: center;*/
        }

        .table-bordered thead td, .table-bordered thead th {
            vertical-align: middle;
        }

        .table thead th {
            border-bottom: 1px solid #000000 !important;
        }

        .table-bordered td, .table-bordered th {
            border: 1px solid #000000 !important;
        }

        .table-bordered td, .table-bordered th {
            padding: 3px !important;
            font-size: 13px !important;
        }

        .table-bordered-modal td, .table-bordered-modal th {
            border: 1px solid #dee2e6 !important;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-default">
                <div class="card-header">
                    <a href="#" onclick="getprint('printArea')" class="btn btn-success bg-gradient-success btn-sm"><i
                            class="fa fa-print"></i></a>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div id="printArea">
                        <div class="row" style="border-bottom: 1px solid #000; padding: 0px 60px;">
                            <div class="col-3">
                                <span><img src="{{ asset('img/logo.png') }}"/></span>
                            </div>
                            <div class="col-6">
                                <h3 class="text-center m-3" style="margin-bottom: 5px !important;font-size: 18px !important;font-weight: bold">
                                    গণপ্রজাতন্ত্রী বাংলাদেশ সরকার
                                </h3>
                                <h1 class="text-center m-0" style="margin-bottom: 5px !important;font-size: 25px !important;font-weight: bold">
                                    {{ config('app.name') }}
                                </h1>
                                <h3 class="text-center" style="font-size: 19px !important;">দোহার, ঢাকা</h3>
                            </div>
                            <div class="col-3 text-right">
                                <span><img src="{{ asset('img/dohar_logo.jpg') }}" width="70"/></span>
                            </div>
                        </div>
                        <div class="row mb-2 mt-2" style="padding: 0px 60px;">
                            <div class="col-3">
                                <strong>করদাতার বিবরণঃ</strong>
                            </div>
                            <div class="col-6 text-center">
                                <strong>কর নির্ধারণ কালঃ {{ enNumberToBn($holdingAssessment->assessmentSetting->financial_years??'') }}</strong>
                            </div>
                            <div class="col-3 text-right">
                                <strong>পৌরকর পুনঃনির্ধারণ</strong>
                            </div>
                        </div>
                        <div class="table-responsive" style="padding: 0px 60px;">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th width="20%">মালিকের নামঃ</th>
                                    <td width="30%">{{ $holdingAssessment->taxPayer->name??'' }}</td>
                                    <th width="25%">ওয়ার্ড নং</th>
                                    <td width="25%">{{ enNumberToBn($holdingAssessment->holdingInfo->wardInfo->ward_no??'') }}</td>
                                </tr>
                                <tr>
                                    <th width="20%">পিতা/স্বামীর নামঃ</th>
                                    <td width="30%">{{ $holdingAssessment->taxPayer->father_husband_name??'' }}</td>
                                    <th width="25%">মহল্লাঃ</th>
                                    <td width="25%">{{ $holdingAssessment->holdingInfo->holdingArea->road_name??'' }}</td>
                                </tr>
                                <tr>
                                    <th width="20%">মাতার নামঃ</th>
                                    <td width="30%">{{ $holdingAssessment->taxPayer->mother_name??'' }}</td>
                                    <th width="25%">রাস্তাঃ </th>
                                    <td width="25%">{{ $holdingAssessment->holdingInfo->moholla_name??'' }}</td>
                                </tr>
                                <tr>
                                    <th width="20%">বর্তমান ঠিকানাঃ </th>
                                    <td width="30%">{{ $holdingAssessment->taxPayer->address??'' }}</td>
                                    <th width="25%">হোল্ডিং নংঃ</th>
                                    <td width="25%">{{ enNumberToBn($holdingAssessment->holdingInfo->holding_no??'') }}</td>
                                </tr>
                                <tr>
                                    <th width="20%">ই-মেইল ঠিকানাঃ</th>
                                    <td width="30%">{{ $holdingAssessment->taxPayer->email??'' }}</td>
                                    <th width="25%">পুরাতন হোল্ডিং নংঃ</th>
                                    <td width="25%">{{ enNumberToBn($holdingAssessment->holdingInfo->old_holding_no??'') }}</td>
                                </tr>
                                <tr>
                                    <th width="20%">মোবাইল নাম্বারঃ</th>
                                    <td width="30%">{{ enNumberToBn($holdingAssessment->taxPayer->contact_no??'') }}</td>
                                    <th width="25%">ইমারত ব্যবহারের ধরনঃ </th>
                                    <td width="25%">
                                        @if($holdingAssessment->holdingInfo->usingHolding_id == 1)
                                            সম্পূর্ণ ভাড়া দেয়া গৃহ
                                        @elseif($holdingAssessment->holdingInfo->usingHolding_id == 2)
                                            ঋনসহ সম্পূর্ণ ভাড়া দেয়া গৃহ
                                        @elseif($holdingAssessment->holdingInfo->usingHolding_id == 3)
                                            মালিক নিজে বসবাস করেন
                                        @else
                                            নিজে বসবাস ও আংশিক ভাড়া
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%" rowspan="4" colspan="2"></td>
                                    <th width="25%">মালিকানার ধরনঃ </th>
                                    <td width="25%">{{ $holdingAssessment->holdingInfo->holdingCategory->name??'' }}</td>
                                </tr>
                                <tr>
                                    <th width="25%">হোল্ডিং ব্যবহারের ধরনঃ </th>
                                    <td width="25%">{{ $holdingAssessment->holdingInfo->holdingUseType->name??'' }}</td>
                                </tr>
                                <tr>
                                    <th colspan="2">হোল্ডিং এর গঠন অনুযায়ী ধরনঃ </th>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>স্থাপনার ধরন</th>
                                                <th>স্থাপনার সংখ্যা</th>
                                                <th>মোট তলা</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $structures = \App\Models\Holding\StructureHoldingInfo::where('holding_info_id', $holdingAssessment->holdingInfo->id)
                                                ->selectRaw('structure_type_id, SUM(total_floor) as sum_floor')
                                                ->selectRaw('structure_type_id, COUNT(*) as count')
                                                ->groupBy('structure_type_id')
                                                ->get();
                                            @endphp
                                            @if($structures)
                                                @foreach($structures as $structure)

                                                    @php
                                                        $structureType = \App\Models\Holding\StructureType::where('id', $structure->structure_type_id)->first();
                                                    @endphp
                                                    <tr>
                                                        <td>{{$structureType->name ?? ''}}</td>
                                                        <td>{{$structure->count ?? ''}}</td>
                                                        <td>{{$structure->sum_floor}}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        @if($holdingAssessment->holdingInfo->usingHolding_id ==1)
                            <div class="table-responsive" style="padding: 0px 60px;">
                                @if($holdingAssessment->holdingInfo->holdingTenantInfos)
                                    <table class="table table-bordered">
                                        <tbody>
                                        <tr>
                                            <th colspan="8" class="text-center">ভাড়া পদ্ধতি</th>
                                        </tr>
                                        <tr>
                                            <th>স্থাপনা নং</th>
                                            <th>স্থাপনার ধরন</th>
                                            <th>ফ্লাট/ফ্লোর নাম্বার</th>
                                            <th>মাসিক ভাড়া</th>
                                            <th>মাসের সংখ্যা</th>
                                            <th>মোট(টাকা)</th>
                                            <th>মন্তব্য</th>
                                        </tr>
                                        @php
                                            $totalRent = 0;
                                            $totalMonthlyRent = 0;
                                        @endphp
                                        @foreach($holdingAssessment->holdingInfo->holdingTenantInfos as $holdingTenantInfo)
                                            <tr>
                                                <td>{{enNumberToBn($loop->iteration)}}</td>
                                                <td>{{ $holdingTenantInfo->holdingStructureType->name??"" }}</td>
                                                <td>{{ enNumberToBn($holdingTenantInfo->tenant_floor ?? '') }}</td>
                                                <td>{{ enNumberToBn($holdingTenantInfo->monthly_rent ?? '0') }}</td>
                                                <td>{{ enNumberToBn(12) }}</td>
                                                @php
                                                    $monthlyRent=(float)(($holdingTenantInfo->monthly_rent ?? '0')*12);
                                                @endphp
                                                <td>{{ enNumberToBn(number_format($monthlyRent,2)) }}</td>
                                                <td>ভাড়া অংশ</td>
                                            </tr>
                                            @php
                                                $totalRent += $monthlyRent;
                                                $totalMonthlyRent += $holdingTenantInfo->monthly_rent;
                                            @endphp
                                        @endforeach

                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th colspan="5">মোট বাৎসরিক ভাড়া</th>
                                            <th>{{ enNumberToBn(number_format($totalRent,2)) }}</th>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th colspan="3">গৃহের রক্ষণাবেক্ষন খরচ ২ মাসের ভাড়া</th>
                                            <th>{{ enNumberToBn(number_format($totalMonthlyRent,2)) }}</th>
                                            <th>{{ enNumberToBn(2) }}</th>
                                            <th>{{ enNumberToBn(number_format($totalMonthlyRent*2,2)) }}</th>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th colspan="5">১ম বার্ষিক মূল্যায়ণ	</th>
                                            <th>{{ enNumberToBn(number_format($totalRent-($totalMonthlyRent*2),2)) }}</th>
                                            <td></td>
                                        </tr>
                                        </tfoot>

                                    </table>
                                @endif
                            </div>
                            <div class="table-responsive" style="padding: 0px 60px;">
                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        @php
                                            $deduct_maintenance_yearly_assessment = $holdingAssessment->Yearly_assesment - $holdingAssessment->Maintenance_deduct;
                                        @endphp
                                        <th width="80%">১ম বার্ষিক মূল্যায়ণ</th>
                                        <th class="text-right">{{ enNumberToBn(number_format($totalRent-($totalMonthlyRent*2),2)) }}</th>
                                    </tr>
                                    <tr>
                                        <td width="80%">-বানিজ্যিক ব্যতীত (গৃহ নির্মাণের বার্ষিক সুদ )</td>
                                        <td class="text-right">০</td>
                                    </tr>
                                    <tr>
                                        <td width="80%">-বানিজ্যিক (বার্ষিক সুদের ১/৪ অংশ )</td>
                                        <td class="text-right">০</td>
                                    </tr>
                                    <tr>
                                        <th width="80%">প্রকৃত বার্ষিক মূল্যায়ণ</th>
                                        <th class="text-right">{{ enNumberToBn(number_format($holdingAssessment->actual_assesment,2)) }}</th>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endif

                        @if($holdingAssessment->holdingInfo->usingHolding_id ==3)
                        <div class="table-responsive" style="padding: 0px 60px;">
                            @if($holdingAssessment->holdingInfo->structureInfos)
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th colspan="8" class="text-center">ভাড়া পদ্ধতি</th>
                                </tr>
                                <tr>
                                    <th>স্থাপনা নং</th>
                                    <th>স্থাপনার ধরন</th>
                                    <th>মোট তলা</th>
                                    <th>মালিকের ব্যবহৃত তলার সংখা</th>
                                    <th>মাসিক ভাড়া</th>
                                    <th>মাসের সংখ্যা</th>
                                    <th>মোট(টাকা)</th>
                                    <th>মন্তব্য</th>
                                </tr>
                                    @php
                                        $totalRent = 0;
                                    @endphp
                                @foreach($holdingAssessment->holdingInfo->structureInfos as $holdingStructure)
                                    <tr>
                                        <td>{{enNumberToBn($loop->iteration)}}</td>
                                        <td>{{ $holdingStructure->holdingStructureType->name??"" }}</td>
                                        <td>{{ enNumberToBn($holdingStructure->total_floor) }}</td>
                                        <td>{{ enNumberToBn($holdingStructure->owner_use_floor_no) }}</td>
                                        @php
                                            $aproxMonthlyRent=(float)($holdingStructure->aprox_monthly_rent??0);
                                        @endphp
                                        <td>{{ enNumberToBn(number_format($aproxMonthlyRent,2)) }}</td>
                                        <td>{{ enNumberToBn(12) }}</td>
                                        <td>{{ enNumberToBn(number_format($aproxMonthlyRent*12)) }}</td>
                                        <td>ভাড়া অংশ</td>
                                    </tr>
                                    @php
                                        $totalRent += $aproxMonthlyRent*12;
                                    @endphp
                                @endforeach

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th colspan="6">মোট বাৎসরিক ভাড়া</th>
                                    <th>{{ enNumberToBn(number_format($totalRent,2)) }}</th>
                                    <td></td>
                                </tr>
                                </tfoot>

                            </table>
                            @endif
                        </div>

                        <div class="table-responsive" style="padding: 0px 60px;">
                            @if($holdingAssessment->holdingInfo->structureInfos)
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th colspan="10" class="text-center">নির্মাণ ব্যয় পদ্ধতি</th>
                                </tr>
                                <tr>
                                    <th>স্থাপনা নং</th>
                                    <th>স্থাপনার ধরন</th>
                                    <th>মোট তলা</th>
                                    <th>মালিকের ব্যবহৃত তলার সংখা</th>
                                    <th colspan="3">আয়তন (বর্গফুট)</th>
                                    <th>ব্যয়/প্রতি বর্গফুট</th>
                                    <th>মোট(টাকা)</th>
                                    <th>মন্তব্য</th>
                                </tr>
                                @php
                                    $totalAmount = 0;
                                @endphp
                                @foreach($holdingAssessment->holdingInfo->structureInfos as $holdingStructure)
                                    <tr>
                                        <td>{{enNumberToBn($loop->iteration)}}</td>
                                        <td>{{ $holdingStructure->holdingStructureType->name??"" }}</td>
                                        <td>{{ enNumberToBn($holdingStructure->total_floor) }}</td>
                                        <td>{{ enNumberToBn($holdingStructure->owner_use_floor_no) }}</td>
                                        <td>{{ enNumberToBn(number_format($holdingStructure->structure_length,2)) }}</td>
                                        <td>{{ enNumberToBn(number_format($holdingStructure->structure_width,2)) }}</td>
                                        <td>{{ enNumberToBn(number_format($holdingStructure->structure_volume,2)) }}</td>
                                        <td>{{ enNumberToBn($holdingStructure->construction_rate) }}</td>
                                        <td>{{ enNumberToBn($holdingStructure->construction_amount) }}</td>
                                        <td>মালিকের অংশ</td>
                                    </tr>
                                    @php
                                        $totalAmount += $holdingStructure->construction_amount;
                                    @endphp
                                @endforeach

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th colspan="8">মোট নির্মাণ ব্যয়</th>
                                    <th>{{ enNumberToBn(number_format($totalAmount,2)) }}</th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th colspan="8">বার্ষিক মূল্যায়ণ (নির্মাণ ব্যয়ের ৭.৫%)</th>
                                    <th>{{ enNumberToBn(number_format(($totalAmount*7.5)/100,2)) }}</th>
                                    <td></td>
                                </tr>
                                </tfoot>
                            </table>
                            @endif
                        </div>
                        <div class="table-responsive" style="padding: 0px 60px;">
                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        <th width="80%">বার্ষিক মূল্যায়ণ ( ভাড়া ও নির্মাণ ব্যয় পদ্ধতির মধ্যে যেটি কম )</th>
                                        <th class="text-right">{{ enNumberToBn(number_format($holdingAssessment->Yearly_assesment,2)) }}</th>
                                    </tr>
                                    <tr>
                                        <td width="80%">রক্ষণাবেক্ষন খরচ (১ম বার্ষিক মূল্যায়ণ * ১/৬ )</td>
                                        <td class="text-right">{{ enNumberToBn(number_format($holdingAssessment->Maintenance_deduct,2)) }}</td>
                                    </tr>
                                    <tr>
                                        @php
                                            $deduct_maintenance_yearly_assessment = $holdingAssessment->Yearly_assesment - $holdingAssessment->Maintenance_deduct;
                                        @endphp
                                        <th width="80%">১ম বার্ষিক মূল্যায়ণ</th>
                                        <th class="text-right">{{ enNumberToBn(number_format($deduct_maintenance_yearly_assessment)) }}</th>
                                    </tr>
                                    <tr>
                                        <td width="80%">মালিক নিজে বসবাস করলে ১ম বার্ষিক মূল্যায়ণের ১/৪ অংশ রেয়াদ পাবেন</td>
                                        <td class="text-right">{{ enNumberToBn(number_format(($deduct_maintenance_yearly_assessment/4),2)) }}</td>
                                    </tr>
                                    <tr>
                                        <td width="80%">-বানিজ্যিক ব্যতীত (গৃহ নির্মাণের বার্ষিক সুদ )</td>
                                        <td class="text-right">০</td>
                                    </tr>
                                    <tr>
                                        <td width="80%">-বানিজ্যিক (বার্ষিক সুদের ১/৪ অংশ )</td>
                                        <td class="text-right">০</td>
                                    </tr>
                                    <tr>
                                        <th width="80%">১ম বার্ষিক মূল্যায়ণ</th>
                                        <th class="text-right">{{ enNumberToBn(number_format($holdingAssessment->Yearly_assesment-$holdingAssessment->Maintenance_deduct-($deduct_maintenance_yearly_assessment/4),2)) }}</th>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endif

                        @if($holdingAssessment->holdingInfo->usingHolding_id ==4)
                            <div class="table-responsive" style="padding: 0px 60px;">
                                @if($holdingAssessment->holdingInfo->holdingTenantInfos)
                                    <p><b>"ক" অংশ -</b></p>
                                    <table class="table table-bordered">
                                        <tbody>
                                        <tr>
                                            <th colspan="8" class="text-center">ভাড়া পদ্ধতি</th>
                                        </tr>
                                        <tr>
                                            <th>স্থাপনা নং</th>
                                            <th>স্থাপনার ধরন</th>
                                            <th>ফ্লাট/ফ্লোর নাম্বার</th>
                                            <th>মাসিক ভাড়া</th>
                                            <th>মাসের সংখ্যা</th>
                                            <th>মোট(টাকা)</th>
                                            <th>মন্তব্য</th>
                                        </tr>
                                        @php
                                            $totalRent = 0;
                                            $totalMonthlyRent = 0;
                                        @endphp
                                        @foreach($holdingAssessment->holdingInfo->holdingTenantInfos as $holdingTenantInfo)
                                            <tr>
                                                <td>{{enNumberToBn($loop->iteration)}}</td>
                                                <td>{{ $holdingTenantInfo->holdingStructureType->name??"" }}</td>
                                                <td>{{ enNumberToBn($holdingTenantInfo->tenant_floor ?? '') }}</td>
                                                <td>{{ enNumberToBn($holdingTenantInfo->monthly_rent ?? '0') }}</td>
                                                <td>{{ enNumberToBn(12) }}</td>
                                                @php
                                                    $monthlyRent=(float)(($holdingTenantInfo->monthly_rent ?? '0')*12);
                                                @endphp
                                                <td>{{ enNumberToBn(number_format($monthlyRent,2)) }}</td>
                                                <td>ভাড়া অংশ</td>
                                            </tr>
                                            @php
                                                $totalRent += $monthlyRent;
                                                $totalMonthlyRent += $holdingTenantInfo->monthly_rent;
                                            @endphp
                                        @endforeach

                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th colspan="5">মোট বাৎসরিক ভাড়া</th>
                                            <th>{{ enNumberToBn(number_format($totalRent,2)) }}</th>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th colspan="3">গৃহের রক্ষণাবেক্ষন খরচ ২ মাসের ভাড়া</th>
                                            <th>{{ enNumberToBn(number_format($totalMonthlyRent,2)) }}</th>
                                            <th>{{ enNumberToBn(2) }}</th>
                                            <th>{{ enNumberToBn(number_format($totalMonthlyRent*2,2)) }}</th>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th colspan="5">"ক" অংশের প্রকৃত বার্ষিক মূল্যায়ণ</th>
                                            <th>{{ enNumberToBn(number_format($totalRent-($totalMonthlyRent*2),2)) }}</th>
                                            <td></td>
                                        </tr>
                                        </tfoot>

                                    </table>
                                @endif
                            </div>
                            <div class="table-responsive" style="padding: 0px 60px;">
                                @if($holdingAssessment->holdingInfo->structureInfos)
                                    <p><b>"খ" অংশ -</b></p>
                                    <table class="table table-bordered">
                                        <tbody>
                                        <tr>
                                            <th colspan="8" class="text-center">ভাড়া পদ্ধতি</th>
                                        </tr>
                                        <tr>
                                            <th>স্থাপনা নং</th>
                                            <th>স্থাপনার ধরন</th>
                                            <th>মোট তলা</th>
                                            <th>মালিকের ব্যবহৃত তলার সংখা</th>
                                            <th>মাসিক ভাড়া</th>
                                            <th>মাসের সংখ্যা</th>
                                            <th>মোট(টাকা)</th>
                                            <th>মন্তব্য</th>
                                        </tr>
                                        @php
                                            $totalRent = 0;
                                        @endphp
                                        @foreach($holdingAssessment->holdingInfo->structureInfos as $holdingStructure)
                                            <tr>
                                                <td>{{enNumberToBn($loop->iteration)}}</td>
                                                <td>{{ $holdingStructure->holdingStructureType->name??"" }}</td>
                                                <td>{{ enNumberToBn($holdingStructure->total_floor) }}</td>
                                                <td>{{ enNumberToBn($holdingStructure->owner_use_floor_no) }}</td>
                                                @php
                                                    $aproxMonthlyRent=(float)($holdingStructure->aprox_monthly_rent??0);
                                                @endphp
                                                <td>{{ enNumberToBn(number_format($aproxMonthlyRent,2)) }}</td>
                                                <td>{{ enNumberToBn(12) }}</td>
                                                <td>{{ enNumberToBn(number_format($aproxMonthlyRent*12)) }}</td>
                                                <td>ভাড়া অংশ</td>
                                            </tr>
                                            @php
                                                $totalRent += $aproxMonthlyRent*12;
                                            @endphp
                                        @endforeach

                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th colspan="6">মোট বাৎসরিক ভাড়া</th>
                                            <th>{{ enNumberToBn(number_format($totalRent,2)) }}</th>
                                            <td></td>
                                        </tr>
                                        </tfoot>

                                    </table>
                                @endif
                            </div>

                            <div class="table-responsive" style="padding: 0px 60px;">
                                @if($holdingAssessment->holdingInfo->structureInfos)

                                    <table class="table table-bordered">
                                        <tbody>
                                        <tr>
                                            <th colspan="10" class="text-center">নির্মাণ ব্যয় পদ্ধতি</th>
                                        </tr>
                                        <tr>
                                            <th>স্থাপনা নং</th>
                                            <th>স্থাপনার ধরন</th>
                                            <th>মোট তলা</th>
                                            <th>মালিকের ব্যবহৃত তলার সংখা</th>
                                            <th colspan="3">আয়তন (বর্গফুট)</th>
                                            <th>ব্যয়/প্রতি বর্গফুট</th>
                                            <th>মোট(টাকা)</th>
                                            <th>মন্তব্য</th>
                                        </tr>
                                        @php
                                            $totalAmount = 0;
                                        @endphp
                                        @foreach($holdingAssessment->holdingInfo->structureInfos as $holdingStructure)
                                            <tr>
                                                <td>{{enNumberToBn($loop->iteration)}}</td>
                                                <td>{{ $holdingStructure->holdingStructureType->name??"" }}</td>
                                                <td>{{ enNumberToBn($holdingStructure->total_floor) }}</td>
                                                <td>{{ enNumberToBn($holdingStructure->owner_use_floor_no) }}</td>
                                                <td>{{ enNumberToBn(number_format($holdingStructure->structure_length,2)) }}</td>
                                                <td>{{ enNumberToBn(number_format($holdingStructure->structure_width,2)) }}</td>
                                                <td>{{ enNumberToBn(number_format($holdingStructure->structure_volume,2)) }}</td>
                                                <td>{{ enNumberToBn($holdingStructure->construction_rate) }}</td>
                                                <td>{{ enNumberToBn($holdingStructure->construction_amount) }}</td>
                                                <td>মালিকের অংশ</td>
                                            </tr>
                                            @php
                                                $totalAmount += $holdingStructure->construction_amount;
                                            @endphp
                                        @endforeach

                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th colspan="8">মোট নির্মাণ ব্যয়</th>
                                            <th>{{ enNumberToBn(number_format($totalAmount,2)) }}</th>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th colspan="8">বার্ষিক মূল্যায়ণ (নির্মাণ ব্যয়ের ৭.৫%)</th>
                                            <th>{{ enNumberToBn(number_format(($totalAmount*7.5)/100,2)) }}</th>
                                            <td></td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                @endif
                            </div>
                            <div class="table-responsive" style="padding: 0px 60px;">
                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        <th width="80%">বার্ষিক মূল্যায়ণ ( ভাড়া ও নির্মাণ ব্যয় পদ্ধতির মধ্যে যেটি কম )</th>
                                        <th class="text-right">{{ enNumberToBn(number_format($holdingAssessment->Yearly_assesment,2)) }}</th>
                                    </tr>
                                    <tr>
                                        <td width="80%">রক্ষণাবেক্ষন খরচ (১ম বার্ষিক মূল্যায়ণ * ১/৬ )</td>
                                        <td class="text-right">{{ enNumberToBn(number_format($holdingAssessment->Maintenance_deduct,2)) }}</td>
                                    </tr>
                                    <tr>
                                        @php
                                            $deduct_maintenance_yearly_assessment = $holdingAssessment->Yearly_assesment - $holdingAssessment->Maintenance_deduct;
                                        @endphp
                                        <th width="80%">১ম বার্ষিক মূল্যায়ণ</th>
                                        <th class="text-right">{{ enNumberToBn(number_format($deduct_maintenance_yearly_assessment,2)) }}</th>
                                    </tr>
                                    <tr>
                                        <td width="80%">মালিক নিজে বসবাস করলে ১ম বার্ষিক মূল্যায়ণের ১/৪ অংশ রেয়াদ পাবেন</td>
                                        <td class="text-right">{{ enNumberToBn(number_format($holdingAssessment->owner_deduct,2)) }}</td>
                                    </tr>
                                    <tr>
                                        <td width="80%">-বানিজ্যিক ব্যতীত (গৃহ নির্মাণের বার্ষিক সুদ )</td>
                                        <td class="text-right">০</td>
                                    </tr>
                                    <tr>
                                        <td width="80%">-বানিজ্যিক (বার্ষিক সুদের ১/৪ অংশ )</td>
                                        <td class="text-right">০</td>
                                    </tr>
                                    <tr>
                                        <th width="80%">'খ' অংশের প্রকৃত বার্ষিক মূল্যায়ণ</th>
                                        <th class="text-right">{{ enNumberToBn(number_format(($deduct_maintenance_yearly_assessment-$holdingAssessment->owner_deduct),2)) }}</th>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endif


                        <div class="table-responsive" style="padding: 0px 60px;">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    @if($holdingAssessment->holdingInfo->usingHolding_id ==4)
                                        <th width="80%">মোট প্রকৃত বার্ষিক মূল্যায়ণ ( ক + খ )</th>
                                    @else
                                    <th width="80%">মোট প্রকৃত বার্ষিক মূল্যায়ণ</th>
                                    @endif
                                    <th class="text-right">{{ enNumberToBn(number_format(ceil($holdingAssessment->actual_assesment??'0'),2)) }}</th>
                                </tr>
                                @if($holdingAssessment->consider_holding_tax)
                                <tr>
                                    <th width="80%">রিভিউকৃত প্রকৃত বার্ষিক মূল্যায়ণ</th>
                                    <th class="text-right">{{ enNumberToBn(number_format(ceil($holdingAssessment->consider_holding_tax??'0'),2)) }}</th>
                                </tr>
                                @endif
                                <tr>
                                    <td width="80%">হোল্ডিং কর (ধারা-৩) (৭%)</td>
                                    <td class="text-right">{{ enNumberToBn(number_format(ceil($holdingAssessment->holding_tax??'0'),2)) }}</td>
                                </tr>
                                <tr>
                                    <td width="80%">বিদ্যুৎ রেইট (ধারা-২১) (২%)</td>
                                    <td class="text-right">{{ enNumberToBn(number_format(ceil($holdingAssessment->light_tax??'0'),2)) }}</td>
                                </tr>
                                <tr>
                                    <td width="80%">পরিষ্কার রেইট (ধারা-২২) (২%)</td>
                                    <td class="text-right">{{ enNumberToBn(number_format($holdingAssessment->consrvancy_tax??'0',2)) }}</td>
                                </tr>
                                <tr>
                                    <td width="80%">বিশেষ উন্নয়ন কর (ধারা-২৫)(০%)</td>
                                    <td class="text-right">{{ enNumberToBn(number_format($holdingAssessment->other_tax??'0',2)) }}</td>
                                </tr>
                                @php
                                    $numto = new \Rakibhstu\Banglanumber\NumberToBangla();
                                @endphp
                                <tr>
                                    <th width="80%">মোট বার্ষিক পৌর করের পরিমাণ ( কথায়ঃ {{ $numto->bnWord(ceil($holdingAssessment->total_tax??'0')) }} টাকা )</th>
                                    <th class="text-right">{{ enNumberToBn(number_format(ceil($holdingAssessment->total_tax??'0'),2)) }}</th>
                                </tr>
                                </tbody>
                            </table>
                          </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function (){
            var projectSelected = '{{ request('project') }}'
            $("#contractor").change(function (){
                let contractorId = $(this).val();
                $('#project').html('<option value="">প্রকল্প নির্ধারণ</option>');
                if(contractorId != ''){
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_contractor_wise_projects') }}",
                        data: { contractorId: contractorId }
                    }).done(function( data ) {
                        $.each(data, function( index, item ) {
                            if (projectSelected == item.conacc_id)
                                $('#project').append('<option value="'+item.conacc_id+'" selected>'+item.project_id+'</option>');
                            else
                                $('#project').append('<option value="'+item.conacc_id+'">'+item.project_id+'</option>');
                        });
                    });
                }
            })
            // $('#contractor').trigger('change');
        })
        var APP_URL = '{!! url()->full()  !!}';
        function getprint(print) {
            $('.print-heading').css('display','block');
            $('.extra_column').remove();
            $('body').html($('#' + print).html());
            window.print();
            window.location.replace(APP_URL)
        }
    </script>
@endsection
