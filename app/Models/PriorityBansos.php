<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriorityBansos extends Model
{
    protected $fillable = ['label', 'score_min'];

    public function citizens()
    {
        return $this->hasMany(citizen::class);
    }
}
