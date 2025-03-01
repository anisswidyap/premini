<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Fakultas;
use App\Models\Jurusan;
use App\Models\Mahasiswa;
use App\Models\Matkul;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index() {
        $data = [
            'fakultas' => Fakultas::count(),
            'jurusan' => Jurusan::count(),
            'dosen' => Dosen::count(),
            'mahasiswa' => Mahasiswa::count(),
        ];

        return response()->json($data);
    }
}
