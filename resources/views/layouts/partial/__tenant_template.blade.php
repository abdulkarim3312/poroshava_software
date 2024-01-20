<div class="form-group row">
    <label for="holding_info_id" class="col-sm-3 col-form-label">হোল্ডিং নং</label>
    <div class="col-sm-7">
        <input type="hidden" name="holding_tax_payer_id" id="holding_tax_payer_id" value="{{ $holdingTenant->holding_tax_payer_id }}">
        <input type="hidden" name="holding_tenant_info_id" id="holding_tenant_info_id" value="{{ $holdingTenant->id }}">
        <select type="text" name="holding_info_id" id="holding_info_id" class="form-control select2" required>
            <option value="">নির্বাচন করুন</option>
            @foreach($holdingInfos as $holdingInfo)
                <option {{ old('holding_info_id',$holdingTenant->holding_info_id) == $holdingInfo->id ? 'selected' : ''  }} value="{{ $holdingInfo->id }}">{{ enNumberToBn($holdingInfo->holding_no) }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group row">
    <label for="structure_type_id3" class="col-sm-3 col-form-label">স্থাপনার ধরন</label>
    <div class="col-sm-7">
        <select type="text" name="structure_type_id" id="structure_type_id3" class="form-control select2" required>
            <option value="">নির্বাচন করুন</option>
            @foreach($structureTypes as $structureType)
                <option {{ old('structure_type_id',$holdingTenant->structure_type_id) == $structureType->id ? 'selected' : ''  }} value="{{ $structureType->id }}">{{ $structureType->name }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group row">
    <label for="tenant_floor" class="col-sm-3 col-form-label">ফ্লাট নাম্বর</label>
    <div class="col-sm-7">
        <input type="text" name="tenant_floor" id="tenant_floor" class="form-control"  value="{{old('tenant_floor',$holdingTenant->tenant_floor ?? '')}}">
    </div>
</div>
<div class="form-group row">
    <label for="tenant_name" class="col-sm-3 col-form-label">ভাড়াটিয়ার নাম</label>
    <div class="col-sm-7">
        <input type="text" name="tenant_name" id="tenant_name" class="form-control" value="{{old('tenant_name',$holdingTenant->tenant_name ?? '')}}"  required>
    </div>
</div>
<div class="form-group row">
    <label for="nid" class="col-sm-3 col-form-label">এনআইডি নাম্বার</label>
    <div class="col-sm-7">
        <input type="text" name="nid" id="nid" class="form-control" value="{{old('nid',$holdingTenant->nid_no ?? '')}}"  required>
    </div>
</div>
<div class="form-group row">
    <label for="monthly_rent" class="col-sm-3 col-form-label">মাসিক ভাড়া</label>
    <div class="col-sm-7">
        <input type="text" name="monthly_rent" id="monthly_rent" class="form-control" value="{{old('monthly_rent',$holdingTenant->monthly_rent ?? '')}}" required>
    </div>
</div>


<script>
    $(document).ready(function () {
        $('.select2').select2();
    });
</script>
