<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Matkul extends Model
{
    use HasFactory;

    protected $guarded =[
        'id'
    ];

    protected $fillable = [
        'jurusan_id',
        'matkul'
    ];

    public function DosenMatkul(): hasMany
    {
        return $this->hasMany(DosenMatkul::class);
    }

    public function MahasiswaMatkul(): hasMany
    {
        return $this->hasMany(Matkul::class);
    }

    public function Jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class);
    }

}
