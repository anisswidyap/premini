<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $guarded =[
        'id'
    ];

    protected $fillable = [
        'nama',
        'jurusan_id',
        'jenis_kelamin',
        'nim',
        'foto'
    ];

    public function Jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function MahasiswaMatkul(): BelongsToMany
    {
        return $this->belongsToMany(MahasiswaMatkul::class);
    }
}
