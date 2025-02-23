<?php

namespace App\Http\Controllers;

use App\Models\DosenMatkul;
use Illuminate\Http\Request;

class ApiDosenMatkul extends Controller
{
    /**
     * Menampilkan semua data DosenMatkul.
     */
    public function index()
    {
        $data = DosenMatkul::with(['dosen', 'matkul'])->get();
        return response()->json($data);
    }

    /**
     * Menyimpan data baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'dosen_id' => 'required|exists:dosens,id',
            'matkul_id' => 'required|exists:matkuls,id',
        ]);

        DosenMatkul::create($request->all());
        return response()->json(['message' => 'Dosen Matkul berhasil ditambahkan'], 200);
    }

    /**
     * Menampilkan data berdasarkan ID.
     */
    public function show($id)
    {
        $dosenMatkul = DosenMatkul::with(['dosen','matkul'])->find($id);

        if (!$dosenMatkul) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($dosenMatkul);
    }

    /**
     * Mengupdate data berdasarkan ID.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'dosen_id' => 'required|exists:dosens,id',
            'matkul_id' => 'required|exists:matkuls,id',
        ]);

        $dosenMatkul= DosenMatkul::find($id);

        if (!$dosenMatkul) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $dosenMatkul->update($request->all());

        return response()->json(['message' => 'Dosen matkul berhasil diperbarui'], 200);
    }

    /**
     * Menghapus data berdasarkan ID.
     */
    public function destroy($id)
    {
        $dosenMatkul = DosenMatkul::find($id);

        if (!$dosenMatkul) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $dosenMatkul->delete();

        return response()->json(['message' => 'Dosen Matkul berhasil dihapus'], 200);
    }
}
