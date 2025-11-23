<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class district extends Model
{
    protected $fillable = ['name', 'regency_id'];

    public function regency()
    {
        return $this->belongsTo(Regency::class);
    }

    public function subDistricts()
    {
        return $this->hasMany(sub_district::class);
    }

    public function citizens()
    {
        return $this->hasMany(Citizen::class);
    }
}
