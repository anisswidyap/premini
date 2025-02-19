<?php

namespace App\Models;

use App\Http\Controllers\MahasiswaMatkulController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        'jenis_kelamin',
        'nim',
        'foto'
    ];


    public function MahasiswaMatkul(): HasOne
    {
        return $this->hasOne(MahasiswaMatkul::class);
    }
}
