<?php

namespace App\Http\Controllers;

use App\Models\DosenMatkul;
use Illuminate\Http\Request;

class ApiDosenMatkul extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = DosenMatkul::with('dosen', 'jurusan', 'matkul');
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'dosen_id' => 'required|exists::dosen,id',
            'jurusan_id' => 'required|exists::jurusan,id',
            'matkul_id' => 'required|exists::matkul,id',
        ]);
        DosenMatkul::create($request->all());
        return response()->json('Mahasiswa Matkul berhasil ditambahkan', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dosenmatkul = DosenMatkul::with('dosen, jurusan, matkul')->find($id);

        if (!$dosenmatkul) {
            return response()->json(['message' => 'data tidak di temukan'], 404);
        }

        return response()->json($dosenmatkul);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'dosen_id' => 'required|exists::dosen,id',
            'jurusan_id' => 'required|exists::jurusan,id',
            'matkul_id' => 'required|exists::matkul,id',
        ]);

        $dosenmatkul = DosenMatkul::find($id);

        if (!$dosenmatkul) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }

        $dosenmatkul->update($request->all());

        return response()->json('Dosen Matkul berhasil diedit', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dosenmatkul = DosenMatkul::find($id);
        $dosenmatkul->delete();
        return response()->json('Dosen Matkul berhasil dihapus', 200);
    }
}
