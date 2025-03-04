<?php

namespace App\Http\Controllers;

use App\Http\Resources\MahasiswaResource;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ApiMahasiswa extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Mahasiswa::with('jurusan');

        if ($request->has('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $data = $query->get();
        return MahasiswaResource::collection($data);
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
            'jurusan_id' => 'required|exists:jurusans,id',
            'jenis_kelamin' => 'required|string',
            'nim' => 'required|unique:mahasiswas,nim',
            'foto' =>'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $filename, 'public');
        }

        $mahasiswa = Mahasiswa::create([
            'nama' => $request->nama,
            'jurusan_id' => $request->jurusan_id,
            'jenis_kelamin' => $request->jenis_kelamin,
            'nim' => $request->nim,
            'foto' => $filename ?? null,
        ]);

        return response()->json([
            'message' => 'Mahasiswa berhasil ditambahkan',
            'data' => new MahasiswaResource($mahasiswa),
            'image_url' => $filename ? asset('storage/' . $filename) : null
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mahasiswa = Mahasiswa::with('jurusan')->find($id);

        if (!$mahasiswa) {
            return response()->json(['error' => 'Mahasiswa tidak ditemukan'], 404);
        }

        return response()->json(new MahasiswaResource($mahasiswa), 200);
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
            'jurusan_id' => 'sometimes|required|exists:jurusans,id',
            'jenis_kelamin' => 'sometimes|required|string',
            'nim' => 'sometimes|required|unique:mahasiswas,nim,' . $id,
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if (!empty($mahasiswa->foto)) {
                $fotoLama = $mahasiswa->foto;
                Log::info('Mengecek file: ' . $fotoLama);

                if (Storage::disk('public')->exists($fotoLama)) {
                    Storage::disk('publick')->delete($fotoLama);
                    Log::info('File berhasil di hapus: ' . $fotoLama);
                } else {
                    Log::info('file tidak di temukan: ' . $fotoLama);
                }
            }

            $filename = time() . '_' . $request->file('foto')->getClientOriginalName();
            $filePath = $request->file('foto')->storeAs('uploads', $filename, 'public');

            $validatedData['foto'] = 'uploads/' . $filename;
        }

        $mahasiswa->update($validatedData);

        return response()->json([
            'message' => 'Mahasiswa berhasil diperbarui',
            'data' => new MahasiswaResource($mahasiswa->refresh()),
            'image_url' => $filePath ? asset('storage/' . $filePath) : null
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

    if ($mahasiswa->mahasiswaMatkul()->exists()) {
        return response()->json([
            'error' => 'Mahasiswa tidak dapat dihapus karena masih dimiliki mahasiswamatkul.'
        ], 400);
    }

    $deletedMahasiswa = new MAhasiswaResource($mahasiswa);

    if ($mahasiswa->foto && Storage::disk('public')->exists($mahasiswa->foto)) {
        Storage::disk('public')->delete($mahasiswa->foto);
    }

    $mahasiswa->delete();

    return response()->json('Mahasiswa berhasil dihapus', 200);
}

}
