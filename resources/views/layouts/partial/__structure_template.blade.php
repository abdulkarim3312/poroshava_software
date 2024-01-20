<div class="form-group row">
    <label for="holding_info_id" class="col-sm-2 col-form-label">হোল্ডিং নং</label>
    <div class="col-sm-4">
        <input type="hidden" name="holding_tax_payer_id" id="holding_tax_payer_id" value="{{ $structureHolding->holding_tax_payer_id }}">
        <input type="hidden" name="structure_holding_info_id" id="structure_holding_info_id" value="{{ $structureHolding->id }}">
        <select type="text" name="holding_info_id" id="holding_info_id2" class="form-control select2" required>
            <option value="">নির্বাচন করুন</option>
            @foreach($holdingInfos as $holdingInfo)
                <option {{ old('holding_info_id',$structureHolding->holding_info_id) == $holdingInfo->id ? 'selected' : ''  }} value="{{ $holdingInfo->id }}">{{ enNumberToBn($holdingInfo->holding_no) }}</option>
            @endforeach
        </select>
    </div>
    <label for="construction_rate" class="col-sm-2 col-form-label">নির্মাণের হার</label>
    <div class="col-sm-4">
        <input type="text" name="construction_rate" id="construction_rate" class="form-control" value="{{old('construction_rate',$structureHolding->construction_rate ?? '')}}" placeholder="" required>
    </div>
</div>
<div class="form-group row">
    <label for="use_type_id2" class="col-sm-2 col-form-label">হোল্ডিং ব্যবহারের ধরন</label>
    <div class="col-sm-4">
        <select type="text" name="use_type_id" id="use_type_id2" class="form-control select2">
            <option value="">নির্বাচন করুন</option>
            @foreach($holdingUseTypes as $holdingUseType)
                <option {{ old('use_type_id',$structureHolding->use_type_id) == $holdingUseType->id ? 'selected' : ''  }} value="{{ $holdingUseType->id }}">{{ $holdingUseType->name }}</option>
            @endforeach
        </select>
    </div>
    <label for="structure_type_id2" class="col-sm-2 col-form-label">স্থাপনার ধরন</label>
    <div class="col-sm-4">
        <select type="text" name="structure_type_id" id="structure_type_id2" class="form-control select2" required>
            <option value="">নির্বাচন করুন</option>
            @foreach($structureTypes as $structureType)
                <option {{ old('structure_type_id',$structureHolding->structure_type_id) == $structureType->id ? 'selected' : ''  }} value="{{ $structureType->id }}">{{ $structureType->name }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group row">
    <label for="total_floor" class="col-sm-2 col-form-label">মোট তলার সংখ্যা</label>
    <div class="col-sm-4">
        <input type="text" name="total_floor" id="total_floor" class="form-control" placeholder="" value="{{old('total_floor',$structureHolding->total_floor ?? '')}}" required>
    </div>
    <label for="unuse_floor" class="col-sm-2 col-form-label">অব্যবহৃত তলার সংখ্যা</label>
    <div class="col-sm-4">
        <input type="text" name="unuse_floor" id="unuse_floor" class="form-control" placeholder="" value="{{old('unuse_floor',$structureHolding->unuse_floor_no ?? '')}}"  required>
    </div>
</div>
<div class="form-group row">
    <label for="owner_floor" class="col-sm-2 col-form-label">মালিকের ব্যবহৃত তলার সংখ্যা</label>
    <div class="col-sm-4">
        <input type="text" name="owner_floor" id="owner_floor" class="form-control" value="{{old('owner_floor',$structureHolding->owner_use_floor_no ?? '')}}"  placeholder="" required>
    </div>
    <label for="rent_floor" class="col-sm-2 col-form-label">ভাড়ায় ব্যবহৃত তলার সংখ্যা</label>
    <div class="col-sm-4">
        <input type="text" name="rent_floor" id="rent_floor" class="form-control" value="{{old('rent_floor',$structureHolding->tenant_use_floor_no ?? '')}}"   required>
    </div>
</div>
<div class="form-group row">
    <label for="structure_length" class="col-sm-2 col-form-label">দৈর্ঘ্য</label>
    <div class="col-sm-4">
        <input type="text" name="structure_length" id="structure_length" class="form-control" value="{{old('structure_length',$structureHolding->structure_length ?? '')}}"  placeholder="ft units" required>
    </div>
    <label for="structure_width" class="col-sm-2 col-form-label">প্রস্থ</label>
    <div class="col-sm-4">
        <input type="text" name="structure_width" id="structure_width" class="form-control" value="{{old('structure_width',$structureHolding->structure_width ?? '')}}" placeholder="ft units" required>
    </div>
</div>
<div class="form-group row">
    <label for="structure_length" class="col-sm-2 col-form-label">আনুমানিক মাসিক ভাড়া <spna class="text-danger">*</spna></label>
    <div class="col-sm-10">
        <input type="text" name="aprox_monthly_rent" id="aprox_monthly_rent" class="form-control" value="{{old('aprox_monthly_rent',$structureHolding->aprox_monthly_rent ?? '')}}" placeholder="আনুমানিক মাসিক ভাড়া " required>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.select2').select2();
    });
</script>
