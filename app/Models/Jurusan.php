<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jurusan extends Model
{
    use HasFactory;

    protected $guarded =[
        'id'
    ];

    protected $fillable = [
        'jurusan',
        'fakultas_id'
    ];

    protected $table = 'jurusans';

    public function fakultas(): BelongsTo
    {
        return $this->belongsTo(Fakultas::class);
    }

    public function Mahasiswa(): hasMany
    {
        return $this->hasMany(Mahasiswa::class);
    }

    public function Dosen(): hasMany
    {
        return $this->hasMany(Dosen::class);
    }

    public function Matkul(): HasMany
    {
        return $this->hasMany(Matkul::class);
    }
}
