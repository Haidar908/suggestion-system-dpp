<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Suggestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SuggestionsExport;

class SuggestionController extends Controller
{
    /**
     * Display a listing of the suggestions.
     */
    public function index(Request $request)
    {
        // Memulai query dasar
        $query = Suggestion::query();

        // [BARU] Cek jika ada input tanggal start dan end
        if ($request->filled('start_date') && $request->filled('end_date')) {
            // Validasi sederhana
            $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ]);

            // Terapkan filter whereBetween ke query
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        // Terapkan urutan dan paginasi ke query yang sudah difilter (atau yang belum jika tidak ada filter)
        $suggestions = $query->orderBy('created_at', 'asc')->paginate(10);

        // Penting: agar link paginasi tetap membawa parameter filter
        $suggestions->appends($request->query());

        // Kirim data ke view
        return view('admin.suggestions.index', compact('suggestions'));
    }

    /**
     * Display the specified suggestion.
     */
    public function show(Suggestion $suggestion)
    {
        return view('admin.suggestions.show', compact('suggestion'));
    }

    /**
     * Update the specified suggestion in storage.
     */
    public function update(Request $request, Suggestion $suggestion)
    {
        $request->validate([
            'nilai_ss' => 'nullable|integer|min:0|max:100',
            'hasil_perbaikan_gambar_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'diperiksa_oleh' => 'nullable|string|max:255',
            'disetujui_oleh' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('hasil_perbaikan_gambar_file')) {
            if ($suggestion->hasil_perbaikan_gambar) {
                Storage::disk('public')->delete($suggestion->hasil_perbaikan_gambar);
            }
            $hasilPerbaikanPath = $request->file('hasil_perbaikan_gambar_file')->store('suggestion_images/hasil_perbaikan', 'public');
            $suggestion->hasil_perbaikan_gambar = $hasilPerbaikanPath;
        }

        $suggestion->nilai_ss = $request->nilai_ss;
        $suggestion->diperiksa_oleh = $request->diperiksa_oleh;
        $suggestion->disetujui_oleh = $request->disetujui_oleh;
        $suggestion->save();

        return redirect()->route('admin.suggestions.show', $suggestion->id)->with('success', 'Suggestion berhasil diperbarui oleh admin!');
    }

    /**
     * Remove the specified suggestion from storage.
     */
    public function destroy(Suggestion $suggestion)
    {
        // Hapus gambar terkait sebelum menghapus suggestion
        if ($suggestion->kondisi_semula_gambar) {
            Storage::disk('public')->delete($suggestion->kondisi_semula_gambar);
        }
        if ($suggestion->perbaikan_gambar) {
            Storage::disk('public')->delete($suggestion->perbaikan_gambar);
        }
        if ($suggestion->hasil_perbaikan_gambar) {
            Storage::disk('public')->delete($suggestion->hasil_perbaikan_gambar);
        }

        $suggestion->delete();

        return redirect()->route('admin.suggestions.index')->with('success', 'Suggestion berhasil dihapus!');
    }
    
    /**
     * [BARU] Remove multiple suggestions from storage.
     */
    public function bulkDestroy(Request $request)
    {
        // 1. Validasi input untuk memastikan 'ids' adalah array yang valid
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:suggestions,id',
        ]);

        $idsToDelete = $request->input('ids');

        // 2. Ambil semua data suggestion yang akan dihapus
        $suggestionsToDelete = Suggestion::whereIn('id', $idsToDelete)->get();

        // 3. Loop untuk menghapus semua gambar yang terkait dengan setiap suggestion
        foreach ($suggestionsToDelete as $suggestion) {
            if ($suggestion->kondisi_semula_gambar) {
                Storage::disk('public')->delete($suggestion->kondisi_semula_gambar);
            }
            if ($suggestion->perbaikan_gambar) {
                Storage::disk('public')->delete($suggestion->perbaikan_gambar);
            }
            if ($suggestion->hasil_perbaikan_gambar) {
                Storage::disk('public')->delete($suggestion->hasil_perbaikan_gambar);
            }
        }

        // 4. Hapus data dari database dalam satu query
        Suggestion::whereIn('id', $idsToDelete)->delete();

        return redirect()->route('admin.suggestions.index')->with('success', 'Suggestion yang dipilih berhasil dihapus!');
    }


    /**
     * Export suggestions data to an Excel file.
     */
    public function exportExcel(Request $request)
    {
        // [BARU] Validasi input tanggal
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // [BARU] Nama file dinamis berdasarkan tanggal
        $fileName = 'laporan_suggestions_' . $startDate . '_to_' . $endDate . '.xlsx';

        // [DIUBAH] Kirim tanggal ke class export saat dieksekusi
        return Excel::download(new SuggestionsExport($startDate, $endDate), $fileName);
    }
}