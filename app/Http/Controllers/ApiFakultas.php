<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use Illuminate\Http\Request;

class ApiFakultas extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = Fakultas::query();

    if ($request->has('search')) {
        $query->where('nama_fakultas', 'like', '%' . $request->search . '%');
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
        Fakultas::create($request->all());
        return response()->json('Fakultas berhasil ditambahkan', 200);
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
        $fakultas = Fakultas::find($id);
        $fakultas->update($request->all());
        return response()->json('Fakultas berhasil diedit', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $fakultas = Fakultas::find($id);
        $fakultas->delete();
        return response()->json('Fakultas berhasil dihapus', 200);
    }
}
