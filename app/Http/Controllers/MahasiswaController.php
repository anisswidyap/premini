<?php

namespace App\Http\Controllers;

use App\Http\Resources\MahasiswaResource;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{

    public function index()
    {
        return response()->json(Mahasiswa::all());
    }

    public function show($id)
{
    $mahasiswa = Mahasiswa::find($id);
    if (!$mahasiswa) {
        return response()->json(['message' => 'Mahasiswa tidak ditemukan'], 404);
    } else {
        return new MahasiswaResource($mahasiswa);
    }
}

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'jenis_kelamin' => 'required|string',
            'nim' => 'required|string|unique:mahasiswas',
            'foto' => 'required|image|mimes:png,jpg,jpeg,svg,webp',
        ],[
            'nama.required' => 'Nama Harus Diisi',
            'jenis_kelamin.required' => 'Jenis Kelamin Harus diisi',
            'nim.required' => 'NIM harus diisi',
            'nim.unique' => 'NIM tidak boleh sama',
            'foto.required' => 'Foto harus diisi',
            'foto.mimes' => 'Foto harus berbentuk png,jpg,jpeg,svg,webp'
        ]);

        try {
            $fotoPath = $request->file('foto')->store('public/fotos');
            $fotoUrl = Storage::url($fotoPath);

            $mahasiswa = Mahasiswa::create([
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'nim' => $request->nim,
                'foto' => $fotoUrl,
            ]);

            return response()->json([
                'message' => 'Mahasiswa berhasil ditambahkan',
                'data' => $mahasiswa
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menambahkan mahasiswa',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $request->validate([
            'nama' => 'required|string',
            'jenis_kelamin' => 'required|string',
            'nim' => 'required|string|unique:mahasiswas,nim,' . $mahasiswa->id,
            'foto' => 'nullable|image|mimes:png,jpg,jpeg,svg,webp',
        ]);

        try {
            // Update foto hanya jika ada file foto yang dikirim
            if ($request->hasFile('foto')) {
                if ($mahasiswa->foto) {
                    // Hapus foto lama jika ada
                    Storage::delete(str_replace('/storage', 'public', $mahasiswa->foto));
                }
                // Simpan foto baru
                $fotoPath = $request->file('foto')->store('public/fotos');
                $fotoUrl = Storage::url($fotoPath);
                $mahasiswa->foto = $fotoUrl;
            }

            // Update data mahasiswa selain foto
            $mahasiswa->update([
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'nim' => $request->nim,
                // Tidak perlu memasukkan 'foto' di sini karena sudah ditangani di atas
            ]);

            return response()->json([
                'message' => 'Mahasiswa berhasil diperbarui',
                'data' => $mahasiswa
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui mahasiswa',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        try {
            if ($mahasiswa->foto) {
                Storage::delete(str_replace('/storage', 'public', $mahasiswa->foto));
            }

            $mahasiswa->delete();
            return response()->json([
                'message' => 'Mahasiswa berhasil dihapus'
            ], 204);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus mahasiswa',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
