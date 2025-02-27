<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Mahasiswa::create([
            'id' => 1,
            'nama' => 'anis',
            'jurusan_id' => 1,
            'jenis_kelamin' => 'perempuan',
            'nim' => '826498234',
            'foto' => 'anis.jpg',
        ]);
    }
}
