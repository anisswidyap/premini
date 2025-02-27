<?php

namespace App\Http\Controllers;

use App\Http\Resources\MahasiswaMatkulResource;
use App\Models\MahasiswaMatkul;
use Illuminate\Http\Request;

class ApiMahasiswaMatkul extends Controller
{
    /**
     * Menampilkan semua data.
     */
    public function index()
    {
        $data = MahasiswaMatkul::with(['mahasiswa', 'matkul'])->get();
        return MahasiswaMatkulResource::collection($data);
    }

    /**
     * Menyimpan data baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'matkul_id' => 'required|exists:matkuls,id',
        ]);

        MahasiswaMatkul::create($request->all());
        return response()->json(['message' => 'Mahasiswa matkul berhasil ditambahkan'], 200);
    }

    /**
     * Menampilkan data tertentu berdasarkan ID.
     */
    public function show($id)
    {
        $mahasiswaMatkul = MahasiswaMatkul::with(['mahasiswa', 'matkul'])->find($id);

        if (!$mahasiswaMatkul) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return new MahasiswaMatkulResource($mahasiswaMatkul);
    }

    /**
     * Memperbarui data.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'matkul_id' => 'required|exists:matkuls,id',
        ]);

        $mahasiswaMatkul = MahasiswaMatkul::find($id);

        if (!$mahasiswaMatkul) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $mahasiswaMatkul->update($request->all());

        return response()->json(['message' => 'Mahasiswa matkul berhasil diperbarui'], 200);
    }

    /**
     * Menghapus data.
     */
    public function destroy(string $id)
    {
        $mahasiswaMatkul = MahasiswaMatkul::find($id);

        if (!$mahasiswaMatkul) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $mahasiswaMatkul->delete();

        return response()->json(['message' => 'Mahasiswa matkul berhasil dihapus'], 200);
    }
}
