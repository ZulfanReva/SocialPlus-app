<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sub_district extends Model
{
    protected $fillable = ['name', 'district_id'];

    public function district()
    {
        return $this->belongsTo(district::class);
    }

    public function citizens()
    {
        return $this->hasMany(citizen::class);
    }
}
