<?php

namespace App\Http\Controllers;

use App\Models\MahasiswaMatkul;
use Dotenv\Repository\RepositoryInterface;
use Illuminate\Http\Request;

class ApiMahasiswaMatkul extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = MahasiswaMatkul::with('mahasiswa, matkul')->get();
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
            'mahasiswa_id' => 'required|exists::mahasiswa,id',
            'matkul_id' => 'required|exists::matkul,id',
        ]);
        MahasiswaMatkul::create($request->all());
        return response()->json('Mahasiswa matkul berhasil ditambahkan', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mahasiswamatkul = MahasiswaMatkul::with('mahasiswa, mahasiswa')->find($id);

        if (!$mahasiswamatkul) {
            return response()->json(['message' => 'data tidak di temukan'], 404);
        }

        return response()->json($mahasiswamatkul);

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
            'mahasiswa_id' => 'required|exists::mahasiswa,id',
            'mahasiswa_id' => 'required|exists::mahasiswa,id',
        ]);

        $mahasiswamatkul = MahasiswaMatkul::find($id);

        if (!$mahasiswamatkul) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }

        $mahasiswamatkul->update($request->all());

        return response()->json('Mahasiswa matkul berhasil diedit', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mahasiswamatkul = MahasiswaMatkul::find($id);
        $mahasiswamatkul->delete();
        return response()->json('MahasiswaMatkul berhasil dihapus', 200);
    }
}
