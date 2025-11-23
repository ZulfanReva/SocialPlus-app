<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class province extends Model
{
    protected $fillable = ['name'];

    public function regencies()
    {
        return $this->hasMany(Regency::class);
    }

    public function citizens()
    {
        return $this->hasMany(Citizen::class);
    }
}
