<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class ApiDosen extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Dosen::with(['jurusan'])->get();
        return response()->json($data);
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
            'nidn' => 'required|unique:dosens,nidn',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $filename, 'public');
        }

        $dosen = Dosen::create([
            'nama' => $request->nama,
            'jurusan_id' => $request->jurusan_id,
            'jenis_kelamin' => $request->jenis_kelamin,
            'nidn' => $request->nidn,
            'foto' => $filePath ?? null,
        ]);

        return response()->json('Dosen berhasil ditambahkan', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $dosen = Dosen::findOrFail($id);

        $validatedData = $request->validate([
            'nama' => 'sometimes|required|string',
            'jurusan_id' => 'required|exists:jurusans,id',
            'jenis_kelamin' => 'sometimes|required|string',
            'nidn' => 'sometimes|required|unique:dosens,nidn,' . $id,
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            // Debugging: Log path foto lama
            Log::info("Foto lama:", ["path" => "uploads/" . $dosen->foto]);
            Log::info("File exists:", ["exists" => Storage::disk("public")->exists("uploads/" . $dosen->foto)]);



            // Hapus foto lama jika ada
            if (!empty($dosen->foto) && Storage::disk('public')->exists('uploads/' . $dosen->foto)) {
                Storage::disk('public')->delete('uploads/' . $dosen->foto);
                \Log::info('Foto lama berhasil dihapus.');
            } else {
                \Log::info("message");::info('Foto lama tidak ditemukan atau tidak bisa dihapus.');
            }

            // Upload foto baru
            $filename = time() . '_' . $request->file('foto')->getClientOriginalName();
            $filePath = $request->file('foto')->storeAs('uploads', $filename, 'public');

            $validatedData['foto'] = $filename;
        }


        if (!empty($validatedData)) {
            $dosen->update($validatedData);
        }

        return response()->json([
            'message' => 'Dosen berhasil diperbarui',
            'data' => $dosen->refresh(),
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

        // Cek apakah dosen masih memiliki mata kuliah di tabel dosen_matkul
        if ($dosen->dosenMatkul()->exists()) {
            return response()->json([
                'error' => 'Dosen tidak dapat dihapus karena masih di miliki dosenmatkul.'
            ], 400);
        }

        // Hapus foto jika ada
        if ($dosen->foto && Storage::disk('public')->exists($dosen->foto)) {
            Storage::disk('public')->delete($dosen->foto);
        }

        $dosen->delete();

        return response()->json('Dosen berhasil dihapus', 200);
    }
}
