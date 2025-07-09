<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suggestion;
use App\Models\Department; // Pastikan ini di-import
use Illuminate\Support\Facades\Storage;

class UserSuggestionController extends Controller
{
    /**
     * Menampilkan form dengan data departemen untuk dropdown.
     */
    public function create()
    {
        // Ambil data departemen untuk dikirim ke form
        $departments = Department::orderBy('nama_departemen', 'asc')->get();
        return view('suggestions.create', compact('departments'));
    }

    /**
     * Menyimpan data suggestion baru dari form.
     */
    public function store(Request $request)
    {
        // 1. Validasi Data
        $request->validate([
            'nama' => 'required|string|max:255',
            'npk' => 'required|string|digits:8',
            'department_id' => 'required|exists:departments,id', // Dropdown departemen wajib diisi
            'line_bag' => 'required|string|max:255', 
            'tema' => 'nullable|string',
            'kriteria' => 'required|string|max:255',
            'is_new_idea' => 'required|boolean',
            'kondisi_semula_text' => 'nullable|string',
            'kondisi_semula_gambar_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'perbaikan_text' => 'nullable|string',
            'perbaikan_gambar_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tujuan_perbaikan' => 'nullable|string',
            'hasil_perbaikan_gambar_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // 2. Proses Upload Gambar (Tidak ada perubahan)
        $kondisiSemulaPath = $request->hasFile('kondisi_semula_gambar_file') ? $request->file('kondisi_semula_gambar_file')->store('suggestion_images/kondisi_semula', 'public') : null;
        $perbaikanPath = $request->hasFile('perbaikan_gambar_file') ? $request->file('perbaikan_gambar_file')->store('suggestion_images/perbaikan', 'public') : null;
        $hasilPerbaikanPath = $request->hasFile('hasil_perbaikan_gambar_file') ? $request->file('hasil_perbaikan_gambar_file')->store('suggestion_images/hasil_perbaikan', 'public') : null;

        // 3. Simpan Data ke Database
        Suggestion::create([
            'nama' => $request->nama,
            'npk' => $request->npk,
            'department_id' => $request->department_id, // Simpan ID dari dropdown
            'line_bag' => $request->line_bag, // Simpan teks dari input Line/Bag
            'tema' => $request->tema,
            'kriteria' => $request->kriteria,
            'is_new_idea' => $request->is_new_idea,
            'kondisi_semula_text' => $request->kondisi_semula_text,
            'kondisi_semula_gambar' => $kondisiSemulaPath,
            'perbaikan_text' => $request->perbaikan_text,
            'perbaikan_gambar' => $perbaikanPath,
            'tujuan_perbaikan' => $request->tujuan_perbaikan,
            'hasil_perbaikan_gambar' => $hasilPerbaikanPath,
            'dibuat_oleh' => $request->nama,
            'tanggal_pelaksanaan' => now()->toDateString(),
        ]);

        return redirect()->back()->with('success', 'Usulan Anda berhasil dikirim!');
    }
}