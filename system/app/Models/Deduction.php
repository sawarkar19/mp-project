<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deduction extends Model
{
    use HasFactory;

    public function deductionHistoryCount()
    {
        return $this->hasMany('App\Models\DeductionHistory', 'deduction_id', 'id')->sum('deduction_amount');
    }
}
