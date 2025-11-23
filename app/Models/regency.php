<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class regency extends Model
{
    protected $fillable = ['name', 'province_id'];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function districts()
    {
        return $this->hasMany(District::class);
    }

    public function citizens()
    {
        return $this->hasMany(Citizen::class);
    }
}
