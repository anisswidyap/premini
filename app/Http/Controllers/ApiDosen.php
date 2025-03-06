<?php

namespace App\Http\Controllers;

use App\Http\Resources\DosenResource;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ApiDosen extends Controller
{
    public function index(Request $request)
    {
        $query = Dosen::with('jurusan');

        if ($request->has('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $data = $query->get();
        return DosenResource::collection($data);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string',
            'jurusan_id' => 'required|exists:jurusans,id',
            'jenis_kelamin' => 'required|string',
            'nidn' => 'required|unique:dosens,nidn',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $filePath = null;
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
            'foto' => $filePath, // Simpan path lengkap
        ]);

        return response()->json([
            'message' => 'Dosen berhasil ditambahkan',
            'data' => new DosenResource($dosen),
            'image_url' => $filePath ? asset('storage/' . $filePath) : null
        ], 200);
    }

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
            if (!empty($dosen->foto)) {
                if (Storage::disk('public')->exists($dosen->foto)) {
                    Storage::disk('public')->delete($dosen->foto);
                }
            }

            $filename = time() . '_' . $request->file('foto')->getClientOriginalName();
            $filePath = $request->file('foto')->storeAs('uploads', $filename, 'public');
            $validatedData['foto'] = $filePath;
        }

        $dosen->update($validatedData);

        return response()->json([
            'message' => 'Dosen berhasil diperbarui',
            'data' => new DosenResource($dosen->refresh()),
            'image_url' => $dosen->foto ? asset('storage/' . $dosen->foto) : null
        ], 200);
    }

    public function show(string $id)
    {
        $dosen = Dosen::with('jurusan')->find($id);

        if (!$dosen) {
            return response()->json(['error' => 'Dosen tidak ditemukan'], 404);
        }

        return response()->json(new DosenResource($dosen), 200);
    }

    public function destroy(string $id)
    {
        $dosen = Dosen::find($id);

        if (!$dosen) {
            return response()->json(['error' => 'Dosen tidak ditemukan'], 404);
        }

        if ($dosen->dosenMatkul()->exists()) {
            return response()->json([
                'error' => 'Dosen tidak dapat dihapus karena masih memiliki relasi.'
            ], 400);
        }

        if ($dosen->foto && Storage::disk('public')->exists($dosen->foto)) {
            Storage::disk('public')->delete($dosen->foto);
        }

        $dosen->delete();

        return response()->json(['message' => 'Dosen berhasil dihapus'], 200);
    }
}
