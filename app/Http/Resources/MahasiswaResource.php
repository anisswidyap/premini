<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MahasiswaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nama' => $this->nama,
            'jurusan' => $this->jurusan->jurusan ?? 'Tidak Ada',
            'jenis_kelamin' => $this->jenis_kelamin,
            'nim' => $this->nim,
            'foto' => $this->foto,
        ];
    }
}
