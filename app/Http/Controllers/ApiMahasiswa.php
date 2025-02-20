<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiMahasiswa extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Mahasiswa::all();
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
        $validatedData = $request->validate([
            'nama' => 'required|string',
            'jenis_kelamin' => 'required|string',
            'nim' => 'required|unique:mahasiswas,nim',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
        $file = $request->file('foto');
        $filename = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('uploads', $filename, 'public');
        }

        $mahasiswa = Mahasiswa::create([
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'nim' => $request->nim,
            'foto' => $filePath ?? null,
        ]);

        return response()->json('Mahasiswa berhasil ditambahkan', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, $id)
{
    $mahasiswa = Mahasiswa::findOrFail($id);

    $validatedData = $request->validate([
        'nama' => 'sometimes|required|string',
        'jenis_kelamin' => 'sometimes|required|string',
        'nim' => 'sometimes|required|unique:mahasiswas,nim,',
        'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
    ]);

    if ($request->hasFile('foto')) {
        if ($mahasiswa->foto && Storage::disk('public')->exists($mahasiswa->foto)) {
            Storage::disk('public')->delete($mahasiswa->foto);
        }
        $filename = time() . '_' . $request->file('foto')->getClientOriginalName();
        $filePath = $request->file('foto')->storeAs('uploads', $filename, 'public');
        $validatedData['foto'] = $filePath;
    }

    $mahasiswa->fill($validatedData)->save();

    return response()->json([
        'message' => 'Mahasiswa berhasil diperbarui',
        'data' => $mahasiswa->refresh()
    ], 200);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mahasiswa = Mahasiswa::find($id);

    if (!$mahasiswa) {
        return response()->json(['error' => 'Mahasiswa tidak ditemukan'], 404);
    }

    if ($mahasiswa->foto && Storage::disk('public')->exists($mahasiswa->foto)) {
        Storage::disk('public')->delete($mahasiswa->foto);
    }

    $mahasiswa->delete();

    return response()->json('Mahasiswa berhasil dihapus', 200);

    }
}
