<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaxTypeType extends Model
{
    protected $primaryKey = 'tax_id';
    protected $guarded = [];
    public function upangsho()
    {
        return $this->belongsTo(Upangsho::class,'upangsho_id','upangsho_id');
    }
    public function taxType()
    {
        return $this->belongsTo(TaxType::class,'khtattype_id','tax_id');
    }


}
