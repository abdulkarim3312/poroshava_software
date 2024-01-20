<?php

namespace App\Models\Collection;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;
    protected $dates = ['date'];
    protected $guarded = [];

    public function updateBy()
    {
        return $this->belongsTo(User::class,'update_by','id');
    }
    public function type()
    {
        return $this->belongsTo(CollectionType::class);
    }
    public function subType()
    {
        return $this->belongsTo(CollectionSubType::class);
    }
    public function area()
    {
        return $this->belongsTo(CollectionArea::class,'area_id','id');
    }
}
