<?php

namespace App\Models\Sweeper;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'area_id', 'team_no', 'name', 'leader'
    ];

    public function area() {
        return $this->belongsTo(Area::class);
    }
    public function cleaners()
    {
        return $this->hasMany(Cleaner::class);
    }
}
