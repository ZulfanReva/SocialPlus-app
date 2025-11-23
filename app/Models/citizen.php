<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Citizen extends Model
{
    protected $fillable = [
        'NIK', 'name', 'place_birth', 'date_birth', 'gender', 'address',
        'province_id', 'regency_id', 'district_id', 'sub_district_id',
        'education', 'work_id', 'income_id', 'relationship_id', 'priority_bansos_id'
    ];

    public function province()
    {
        return $this->belongsTo(province::class);
    }

    public function regency()
    {
        return $this->belongsTo(regency::class);
    }

    public function district()
    {
        return $this->belongsTo(district::class);
    }

    public function subDistrict()
    {
        return $this->belongsTo(sub_district::class);
    }

    public function work()
    {
        return $this->belongsTo(work::class);
    }

    public function income()
    {
        return $this->belongsTo(income::class);
    }

    public function relationship()
    {
        return $this->belongsTo(relationship::class);
    }

    public function priorityBansos()
    {
        return $this->belongsTo(priority_bansos::class);
    }

    public function distributions()
    {
        return $this->hasMany(distribution::class);
    }
}
