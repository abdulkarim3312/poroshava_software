<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salaryproces extends Model
{
    protected $primaryKey = 'spid';
    protected $guarded = [];


    public function employeeName()
    {
        return $this->belongsTo(Employee::class, 'emid','eid');
    }

    public function employeeLoan()
    {
        return $this->hasMany(Loan::class, 'employee','emid');
    }


    public static function salarydetails($id){


        $employee = Employee::where('eid', $id)->first();
        $upangshos = Upangsho::where('upangsho_id', $employee->branchid)->first()->upangsho_name;
        $taxTypes = TaxType::all();



        $data = '<form role="form" class="form-horizontal" method="post" action="'.url('/').'/check_register">
            '. csrf_field() .'
            <input type="hidden" name="eid" value="'.$employee->eid.'">

            <div class="form-group">
                <label for="inputSuccess" class="col-sm-2 control-label col-lg-2">
                <strong>শাখা</strong></label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" value="'. $upangshos .'" disabled>
                </div>
            </div>

            <div class="form-group">
                <label for="inputSuccess" class="col-sm-2 control-label col-lg-2">
                <strong>কর্মচারী নাম</strong></label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="check_no" name="name" required value="'. $employee->name .'" disabled>
                </div>
            </div>

			<div class="form-group">
                <label for="inputSuccess" class="col-sm-2 control-label col-lg-2">
                <strong>পদবি</strong></label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="check_no" name="designation" required value="'. $employee->designation .'" disabled>
                </div>
            </div>

            <div class="form-group">
				<label for="inputSuccess" class="col-sm-2 control-label col-lg-2"><strong>বেতন স্কেল</strong></label>
				<div class="col-lg-10">
					<select class="form-control m-bot15" id="khattype_id" name="sid" required>

						<option value="">বেতন স্কেল নির্ধারণ</option>';

						foreach($taxTypes as $d) {

								$data .= '<option'; if($employee->scaleid==$d->tax_id) $data.= ' selected '; $data .=  'value="'. $d->tax_id.'">'.$d->tax_name.'</option>';

						}
					$data .= '</select>
				</div>
			</div>

            <div class="form-group">
                <label for="inputSuccess" class="col-sm-2 control-label col-lg-2">
                <strong>মূল বেতন</strong></label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="vourcher_no" name="salary" required value="'. $employee->salary .'">
                </div>
            </div>

            <div class="form-group">
                <label for="inputSuccess" class="col-sm-2 control-label col-lg-2">
                <strong>বাড়ী ভাড়া </strong></label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="check_no" name="houserent" required value="'. $employee->houserent .'">
                </div>
            </div>

            <div class="form-group">
                <label for="inputSuccess" class="col-sm-2 control-label col-lg-2">
                <strong>চিকৎসা </strong></label>
                <div class="col-lg-10">
                    <input type="text" class="form-control"  id="check_no" name="treatment" required value="'. $employee->treatment .'">
                </div>
            </div>

            <div class="form-group">
                <label for="inputSuccess" class="col-sm-2 control-label col-lg-2">
                <strong>টিফিন</strong></label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="check_no" name="tifin" value="'. $employee->tifin .'">
                </div>
            </div>

            <div class="form-group">
                <label for="inputSuccess" class="col-sm-2 control-label col-lg-2">
                <strong>ধোলাই</strong></label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="check_no" name="wash" value="'. $employee->wash .'">
                </div>
            </div>

            <div class="form-group">
                <label for="inputSuccess" class="col-sm-2 control-label col-lg-2">
                <strong>শিক্ষভাতা</strong></label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="check_no" name="education" value="'. $employee->education .'">
                </div>
            </div>

            <div class="form-group">
                <label for="inputSuccess" class="col-sm-2 control-label col-lg-2">
                <strong>ভ্রমনভাতা</strong></label>
                <div class="col-lg-10">
                    <input type="text" class="form-control"  id="vourcher_no" name="tour" required value="'. $employee->tour .'">
                </div>
            </div>

            <div class="form-group">
                <label for="inputSuccess" class="col-sm-2 control-label col-lg-2">
                <strong>মোবাইল ভাতা</strong></label>
                <div class="col-lg-10">
                    <input type="text" class="form-control"  id="vourcher_no" name="mobile" required value="'. $employee->mobile .'">
                </div>
            </div>

            <div class="form-group">
                <label for="inputSuccess" class="col-sm-2 control-label col-lg-2">
                <strong>গাড়ী বাবদ</strong></label>
                <div class="col-lg-10">
                    <input type="text" class="form-control"  id="vourcher_no" name="tranport" required value="'. $employee->tranport .'">
                </div>
            </div>

            <div class="form-group">
                <label for="inputSuccess" class="col-sm-2 control-label col-lg-2">
                <strong>মহার্ঘভাতা</strong></label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="receive_date" name="mohargho" required value="'. $employee->mohargho .'">
                </div>
            </div>

            <div class="form-group">
                <div class="col-lg-12">
                    <button class="btn btn-success pull-right" type="submit">Submit</button>
                </div>
            </div>
        </form>';

        return $data;
    }



    public static function details($id){


        $employee = Employee::where('eid', $id)->first();
        $upangshos = Upangsho::all();
        $taxTypes = TaxType::all();


        $data = '<form role="form" class="form-horizontal" method="post" action="'.url('/').'/update-incomeexpense" enctype="multipart/form-data">
            '. csrf_field() .'
            <input type="hidden" name="eid" value="'.$employee->eid.'">
            <div class="form-group">
				<label for="inputSuccess" class="col-sm-2 control-label col-lg-2"><strong>শাখা </strong></label>
				<div class="col-lg-10">
					<select class="form-control m-bot15" id="upangsho_id" name="bid" required>
						<option value="">শাখা নির্ধারণ</option>';
						foreach($upangshos as $d){

							$data .= '<option'; if($employee->branchid==$d->upangsho_id) $data.= ' selected '; $data .=  'value="'.$d->upangsho_id.'">'.$d->upangsho_name.'</option>';
						}
					$data .= '</select>
				</div>
            </div>

            <div class="form-group">
				<label for="inputSuccess" class="col-sm-2 control-label col-lg-2"><strong>বেতন স্কেল </strong></label>
				<div class="col-lg-10">
					<select class="form-control m-bot15" id="khattype_id" name="sid" required>

						<option value="">বেতন স্কেল নির্ধারণ</option>';

						foreach($taxTypes as $d) {

								$data .= '<option'; if($employee->scaleid==$d->tax_id) $data.= ' selected '; $data .=  'value="'. $d->tax_id.'">'.$d->tax_name.'</option>';

						}
					$data .= '</select>
				</div>
			</div>

			<div class="form-group">
                <label for="inputSuccess" class="col-sm-2 control-label col-lg-2">
                <strong>পদবি </strong></label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="পদবি" id="check_no" name="designation" required value="'. $employee->designation .'">
                </div>
            </div>

            <div class="form-group">
                <label for="inputSuccess" class="col-sm-2 control-label col-lg-2">
                <strong>মূল বেতন </strong></label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="মূল বেতন" id="vourcher_no" name="salary" required value="'. $employee->salary .'">
                </div>
            </div>

			<div class="form-group">
                <label for="inputSuccess" class="col-sm-2 control-label col-lg-2">
                <strong>যোগদানের তারিখ </strong></label>
                <div class="col-lg-10">
                    <input type="date" class="form-control" id="receive_date" name="joindate" required value="'. $employee->joindate .'">
                </div>
            </div>

			<div class="form-group">
                <label for="inputSuccess" class="col-sm-2 control-label col-lg-2">
                <strong>কর্মচারী নাম </strong></label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="কর্মচারী নাম" id="check_no" name="name" required value="'. $employee->name .'">
                </div>
            </div>

            <div class="form-group">
                <label for="inputSuccess" class="col-sm-2 control-label col-lg-2">
                <strong>বাবার নাম </strong></label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="বাবার নাম" id="check_no" name="fname" required value="'. $employee->fname .'">
                </div>
            </div>

            <div class="form-group">
				<label for="inputSuccess" class="col-sm-2 control-label col-lg-2"><strong>ধর্ম </strong></label>
				<div class="col-lg-10">
					<select class="form-control m-bot15" id="khattype_id" name="relig" required>

						<option value="">ধর্ম নির্ধারণ</option>
						<option'; if($employee->relig==1) $data .= ' selected '; $data .= ' class="" value="1">মুসলিম</option>
				        <option'; if($employee->relig==2) $data .= ' selected '; $data .= ' class="" value="2">হিন্দু</option>
					</select>
				</div>
			</div>

            <div class="form-group">
                <label for="inputSuccess" class="col-sm-2 control-label col-lg-2">
                <strong>জাতীয় পরিচয় পত্র নং </strong></label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="জাতীয় পরিচয় পত্র নং" id="check_no" name="nid" required value="'. $employee->nid .'">
                </div>
            </div>

            <div class="form-group">
                <label for="inputSuccess" class="col-sm-2 control-label col-lg-2">
                <strong>TIN নং</strong></label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="TIN নং" id="check_no" name="tin" value="'. $employee->tin .'">
                </div>
            </div>

            <div class="form-group">
                <label for="inputSuccess" class="col-sm-2 control-label col-lg-2">
                <strong>মোবাইল নং</strong></label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="মোবাইল নং" id="check_no" name="mob" value="'. $employee->mob .'">
                </div>
            </div>

            <div class="form-group">
                <label for="inputSuccess" class="col-sm-2 control-label col-lg-2">
                <strong>ই-মেইল</strong></label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="ই-মেইল" id="check_no" name="email" value="'. $employee->email .'">
                </div>
            </div>

            <div class="form-group">
                <label for="inputSuccess" class="col-sm-2 control-label col-lg-2">
                <strong>বেতন হিসাব নং </strong></label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="বেতন হিসাব নং" id="vourcher_no" name="salaryaccno" required value="'. $employee->salaryaccno .'">
                </div>
            </div>

            <div class="form-group">
                <label for="inputSuccess" class="col-sm-2 control-label col-lg-2">
                <strong>তহবিল হিসাব নং </strong></label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="তহবিল হিসাব নং" id="vourcher_no" name="pfaccno" required value="'. $employee->pfaccno .'">
                </div>
            </div>

            <div class="form-group">
                <label for="inputSuccess" class="col-sm-2 control-label col-lg-2">
                <strong>অনুতোষিক হিসাব নং </strong></label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="অনুতোষিক হিসাব নং" id="vourcher_no" name="grataccno" required value="'. $employee->grataccno .'">
                </div>
            </div>

            <div class="form-group">
                <label for="inputSuccess" class="col-sm-2 control-label col-lg-2">
                <strong>জন্ম তারিখ </strong></label>
                <div class="col-lg-10">
                    <input type="date" class="form-control" id="receive_date" name="birthdate" required value="'. $employee->birthdate .'">
                </div>
            </div>


            <div class="form-group">
                <label for="inputSuccess" class="col-sm-2 control-label col-lg-2">
                <strong>অবসরের তারিখ</strong></label>
                <div class="col-lg-10">
                    <input type="date" class="form-control"  id="receive_date" name="retireddate" value="'. $employee->retireddate .'">
                </div>
            </div>

            <div class="form-group">
				<label for="inputSuccess" class="col-sm-2 control-label col-lg-2"><strong>অবস্থা </strong></label>
				<div class="col-lg-10">
					<select class="form-control m-bot15" id="khattype_id" name="satatus" required>

						<option value="">অবস্থা নির্ধারণ</option>
						<option'; if($employee->satatus==1) { $data .= ' selected '; } $data .= ' class="" value="1">অ্যাক্টিভ</option>
				        <option'; if($employee->satatus==2) { $data .= ' selected '; } $data .= ' class="" value="2">রিজাইন</option>
				        <option'; if($employee->satatus==3) { $data .= ' selected '; } $data .= ' class="3" value="">অবসর</option>
					</select>
				</div>
			</div>

            <div class="form-group">
                <label for="inputSuccess" class="col-sm-2 control-label col-lg-2">
                <strong>ছবি</strong></label>
                <div class="col-lg-10">
                    <img src="'.url('/').'/public/employee/'. $employee->photo .'" width="120">
                    <input type="file" class="form-control"  id="receive_date" name="photo" value="'. $employee->photo .'">
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-12">
                    <button class="btn btn-success pull-right" type="submit">Submit</button>
                </div>
            </div>
        </form>';

        return $data;
    }
}
