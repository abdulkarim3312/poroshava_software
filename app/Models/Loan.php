<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_id','eid')
            ->with('SalaryScale');
    }

    public function loanType()
    {
        return $this->belongsTo(LoanType::class);
    }
}
