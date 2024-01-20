<?php

namespace App\Models\Sweeper;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;

class Area extends Model
{
    protected $fillable = [
        'community', 'president'
    ];

    public function cleaners()
    {
        return $this->hasMany(Cleaner::class);
    }
}
