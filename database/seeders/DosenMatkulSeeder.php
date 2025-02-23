<?php

namespace Database\Seeders;

use App\Models\DosenMatkul;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DosenMatkulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DosenMatkul::create([
            'id' => 1,
            'dosen_id' => 1,
            'matkul_id' => 1,
        ]);
    }
}
