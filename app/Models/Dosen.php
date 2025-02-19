<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Dosen extends Model
{
    use HasFactory;

    protected $guarded =[
        'id'
    ];

    protected $fillable = [
        'nama',
        'jenis_kelamin',
        'nidn',
        'foto'
    ];


    public function DosenMatkul(): HasOne
    {
        return $this->hasOne(DosenMatkul::class);
    }
}
