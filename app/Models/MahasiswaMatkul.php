<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MahasiswaMatkul extends Model
{
    use HasFactory;

    protected $guarded =[
        'id'
    ];

    protected $fillable = [
        'mahasiswa_id',
        'matkul_id'
    ];

    public function Matkul(): BelongsTo
    {
        return $this->belongsTo(Matkul::class);
    }

    public function Mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class);
    }

}
