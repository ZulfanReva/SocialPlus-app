<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class priority_bansos extends Model
{
    protected $fillable = ['label', 'score_min'];

    public function citizens()
    {
        return $this->hasMany(citizen::class);
    }
}
