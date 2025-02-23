<?php

namespace App\Http\Controllers;

use App\Models\Matkul;
use Illuminate\Http\Request;

class ApiMatkul extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Matkul::with('jurusan');

        if ($request->has('search')) {
            $query->where('matkul', 'like', '%' . $request->search . '%');
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
            'jurusan_id' => 'required|exists:jurusans,id',
            'matkul' => 'required|string',
        ]);

        Matkul::create($request->all());
        return response()->json('Matkul berhasil ditambahkan', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $matkul = Matkul::with('jurusan')->find($id);

    if (!$matkul) {
        return response()->json(['message' => 'Data tidak ditemukan'], 404);
    }
          return response()->json($matkul);
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
        'jurusan_id' => 'required|exists:jurusans,id',
        'matkul' => 'required|string',
    ]);

    $matkul = Matkul::find($id);

    if (!$matkul) {
        return response()->json(['message' => 'Data tidak ditemukan'], 404);
    }

    $matkul->update($request->all());

    return response()->json(['message' => 'Matkul berhasil diedit', 'data' => $matkul], 200);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $matkul = matkul::find($id);
    if (!$matkul) {
        return response()->json(['message' => 'Data tidak ditemukan'], 404);
    }
    $matkul->delete();
    return response()->json('Matkul berhasil dihapus', 200);
    }
}
