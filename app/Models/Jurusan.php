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
        'fakultas_id'
    ];

    public function MataKuliah(): HasMany
    {
        return $this->hasMany(MataKuliah::class);
    }

    public function DosenMatkul(): HasMany
    {
        return $this->hasMany(DosenMatkul::class);
    }


}
