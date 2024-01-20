@extends('layouts.app')

@section('title')
    হোল্ডিং মালিকের সকল তথ্য
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
                <div class="card-header">
                    {{--                    <h3 class="">{{dd($holdingTaxPayer)}}</h3>--}}
                </div>

                <div class="card-body">

                    <div id="accordionOne">
                        <div class="card card-dark">
                            <div class="card-header">
                                <h5 class="card-title w-100">
                                    <div class="d-block w-100">
                                        <span class="" style="float: left; font-size: 17px; font-weight: 900;">হোল্ডিং মালিকের তথ্য</span>
                                    </div>
                                    <a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapseOne" aria-expanded="false">
                                        <i class="fa fa-plus" style="float: right; font-size: 17px; font-weight: 900;"></i>
                                    </a>
                                </h5>
                            </div>
                            <div id="collapseOne" class="collapse" data-parent="#accordionOne" style="">

                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tbody>
                                        <tr>
                                            <td>মালিকের নাম :</td>
                                            <td>{{ $holdingTaxPayer->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>পিতা/স্বামীর নাম :</td>
                                            <td>{{ $holdingTaxPayer->father_husband_name }}</td>
                                        </tr>
                                        <tr>
                                            <td>মাতার নাম :</td>
                                            <td>{{ $holdingTaxPayer->mother_name }}</td>
                                        </tr>
                                        <tr>
                                            <td>ই-মেইল ঠিকানা :</td>
                                            <td>{{ $holdingTaxPayer->email }}</td>
                                        </tr>
                                        <tr>
                                            <td>মোবাইল নাম্বার :</td>
                                            <td>{{ enNumberToBn($holdingTaxPayer->contact_no) }}</td>
                                        </tr>
                                        <tr>
                                            <td>ঠিকানা :</td>
                                            <td>{{ $holdingTaxPayer->address }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p style="color: darkred;">****হোল্ডিং এর তথ্য আপডেট করূন । *( '+' ক্লিক করূন * 'edit')</p>
                    <div id="accordionTwo">
                        <div class="card card-info">
                            <div class="card-header">

                                <h5 class="card-title w-100">
                                    <div class="d-block w-100">
                                        <span class="" style="float: left; font-size: 17px; font-weight: 900; margin-top: 8px;">হোল্ডিং এর তথ্য</span>
                                    </div>
                                    <a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapseTwo" aria-expanded="false">
                                        <i class="fa fa-plus" style="float: right; font-size: 17px; font-weight: 900;margin-top: 8px;margin-left: 20px;"></i>
                                    </a>
                                    <div class="d-block w-100">
                                        <button class="btn btn-sm btn-dark" style="float: right; font-size: 15px; font-weight: 900;" data-toggle="modal" data-target="#taxPayerModalOne">হোল্ডিং তথ্য আপডেট</button>
                                    </div>
                                </h5>
                            </div>
                            <div id="collapseTwo" class="collapse" data-parent="#accordionTwo" style="">

                                <div class="card-body">
                                    <table id="tableTwo" class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>হোল্ডি নাম্বার</th>
                                            <th>ওয়ার্ড নাম্বার</th>
                                            <th>মহল্লা/রাস্তা</th>
                                            <th>মালিকানার ধরন</th>
                                            <th>বাৎসরিক ঋণের পরিমান</th>
                                            <th>হোল্ডিং সুবিধা</th>
                                            <th>ইমারত ব্যবহারের ধরন</th>
                                            <th>হোল্ডিং ব্যবহারের ধরন</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>{{ enNumberToBn($holdingInfo->holding_no ?? '') }}</td>
                                                <td>{{ enNumberToBn($holdingInfo->wardInfo->ward_no??'') }}</td>
                                                <td>{{ $holdingInfo->moholla_name??'' }}</td>
                                                <td>{{ $holdingInfo->holdingCategory->name??'' }}</td>
                                                <td>{{ $holdingInfo->loan_deduct ??'' }}</td>
                                                <td>{{ $holdingInfo->holdingFacility->facility_name??"" }}</td>
                                                <td>
                                                    @if($holdingInfo->usingHolding_id ?? '' ==1)
                                                        সম্পূর্ণ ভাড়া দেয়া গৃহ
                                                    @elseif($holdingInfo->usingHolding_id ?? ''==2)
                                                        ঋনসহ সম্পূর্ণ ভাড়া দেয়া গৃহ
                                                    @elseif($holdingInfo->usingHolding_id ?? ''==3)
                                                        মালিক নিজে বসবাস করেন
                                                    @elseif($holdingInfo->usingHolding_id ?? ''==4)
                                                        নিজে বসবাস ও আংশিক ভাড়া
                                                    @endif
                                                </td>
                                                <td>{{ $holdingInfo->holdingUseType->name??'' }}</td>
                                             </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <p style="color: darkred;">****স্থাপনার তথ্য অব্যশই পূরণ করতে হবে।</p>
                    <div id="accordionThree">
                        <div class="card card-dark">
                            <div class="card-header">

                                <h5 class="card-title w-100">
                                    <div class="d-block w-100">
                                        <span class="" style="float: left; font-size: 17px; font-weight: 900;margin-top: 8px;">স্থাপনার বিবরণ</span>
                                    </div>
                                    <a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapseThree" aria-expanded="false">
                                        <i class="fa fa-plus" style="float: right; font-size: 17px; font-weight: 900;margin-top: 8px; margin-left: 20px;"></i>
                                    </a>
                                    <div class="d-block w-100">
                                        <button class="btn btn-sm btn-info" style="float: right; font-size: 15px; font-weight: 900;" data-toggle="modal" data-target="#taxPayerModalTwo">স্থাপনার তথ্য যোগ</button>
                                    </div>
                                </h5>
                            </div>
                            <div id="collapseThree" class="collapse" data-parent="#accordionThree" style="">

                                <div class="card-body">
                                    <table id="tableThree" class="table table-bordered table-responsive">
                                        <thead>
                                        <tr>
                                            <th>হোল্ডি নাম্বার</th>
                                            <th>স্থাপনার ধরন</th>
                                            <th>ব্যবহারের ধরন</th>
                                            <th>মোট তলার সংখ্যা</th>
                                            <th>অব্যবহৃত তলার সংখ্যা</th>
                                            <th>ভাড়ায় ব্যবহৃত তলার সংখ্যা</th>
                                            <th>মালিকের ব্যবহৃত তলার সংখ্যা</th>
                                            <th>দৈর্ঘ(ফুট)</th>
                                            <th>প্রস্থ(ফুট)</th>
                                            <th>আয়তন(বর্গফুট)</th>
                                            <th>নির্মাণ রেইট</th>
                                            <th>নির্মাণ মূল্য(টাকায়)</th>
                                            <th>অ্যাকশন</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($holdingStructures)>0)
                                            @foreach($holdingStructures as $holdingStructure)
                                                <tr>
                                                    <td>{{ enNumberToBn($holdingStructure->holdingInfo->holding_no??"") }}</td>
                                                    <td>{{ $holdingStructure->holdingStructureType->name??"" }}</td>
                                                    <td>{{ $holdingStructure->holdingUseType->name??"" }}</td>
                                                    <td>{{ enNumberToBn($holdingStructure->total_floor) }}</td>
                                                    <td>{{ enNumberToBn($holdingStructure->unuse_floor_no) }}</td>
                                                    <td>{{ enNumberToBn($holdingStructure->tenant_use_floor_no) }}</td>
                                                    <td>{{ enNumberToBn($holdingStructure->owner_use_floor_no) }}</td>
                                                    <td>{{ enNumberToBn($holdingStructure->structure_length) }}</td>
                                                    <td>{{ enNumberToBn($holdingStructure->structure_width) }}</td>
                                                    <td>{{ enNumberToBn($holdingStructure->structure_volume) }}</td>
                                                    <td>{{ enNumberToBn($holdingStructure->construction_rate) }}</td>
                                                    <td>{{ enNumberToBn($holdingStructure->construction_amount) }}</td>
                                                    <td>
                                                        <a href="#" class="btn btn-info bg-gradient-info btn-sm" data-toggle="modal" data-id="{{$holdingStructure->id}}" id="structureEditClick"><i class="fa fa-edit"></i></a>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="accordionFour">
                        <div class="card card-info">
                            <div class="card-header">

                                <h5 class="card-title w-100">
                                    <div class="d-block w-100">
                                        <span class="" style="margin-top: 8px; float: left; font-size: 17px; font-weight: 900;">ভাড়াটিয়ার তথ্য</span>
                                    </div>

                                    <a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapseFour" aria-expanded="false">
                                        <i class="fa fa-plus" style="margin-top: 8px; float: right; font-size: 17px; font-weight: 900; margin-left: 20px;"></i>
                                    </a>
                                    <div class="d-block w-100">
                                        <button class="btn btn-sm btn-dark" style="float: right; font-size: 15px; font-weight: 900;" data-toggle="modal" data-target="#taxPayerModalThree">নতুন ভাড়াটিয়া যোগ</button>
                                    </div>
                                </h5>
                            </div>
                            <div id="collapseFour" class="collapse" data-parent="#accordionFour" style="">

                                <div class="card-body">
                                    <table id="tableFour" class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>হোল্ডি নাম্বার</th>
                                            <th>ভাড়াটিয়ার নাম</th>
                                            <th>মাসিক ভাড়া</th>
                                            <th>স্থাপনার গঠন</th>
                                            <th>ফ্লাট নাম্বার</th>
                                            <th>এনআইডি</th>
                                            <th>অ্যাকশন</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($holdingTenants)>0)
                                            @foreach($holdingTenants as $holdingTenant)
                                                <tr>
                                                    <td>{{ enNumberToBn($holdingTenant->holdingInfo->holding_no??'') }}</td>
                                                    <td>{{ $holdingTenant->tenant_name }}</td>
                                                    <td>{{ enNumberToBn($holdingTenant->monthly_rent) }}</td>
                                                    <td>{{ $holdingTenant->holdingStructureType->name??'' }}</td>
                                                    <td>{{ $holdingTenant->tenant_floor }}</td>
                                                    <td>{{ enNumberToBn($holdingTenant->nid_no) }}</td>
                                                    <td>
                                                        <a href="#" class="btn btn-info bg-gradient-info btn-sm" data-toggle="modal" data-id="{{$holdingTenant->id}}" id="tenantEditClick"><i class="fa fa-edit"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="accordionFive">
                        <div class="card card-dark">
                            <div class="card-header">

                                <h5 class="card-title w-100">
                                    <div class="d-block w-100">
                                        <span class="" style="float: left; font-size: 17px; font-weight: 900;">হোল্ডিং এসেসমেন্ট</span>
                                    </div>
                                    <a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapseFive" aria-expanded="false">
                                        <i class="fa fa-plus" style="float: right; font-size: 17px; font-weight: 900;"></i>
                                    </a>
                                </h5>
                            </div>
                            <div id="collapseFive" class="collapse" data-parent="#accordionFive" style="">

                                <div class="card-body">
                                    <table id="tableFive" class="table table-bordered table-responsive">
                                        <thead>
                                        <tr>
                                            <th>হোল্ডি নাম্বার</th>
                                            <th>অর্থ বছর</th>
                                            <th>প্রকৃত মোট ভাড়া (টাকায়)</th>
                                            <th>আনুমানিক মোট ভাড়া (টাকায়)</th>
                                            <th>বাৎসরিক নির্মাণ মূল্যায়ন(৭.৫%)</th>
                                            <th>প্রকৃত বার্ষিক মূল্যায়ন</th>
                                            <th>রিভিউকৃত প্রকৃত বার্ষিক মূল্যায়ন</th>
                                            <th>হোল্ডিং কর রেট(৭%)</th>
                                            <th>বাতির রেট(২%)</th>
                                            <th>বিশেষ উন্নয়ন কর (২%)</th>
                                            <th>ময়লা আবর্জনা অপসারনের রেট(২%)</th>
                                            <th>মোট বার্ষিক পৌরকরের পরিমান</th>
                                            <th>অবস্থা/স্টেটাস</th>
                                            <th>অ্যাকশন</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($holdingAssessments)>0)
                                            @foreach($holdingAssessments as $holdingAssessment)
                                                <tr>
                                                    <td>{{ enNumberToBn($holdingAssessment->holdingInfo->holding_no??'') }}</td>
                                                    <td>{{ enNumberToBn($holdingAssessment->holdingAssessmentSetting->financial_years??'') }}</td>
                                                    <td>{{ enNumberToBn($holdingAssessment->total_monthly_rent) }}</td>
                                                    <td>{{ enNumberToBn($holdingAssessment->total_approximate_rent) }}</td>
                                                    <td>{{ enNumberToBn($holdingAssessment->Yearly_assesment) }}</td>
                                                    <td>{{ enNumberToBn($holdingAssessment->actual_assesment) }}</td>
                                                    <td>≈{{ enNumberToBn($holdingAssessment->consider_holding_tax) }}</td>
                                                    <td>{{ enNumberToBn($holdingAssessment->holding_tax) }}</td>
                                                    <td>{{ enNumberToBn($holdingAssessment->light_tax) }}</td>
                                                    <td>{{ enNumberToBn($holdingAssessment->other_tax) }}</td>
                                                    <td>{{ enNumberToBn($holdingAssessment->consrvancy_tax) }}</td>
                                                    <td>{{ enNumberToBn($holdingAssessment->total_tax) }} টাকা</td>
                                                    <td>
                                                        @if($holdingAssessment->re_interim_assessment==1)
                                                            <span class="badge badge-success">Active</span>
                                                        @else
                                                            <span class="badge badge-danger">Deactive</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('holding_tax_payer_assesment_details',['holdingAssessment'=>$holdingAssessment->id]) }}" class="btn btn-info bg-gradient-info btn-sm btn-edit"><i class="fa fa-eye"></i></a>
                                                        <a  class="btn btn-primary bg-gradient-primary btn-sm btn-assessment" data-id="{{$holdingAssessment->id }}" id="assessment" >Assessment</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal One -->
    <div class="modal fade" id="taxPayerModalOne" tabindex="-1" aria-labelledby="taxPayerModalOneLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="taxPayerModalOneLabel">হোল্ডিং তথ্য আপডেট</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form style="font-size: 12px;" enctype="multipart/form-data" id="taxPayerModalOneForm">
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="form-group row">
                                <label for="holding_no" class="col-sm-2 col-form-label">হোল্ডিং নং</label>
                                <div class="col-sm-4">
                                    <input type="text" name="holding_no" id="holding_no" value="{{old('holding_no',$holdingInfo->holding_no ?? '')}}" class="form-control" placeholder="হোল্ডিং নং" required>
                                    <input type="hidden" name="holdingTaxPayerId" id="holdingTaxPayerId" value="{{ $holdingTaxPayer->id }}" class="form-control">
                                </div>
                                <label for="old_holding_no" class="col-sm-2 col-form-label">পুরাতন হোল্ডিং নং(যদি থাকে)</label>
                                <div class="col-sm-4">
                                    <input type="text" name="old_holding_no" id="old_holding_no"  class="form-control" value="{{old('old_holding_no',$holdingInfo->old_holding_no ?? '')}}" placeholder="পুরাতন হোল্ডিং নং" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="moholla_name" class="col-sm-2 col-form-label">রাস্তার নাম</label>
                                <div class="col-sm-4">
                                    <input type="text" name="moholla_name" id="moholla_name" class="form-control" value="{{old('moholla_name',$holdingInfo->moholla_name ?? '')}}" placeholder="মালিকানার ধরন" required>
                                </div>
                                <label for="category_id" class="col-sm-2 col-form-label">মালিকানার ধরন</label>
                                <div class="col-sm-4">
                                    <select type="text" name="category_id" id="category_id" class="form-control select2" required>
                                        <option value="">নির্বাচন করুন</option>
                                        @foreach($holdingCategories as $holdingCategory)
                                            <option {{ old('category_id',$holdingInfo->holding_category_id ?? '') == $holdingCategory->id ? 'selected' : ''  }} value="{{ $holdingCategory->id }}">{{ $holdingCategory->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="ward_id" class="col-sm-2 col-form-label">ওয়ার্ড নং</label>
                                <div class="col-sm-4">
                                    <select type="text" name="ward_id" id="ward_id" class="form-control select2" required>
                                        <option value="">নির্বাচন করুন</option>
                                        @foreach($wardInfos as $wardInfo)
                                            <option {{ old('ward_id',$holdingInfo->ward_id ?? '') == $wardInfo->id ? 'selected' : ''  }} value="{{ $wardInfo->id }}">{{ $wardInfo->ward_no }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="road_id" class="col-sm-2 col-form-label">মহল্লা নাম</label>
                                <div class="col-sm-4">
                                    <select type="text" name="road_id" id="road_id" class="form-control select2" required>
                                        <option value="">নির্বাচন করুন</option>
                                        @foreach($holdingAreas as $holdingArea)
                                            <option {{ old('road_id',$holdingInfo->holding_area_id ?? '') == $holdingArea->id ? 'selected' : ''  }} value="{{ $holdingArea->id }}">{{ $holdingArea->road_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="loan_deduct" class="col-sm-2 col-form-label">বাৎসরিক ঋনের পরিমাণ</label>
                                <div class="col-sm-4">
                                    <input type="text" name="loan_deduct" id="loan_deduct" class="form-control" value="{{old('loan_deduct',$holdingInfo->loan_deduct ?? '')}}" placeholder="">
                                </div>
                                <label for="holding_facility_id" class="col-sm-2 col-form-label">হোল্ডিং সুবিধা</label>
                                <div class="col-sm-4">
                                    <select type="text" name="holding_facility_id" id="holding_facility_id" class="form-control select2" required>
                                        <option value="">নির্বাচন করুন</option>
                                        @foreach($holdingFacilities as $holdingFacilitie)
                                            <option {{ old('holding_facility_id',$holdingInfo->holding_facility_id ?? '') == $holdingFacilitie->id ? 'selected' : ''  }} value="{{ $holdingFacilitie->id }}">{{ $holdingFacilitie->facility_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="structure_type_id" class="col-sm-2 col-form-label">হোল্ডিং এর ধরন</label>
                                <div class="col-sm-4">
                                    <select type="text" name="structure_type_id" id="structure_type_id" class="form-control select2" required>
                                        <option value="">নির্বাচন করুন</option>
                                        @foreach($structureTypes as $structureType)
                                            <option {{ old('structure_type_id',$holdingInfo->structure_type_id ?? '') == $structureType->id ? 'selected' : ''  }} value="{{ $structureType->id }}">{{ $structureType->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="use_type_id" class="col-sm-2 col-form-label">হোল্ডিং ব্যবহারের ধরন</label>
                                <div class="col-sm-4">
                                    <select type="text" name="use_type_id" id="use_type_id" class="form-control select2" required>
                                        <option value="">নির্বাচন করুন</option>
                                        @foreach($holdingUseTypes as $holdingUseType)
                                            <option {{ old('use_type_id',$holdingInfo->use_type_id ?? '') == $holdingUseType->id ? 'selected' : ''  }} value="{{ $holdingUseType->id }}">{{ $holdingUseType->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-2 form-check">ইমারত ব্যবহারের ধরন</label>
                                <div class="col-sm-10 radio radio-inline">
                                    <label class="form-check form-check-inline">
                                        <input type="radio" name="usingHolding_id" value="1" {{ (old('usingHolding_id',$holdingInfo->usingHolding_id ?? '') == '1' ? 'checked' : '') }} required>
                                        &nbsp;সম্পূর্ণ ভাড়া দেয়া গৃহ
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input type="radio" name="usingHolding_id" value="2" {{ (old('usingHolding_id',$holdingInfo->usingHolding_id ?? '') == '2' ? 'checked' : '') }} required>
                                        &nbsp;ঋনসহ সম্পূর্ণ ভাড়া দেয়া গৃহ
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input type="radio" name="usingHolding_id" value="3" {{ (old('usingHolding_id',$holdingInfo->usingHolding_id ?? '') == '3' ? 'checked' : '') }} required>
                                        &nbsp;মালিক নিজে বসবাস করেন
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input type="radio" name="usingHolding_id" value="4" {{ (old('usingHolding_id',$holdingInfo->usingHolding_id ?? '') == '4' ? 'checked' : '') }} required>
                                        &nbsp;নিজে বসবাস ও আংশিক ভাড়া
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">বন্ধ</button>
                        <button type="submit" style="float: left;" class="btn btn-primary">সংরক্ষণ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Two Structure Add-->
    <div class="modal fade" id="taxPayerModalTwo" tabindex="-1" aria-labelledby="taxPayerModalTwoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="taxPayerModalTwoLabel">নির্মাণের তথ্য</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form style="font-size: 12px;" enctype="multipart/form-data" id="taxPayerModalTwoForm">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="form-group row">
                            <label for="holding_info_id" class="col-sm-2 col-form-label">হোল্ডিং নং</label>
                            <div class="col-sm-4">
                                <input type="hidden" name="holding_tax_payer_id" id="holding_tax_payer_id" value="{{ $holdingTaxPayer->id }}">
                                <select type="text" name="holding_info_id" id="holding_info_id2" class="form-control select2" required>
                                    <option value="">নির্বাচন করুন</option>
                                    <option {{ old('holding_info_id') == $holdingInfo->id ? 'selected' : ''  }} value="{{ $holdingInfo->id }}">{{ enNumberToBn($holdingInfo->holding_no) }}</option>
                                </select>
                            </div>
                            <label for="construction_rate" class="col-sm-2 col-form-label">নির্মাণের হার</label>
                            <div class="col-sm-4">
                                <input type="text" name="construction_rate" id="construction_rate" class="form-control" placeholder="" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="use_type_id2" class="col-sm-2 col-form-label">হোল্ডিং ব্যবহারের ধরন</label>
                            <div class="col-sm-4">
                                <select type="text" name="use_type_id" id="use_type_id2" class="form-control select2">
                                    <option value="">নির্বাচন করুন</option>
                                    @foreach($holdingUseTypes as $holdingUseType)
                                        <option {{ old('use_type_id') == $holdingUseType->id ? 'selected' : ''  }} value="{{ $holdingUseType->id }}">{{ $holdingUseType->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="structure_type_id2" class="col-sm-2 col-form-label">স্থাপনার ধরন</label>
                            <div class="col-sm-4">
                                <select type="text" name="structure_type_id" id="structure_type_id2" class="form-control select2" required>
                                    <option value="">নির্বাচন করুন</option>
                                    @foreach($structureTypes as $structureType)
                                        <option {{ old('structure_type_id') == $structureType->id ? 'selected' : ''  }} value="{{ $structureType->id }}">{{ $structureType->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="total_floor" class="col-sm-2 col-form-label">মোট তলার সংখ্যা</label>
                            <div class="col-sm-4">
                                <input type="text" name="total_floor" id="total_floor" class="form-control" placeholder="" required>
                            </div>
                            <label for="unuse_floor" class="col-sm-2 col-form-label">অব্যবহৃত তলার সংখ্যা</label>
                            <div class="col-sm-4">
                                <input type="text" name="unuse_floor" id="unuse_floor" class="form-control" placeholder="" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="owner_floor" class="col-sm-2 col-form-label">মালিকের ব্যবহৃত তলার সংখ্যা</label>
                            <div class="col-sm-4">
                                <input type="text" name="owner_floor" id="owner_floor" class="form-control" placeholder="" required>
                            </div>
                            <label for="rent_floor" class="col-sm-2 col-form-label">ভাড়ায় ব্যবহৃত তলার সংখ্যা</label>
                            <div class="col-sm-4">
                                <input type="text" name="rent_floor" id="rent_floor" class="form-control" placeholder="" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="structure_length" class="col-sm-2 col-form-label">দৈর্ঘ্য</label>
                            <div class="col-sm-4">
                                <input type="text" name="structure_length" id="structure_length" class="form-control" placeholder="ft units" required>
                            </div>
                            <label for="structure_width" class="col-sm-2 col-form-label">প্রস্থ</label>
                            <div class="col-sm-4">
                                <input type="text" name="structure_width" id="structure_width" class="form-control" placeholder="ft units" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="structure_length" class="col-sm-2 col-form-label">আনুমানিক মাসিক ভাড়া <spna class="text-danger">*</spna></label>
                            <div class="col-sm-10">
                                <input type="text" name="aprox_monthly_rent" id="aprox_monthly_rent" class="form-control" placeholder="আনুমানিক মাসিক ভাড়া " required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">বন্ধ</button>
                    <button type="submit" style="float: left;" class="btn btn-primary" id="taxPayerModalTwoSubmit">সংরক্ষণ</button>
                </div>
              </form>
            </div>
        </div>
    </div>

    <!-- Modal Three -->
    <div class="modal fade" id="taxPayerModalThree" tabindex="-1" aria-labelledby="taxPayerModalThreeLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="taxPayerModalThreeLabel">নতুন ভাড়াটিয়া যোগ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form style="font-size: 12px;" enctype="multipart/form-data" id="taxPayerModalThreeForm">
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="form-group row">
                                <label for="holding_info_id" class="col-sm-3 col-form-label">হোল্ডিং নং</label>
                                <div class="col-sm-7">
                                    <input type="hidden" name="holding_tax_payer_id" id="holding_tax_payer_id" value="{{ $holdingTaxPayer->id }}">
                                    <select type="text" name="holding_info_id" id="holding_info_id" class="form-control select2" required>
                                        <option value="">নির্বাচন করুন</option>
                                        <option {{ old('holding_info_id') == $holdingInfo->id ? 'selected' : ''  }} value="{{ $holdingInfo->id }}">{{ enNumberToBn($holdingInfo->holding_no) }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="structure_type_id3" class="col-sm-3 col-form-label">স্থাপনার ধরন</label>
                                <div class="col-sm-7">
                                    <select type="text" name="structure_type_id" id="structure_type_id3" class="form-control select2" required>
                                        <option value="">নির্বাচন করুন</option>
                                        @foreach($structureTypes as $structureType)
                                            <option {{ old('structure_type_id') == $structureType->id ? 'selected' : ''  }} value="{{ $structureType->id }}">{{ $structureType->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tenant_floor" class="col-sm-3 col-form-label">ফ্লাট নাম্বর</label>
                                <div class="col-sm-7">
                                    <input type="text" name="tenant_floor" id="tenant_floor" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tenant_name" class="col-sm-3 col-form-label">ভাড়াটিয়ার নাম</label>
                                <div class="col-sm-7">
                                    <input type="text" name="tenant_name" id="tenant_name" class="form-control" placeholder="" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nid" class="col-sm-3 col-form-label">এনআইডি নাম্বার</label>
                                <div class="col-sm-7">
                                    <input type="text" name="nid" id="nid" class="form-control" placeholder="" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="monthly_rent" class="col-sm-3 col-form-label">মাসিক ভাড়া</label>
                                <div class="col-sm-7">
                                    <input type="text" name="monthly_rent" id="monthly_rent" class="form-control" placeholder="" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">বন্ধ</button>
                        <button type="submit" style="float: left;" class="btn btn-primary">সংরক্ষণ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Structure edit-->
    <div class="modal fade" id="taxPayerModalStructureEdit" tabindex="-1" aria-labelledby="taxPayerModalStructureEditLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="taxPayerModalStructureEditLabel">নির্মাণের তথ্য আপডেট</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                        <form style="font-size: 12px;" enctype="multipart/form-data"  id="structureEditForm">
                        <div class="container-fluid" id="structureEditContainer">

                        </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">বন্ধ</button>
                                <button type="submit" style="float: left;" class="btn btn-primary" id="taxPayerModalStructureSubmit">সংরক্ষণ</button>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
    <!-- Modal Tenant edit-->
    <div class="modal fade" id="taxPayerModalTenantEdit" tabindex="-1" aria-labelledby="taxPayerModalTenantEditLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="taxPayerModalTenantEditLabel">ভাড়াটিয়ার তথ্য আপডেট</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form style="font-size: 12px;" enctype="multipart/form-data"  id="tenantEditForm">
                        <div class="container-fluid" id="tenantEditContainer">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">বন্ধ</button>
                            <button type="submit" style="float: left;" class="btn btn-primary" id="taxPayerModalTenantSubmit">সংরক্ষণ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        $(function () {
            $('#tableFive').DataTable();
            $('#tableFour').DataTable();
            $('#tableThree').DataTable();
            $('#tableTwo').DataTable();

            //Holding add
            $('body').on('submit', 'form#taxPayerModalOneForm', function (e) {
                e.preventDefault();
                let formData = new FormData($('#taxPayerModalOneForm')[0]);

                console.log(formData);
                Swal.fire({
                    title: 'আপনি কি সংরক্ষণ/আপডেট করতে চান?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#343a40',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'হ্যাঁ, আপডেট করুন!',
                    cancelButtonText:'না'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: "POST",
                            url: "{{ route('holdingInfo_Update') }}",
                            data: formData,
                            processData: false,
                            contentType: false,
                        }).done(function(response) {
                            if(response.success){
                                $('#taxPayerModalOne').modal('hide');
                                Swal.fire(
                                    'আপডেটেড',
                                    response.message,
                                    'আপডেট হয়েছে।'
                                ).then((result)=>{
                                    location.reload();
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'উফ...',
                                    text: response.message
                                })
                            }
                        });
                    }
                })
            });


            //Sweet-alert for taxPayerModalTwo
            $('body').on('submit', 'form#taxPayerModalTwoForm', function (e) {
                e.preventDefault();
                let formData = new FormData($('#taxPayerModalTwoForm')[0]);
                Swal.fire({
                    title: 'আপনি কি সংরক্ষণ করতে চান?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#343a40',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'না',
                    confirmButtonText: 'হ্যাঁ, সংরক্ষণ করুন!'

                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: "POST",
                            url: "{{ route('holding_tax_payer_structure_add') }}",
                            data: formData,
                            processData: false,
                            contentType: false
                        }).done(function(response) {
                            if(response.success){
                                Swal.fire(
                                    'স্টোরেড',
                                    response.message,
                                    'success'
                                ).then((result)=>{
                                    location.reload();
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'উফ...',
                                    text: response.message
                                })
                            }
                        });
                    }
                })
            });

            //Structure Edit
            $('body').on('click', '#structureEditClick', function (e) {
                $("#structureEditContainer").html(' ');
                var structureId = $(this).data('id');
                if (structureId !== '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_structure_template_details') }}",
                        data: { structureId: structureId }
                    }).done(function(response) {
                        $("#structureEditContainer").html(response.html);
                        $('#taxPayerModalStructureEdit').modal('show');
                    });
                }

            });
            $('#structureEditClick').trigger('change');

            //Sweet-alert for taxPayer structure Edit
            $('body').on('submit', 'form#structureEditForm', function (e) {
                e.preventDefault();
                let formData = new FormData($('#structureEditForm')[0]);
                Swal.fire({
                    title: 'আপনি কি আপডেট করতে চান?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#343a40',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'না',
                    confirmButtonText: 'হ্যাঁ, আপডেট করুন!'

                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: "POST",
                            url: "{{ route('holding_tax_payer_structure_edit') }}",
                            data: formData,
                            processData: false,
                            contentType: false
                        }).done(function(response) {
                            if(response.success){
                                Swal.fire(
                                    'আপডেট',
                                    response.message,
                                    'success'
                                ).then((result)=>{
                                    location.reload();
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'উফ...',
                                    text: response.message
                                })
                            }
                        });
                    }
                })
            });


            //Tenant Edit
            $('body').on('click', '#tenantEditClick', function (e) {
                $("#tenantEditContainer").html(' ');
                var tenantId = $(this).data('id');

                if (tenantId !== '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_tenant_template_details') }}",
                        data: { tenantId: tenantId }
                    }).done(function(response) {
                        $("#tenantEditContainer").html(response.html);
                        $('#taxPayerModalTenantEdit').modal('show');
                    });
                }

            });
            $('#tenantEditClick').trigger('change');
            //Sweet-alert for Tenant Edit
            $('body').on('submit', 'form#tenantEditForm', function (e) {
                e.preventDefault();
                let formData = new FormData($('#tenantEditForm')[0]);
                Swal.fire({
                    title: 'আপনি কি আপডেট করতে চান?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#343a40',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'না',
                    confirmButtonText: 'হ্যাঁ, আপডেট করুন!'

                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: "POST",
                            url: "{{ route('holding_tax_payer_tenant_edit') }}",
                            data: formData,
                            processData: false,
                            contentType: false
                        }).done(function(response) {
                            if(response.success){
                                Swal.fire(
                                    'আপডেট',
                                    response.message,
                                    'success'
                                ).then((result)=>{
                                    location.reload();
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'উফ...',
                                    text: response.message
                                })
                            }
                        });
                    }
                })
            });

            //Sweet-alert for taxPayerModalThree
            $('body').on('submit', 'form#taxPayerModalThreeForm', function (e) {
                e.preventDefault();
                let formData = new FormData($('#taxPayerModalThreeForm')[0]);
                Swal.fire({
                    title: 'আপনি কি সংরক্ষণ করতে চান?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#343a40',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'না',
                    confirmButtonText: 'হ্যাঁ, সংরক্ষণ করুন!'

                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: "POST",
                            url: "{{ route('holding_tax_payer_tenant_add') }}",
                            data: formData,
                            processData: false,
                            contentType: false
                        }).done(function(response) {
                            if(response.success){
                                Swal.fire(
                                    'স্টোরেড',
                                    response.message,
                                    'success'
                                ).then((result)=>{
                                    location.reload();
                                    // console.log(response.infos);
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'উফ...',
                                    text: response.message
                                })
                            }
                        });
                    }
                })
            });

            //Sweet-alert for assesssment
            $('body').on('click', '.btn-assessment', function () {
                var assessmentId = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Accept it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: "Post",
                            url: "{{ route('assessment_submit_and_calculation') }}",
                            data: { assessmentId: assessmentId }
                        }).done(function( response ) {
                            if (response.success) {
                                Swal.fire(
                                    'Accepted!',
                                    response.message,
                                    'success'
                                ).then((result) => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: response.message,
                                });
                            }
                        });

                    }
                })

            });

        });
    </script>
@endsection
