<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\MahasiswaMatkul;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MahasiswaMatkulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MahasiswaMatkul::create([
            'id' => 1,
            'mahasiswa_id' => 1,
            'matkul_id' => 1,
        ]);
    }
}
