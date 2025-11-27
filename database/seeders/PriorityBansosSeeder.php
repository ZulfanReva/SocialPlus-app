<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PriorityBansosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Berdasarkan rentang: Rendah (0-59), Sedang (60-79), Tinggi (80-100)
        DB::table('priority_bansos')->insert([
            // Penting: Masukkan data dari skor tertinggi ke terendah
            ['label' => 'Tinggi', 'score_min' => 80],
            ['label' => 'Sedang', 'score_min' => 60],
            ['label' => 'Rendah', 'score_min' => 0],
        ]);
    }
}
