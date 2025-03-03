<?php

namespace Database\Seeders;

use App\Models\Dosen;
use Illuminate\Database\Seeder;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Dosen::create([
            'id' => 1,
            'nama' => 'pak agus',
            'jurusan_id' => 1,
            'jenis_kelamin' => 'laki-laki',
            'nidn' => '826498234',
            'foto' => 'agus.jpg',
        ]);
    }
}
