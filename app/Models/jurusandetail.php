<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class jurusandetail extends Model
{
    use HasFactory;

    protected $guarded =[
        'id'
    ];

    protected $fillable = [
        'jurusan'
    ];

    public function Jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class, 'foreign_key', 'other_key');
    }


}
