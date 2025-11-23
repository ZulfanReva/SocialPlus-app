<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Relationship extends Model
{
    protected $fillable = ['name', 'score_relationship', 'is_active'];

    public function citizens()
    {
        return $this->hasMany(Citizen::class);
    }
}
