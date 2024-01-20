<?php

namespace App\Models\Collection;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionClosing extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $dates = ['date'];
    public function closingBy()
    {
        return $this->belongsTo(User::class,'closing_by','id');
    }
    public function approveBy()
    {
        return $this->belongsTo(User::class,'approve_by','id');
    }


    public function collections($date,$user)
    {
        return Collection::where('collect_by',$user)->where('date',$date)->sum('grand_total');
    }
}
