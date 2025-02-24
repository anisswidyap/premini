<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Dosen extends Model
{
    use HasFactory;

    protected $guarded =[
        'id'
    ];

    protected $fillable = [
        'nama',
        'jurusan_id',
        'jenis_kelamin',
        'nidn',
        'foto'
    ];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function DosenMatkul(): BelongsToMany
    {
        return $this->belongsToMany(DosenMatkul::class);
    }
}
