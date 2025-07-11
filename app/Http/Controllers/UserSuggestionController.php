<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suggestion;
use App\Models\Department;
use App\Models\AccessCode; // [BARU] Import model AccessCode
use Illuminate\Support\Facades\Storage;

class UserSuggestionController extends Controller
{
    /**
     * [BARU] Memproses verifikasi kode akses dari pop-up (AJAX).
     */
    public function verifyAccessCode(Request $request)
    {
        $request->validate(['access_code' => 'required|string']);

        $accessCode = AccessCode::where('code', $request->access_code)
                                ->where('is_active', true)
                                ->first();

        if ($accessCode) {
            // Jika kode ditemukan dan aktif, kirim respon sukses dalam format JSON
            return response()->json(['success' => true]);
        }

        // Jika tidak, kirim respon gagal dengan pesan dalam format JSON
        return response()->json(['success' => false, 'message' => 'Kode akses tidak valid atau tidak aktif.'], 401);
    }

    /**
     * Menampilkan form utama untuk membuat suggestion.
     */
    public function create()
    {
        // Fungsi ini tidak berubah
        $departments = Department::orderBy('nama_departemen', 'asc')->get();
        return view('suggestions.create', compact('departments'));
    }

    /**
     * Menyimpan data suggestion baru dari form.
     */
    public function store(Request $request)
    {
        // Fungsi ini tidak berubah
        $request->validate([
            'nama' => 'required|string|max:255',
            'npk' => 'required|string|digits:8',
            'department_id' => 'required|exists:departments,id',
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

        $kondisiSemulaPath = $request->hasFile('kondisi_semula_gambar_file') ? $request->file('kondisi_semula_gambar_file')->store('suggestion_images/kondisi_semula', 'public') : null;
        $perbaikanPath = $request->hasFile('perbaikan_gambar_file') ? $request->file('perbaikan_gambar_file')->store('suggestion_images/perbaikan', 'public') : null;
        $hasilPerbaikanPath = $request->hasFile('hasil_perbaikan_gambar_file') ? $request->file('hasil_perbaikan_gambar_file')->store('suggestion_images/hasil_perbaikan', 'public') : null;

        Suggestion::create([
            'nama' => $request->nama,
            'npk' => $request->npk,
            'department_id' => $request->department_id,
            'line_bag' => $request->line_bag,
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