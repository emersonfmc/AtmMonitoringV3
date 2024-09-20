<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TblArea extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function Company()
    {
        return $this->belongsTo(TblCompany::class, 'company_id', 'id');
    }

    public function District()
    {
        return $this->belongsTo(TblDistrict::class, 'district_id', 'id');
    }

    // public function Company()
    // {
    //     return $this->hasMany(TblCompany::class, 'id', 'company_id');
    // }
}
