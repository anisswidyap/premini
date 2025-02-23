<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Matkul;
use Illuminate\Http\Request;

class ApiJurusan extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Jurusan::with('fakultas');

        if ($request->has('search')) {
            $query->where('jurusan', 'like', '%' . $request->search . '%');
        }

        $data = $query->get();
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
            'jurusan' => 'required|string',
            'fakultas_id' => 'required|exists:fakultas,id',
        ]);

        Jurusan::create($request->all());
        return response()->json('Jurusan berhasil ditambahkan', 200);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jurusan = Jurusan::with('fakultas')->find($id);

    if (!$jurusan) {
        return response()->json(['message' => 'data tidak ditemukan'], 404);
    }

          return response()->json($jurusan);
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
            'jurusan' => 'required|string',
            'fakultas_id' => 'required|exists:fakultas,id',
        ]);

        $jurusan = Jurusan::find($id);

        if (!$jurusan) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }

        $jurusan->update($request->all());

        return response()->json('Jurusan berhasil diedit', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
{
    $jurusan = jurusan::find($id);
    if (!$jurusan) {
        return response()->json(['message' => 'Data tidak ditemukan'], 404);
    }
    $jurusan->delete();
    return response()->json('jurusan berhasil dihapus', 200);
}

}
