<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiDosen extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Dosen::all();
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

    $dosen = Dosen::create([
        'nama' => $request->nama,
        'jenis_kelamin' => $request->jenis_kelamin,
        'nim' => $request->nim,
        'foto' => $filePath ?? null,
    ]);

    return response()->json('Dosen berhasil ditambahkan', 200);
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
    public function update(Request $request, string $id)
    {
        $dosen = Dosen::findOrFail($id);

        $validatedData = $request->validate([
            'nama' => 'required|string',
            'jenis_kelamin' => 'required|string',
            'nim' => 'required|unique:mahasiswas,nim,'.$id,
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($dosen->foto && Storage::disk('public')->exists($dosen->foto)) {
                Storage::disk('public')->delete($dosen->foto);
            }
            $filename = time() . '_' . $request->file('foto')->getClientOriginalName();
            $filePath = $request->file('foto')->storeAs('uploads', $filename, 'public');
            $validatedData['foto'] = $filePath;
        }

        $dosen->fill($validatedData)->save();

        return response()->json([
            'message' => 'Dosen berhasil diperbarui',
            'data' => $dosen->refresh()
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dosen = Dosen::find($id);

    if (!$dosen) {
        return response()->json(['error' => 'Dosen tidak ditemukan'], 404);
    }

    if ($dosen->foto && Storage::disk('public')->exists($dosen->foto)) {
        Storage::disk('public')->delete($dosen->foto);
    }

    $dosen->delete();

    return response()->json('Dosen berhasil dihapus', 200);

    }
}
