<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_departemen',
    ];

    /**
     * [BARU] Mendefinisikan relasi ke model Suggestion.
     */
    public function suggestions()
    {
        return $this->hasMany(Suggestion::class);
    }
}