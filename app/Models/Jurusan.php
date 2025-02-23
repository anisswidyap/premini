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

    public $table = 'jurusans';

    public function Mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class);
    }

    public function Dosen()
    {
        return $this->hasMany(Dosen::class);
    }

    public function Matkul(): HasMany
    {
        return $this->hasMany(Matkul::class);
    }

    public function fakultas(): BelongsTo
    {
        return $this->belongsTo(Fakultas::class);
    }

}
