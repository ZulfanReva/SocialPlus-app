<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramBansos extends Model
{
    protected $fillable = ['name', 'description'];

    public function distributions()
    {
        return $this->hasMany(Distribution::class);
    }
}
