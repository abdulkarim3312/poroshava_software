<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Khat extends Model
{
    protected $primaryKey = 'khat_id';
    protected $guarded = [];
    public function upangsho()
    {
        return $this->belongsTo(Upangsho::class,'upangsho_id','upangsho_id');
    }
    public function taxType()
    {
        return $this->belongsTo(TaxType::class,'tax_type_id','tax_id');
    }
    public function taxSubType()
    {
        return $this->belongsTo(TaxTypeType::class,'tax_type_type_id','tax_id');
    }
}
