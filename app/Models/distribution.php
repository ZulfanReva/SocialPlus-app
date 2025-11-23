<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class distribution extends Model
{
    protected $fillable = [
        'users_id', 'citizen_id', 'program_bansos_id', 'period_bansos_id',
        'status', 'evidence', 'note'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function citizen()
    {
        return $this->belongsTo(citizen::class);
    }

    public function programBansos()
    {
        return $this->belongsTo(program_bansos::class);
    }

    public function periodBansos()
    {
        return $this->belongsTo(period_bansos::class);
    }
}
