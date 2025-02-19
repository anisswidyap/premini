<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DosenMatkul extends Model
{
    use HasFactory;

    protected $guarded =[
        'id'
    ];

    protected $fillable = [
        'dosen_id',
        'jurusan_id',
        'matkul_id'
    ];

    public function Dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class);
    }


    public function matkul(): BelongsTo
    {
        return $this->belongsTo(matkul::class);
    }

    public function Jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class);
    }
}
