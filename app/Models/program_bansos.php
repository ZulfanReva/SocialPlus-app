<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class program_bansos extends Model
{
    protected $fillable = ['name', 'description'];

    public function distributions()
    {
        return $this->hasMany(distribution::class);
    }
}
