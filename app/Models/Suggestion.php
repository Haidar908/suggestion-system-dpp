<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'npk',
        'line_bag',
        'department_id', // [BARU] Tambahkan ini
        'tema',
        'kriteria',
        'is_new_idea',
        'kondisi_semula_text',
        'kondisi_semula_gambar',
        'perbaikan_text',
        'perbaikan_gambar',
        'tujuan_perbaikan',
        'hasil_perbaikan_gambar',
        'nilai_ss',
        'dibuat_oleh',
        'tanggal_pelaksanaan',
        'diperiksa_oleh',
        'disetujui_oleh',
    ];

    protected $casts = [
        'is_new_idea' => 'boolean',
    ];

    /**
     * [BARU] Mendefinisikan relasi ke model Department.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}