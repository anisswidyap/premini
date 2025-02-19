<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Fakultas extends Model
{
    use HasFactory;

    protected $guarded =[
        'id'
    ];

    protected $fillable = [
        'nama_fakultas',
    ];


    public function Jurusan(): HasOne
    {
        return $this->hasOne(Jurusan::class);
    }
}
