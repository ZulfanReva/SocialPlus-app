<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class work extends Model
{
    protected $fillable = ['name', 'score_work', 'is_active'];

    public function citizens()
    {
        return $this->hasMany(citizen::class);
    }
}
