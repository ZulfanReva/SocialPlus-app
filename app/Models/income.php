<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $fillable = ['name', 'score_income', 'is_active'];

    public function citizens()
    {
        return $this->hasMany(citizen::class);
    }
}
