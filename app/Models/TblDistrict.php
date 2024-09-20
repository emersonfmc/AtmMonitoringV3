<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TblDistrict extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function Company()
    {
        return $this->belongsTo(TblCompany::class, 'company_id', 'id');
    }
}
