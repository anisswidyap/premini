<?php

namespace App\Models;

use App\Http\Controllers\MahasiswaMatkulController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
