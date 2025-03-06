<?php

namespace App\Http\Controllers;

use App\Http\Resources\MahasiswaResource;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiMahasiswa extends Controller
{
    public function index(Request $request)
    {
        $query = Mahasiswa::with('jurusan');

        if ($request->has('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $data = $query->get();
        return MahasiswaResource::collection($data);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string',
            'jurusan_id' => 'required|exists:jurusans,id',
            'jenis_kelamin' => 'required|string',
            'nim' => 'required|unique:mahasiswas,nim',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $filename, 'public');
        }

        $mahasiswa = Mahasiswa::create([
            'nama' => $validatedData['nama'],
            'jurusan_id' => $validatedData['jurusan_id'],
            'jenis_kelamin' => $validatedData['jenis_kelamin'],
            'nim' => $validatedData['nim'],
            'foto' => $filePath,
        ]);

        return response()->json([
            'message' => 'Mahasiswa berhasil ditambahkan',
            'data' => new MahasiswaResource($mahasiswa),
            'image_url' => $filePath ? asset('storage/' . $filePath) : null
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        $validatedData = $request->validate([
            'nama' => 'sometimes|required|string',
            'jurusan_id' => 'required|exists:jurusans,id',
            'jenis_kelamin' => 'sometimes|required|string',
            'nim' => 'sometimes|required|unique:mahasiswas,nim,' . $id,
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            // Pastikan variabel yang dicek adalah mahasiswa, bukan dosen
            if (!empty($mahasiswa->foto)) {
                if (Storage::disk('public')->exists($mahasiswa->foto)) {
                    Storage::disk('public')->delete($mahasiswa->foto);
                }
            }

            $filename = time() . '_' . $request->file('foto')->getClientOriginalName();
            $filePath = $request->file('foto')->storeAs('uploads', $filename, 'public');
            $validatedData['foto'] = $filePath;
        }

        $mahasiswa->update($validatedData);

        return response()->json([
            'message' => 'Mahasiswa berhasil diperbarui',
            'data' => new MahasiswaResource($mahasiswa->refresh()),
            'image_url' => $mahasiswa->foto ? asset('storage/' . $mahasiswa->foto) : null
        ], 200);
    }

    public function show(string $id)
    {
        $mahasiswa = Mahasiswa::with('jurusan')->find($id);

        if (!$mahasiswa) {
            return response()->json(['error' => 'Mahasiswa tidak ditemukan'], 404);
        }

        return response()->json(new MahasiswaResource($mahasiswa), 200);
    }

    public function destroy(string $id)
    {
        $mahasiswa = Mahasiswa::find($id);

        if (!$mahasiswa) {
            return response()->json(['error' => 'Mahasiswa tidak ditemukan'], 404);
        }

        if ($mahasiswa->mahasiswaMatkul()->exists()) {
            return response()->json([
                'error' => 'Mahasiswa tidak dapat dihapus karena masih memiliki relasi.'
            ], 400);
        }

        if ($mahasiswa->foto && Storage::disk('public')->exists($mahasiswa->foto)) {
            Storage::disk('public')->delete($mahasiswa->foto);
        }

        $mahasiswa->delete();

        return response()->json(['message' => 'Mahasiswa berhasil dihapus'], 200);
    }
}
