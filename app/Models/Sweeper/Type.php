<?php

namespace App\Models\Sweeper;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    public function cleanerType()
    {
        return $this->hasMany(Cleaner::class);
    }
    public function cleaners()
    {
        return $this->hasMany(Cleaner::class);
    }
}
