<?php

namespace Database\Seeders;

use App\Models\Regency;
use Illuminate\Database\Seeder;

class RegencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Regency::create([
            'name' => 'Banjarmasin',
            'province_id' => 1,
        ]);
    }
}
