<?php

namespace App\Exports;

use App\Models\Suggestion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SuggestionsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    // [BARU] Properti untuk menyimpan rentang tanggal
    protected $startDate;
    protected $endDate;

    // [BARU] Constructor untuk menerima tanggal dari Controller
    public function __construct(string $startDate, string $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // [DIUBAH] Query sekarang menggunakan whereBetween untuk memfilter berdasarkan created_at
        return Suggestion::with('department')
                    ->whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59'])
                    ->get();
    }

    /**
     * Menentukan judul kolom (tidak ada perubahan).
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nama Pengusul',
            'NPK',
            'Departemen',
            'Line/Bagian',
            'Kriteria Tema',
            'Tema SS / Ide Perbaikan',
            'Status Ide',
            'Diajukan Pada', // Tambahan kolom tanggal untuk verifikasi
        ];
    }

    /**
     * Memetakan data (tidak ada perubahan).
     * @param mixed $suggestion
     * @return array
     */
    public function map($suggestion): array
    {
        $lokasi = $suggestion->department->nama_departemen ?? '';
        if (!empty($suggestion->line_bag)) {
            $lokasi .= ($lokasi ? ' - ' : '') . $suggestion->line_bag;
        }

        return [
            $suggestion->id,
            $suggestion->nama,
            $suggestion->npk,
            $suggestion->department->nama_departemen ?? '-',
            $suggestion->line_bag ?? '-',
            $suggestion->kriteria,
            $suggestion->tema,
            $suggestion->is_new_idea ? 'Ide Baru' : 'Ide Lama/Mencontoh',
            $suggestion->created_at->format('Y-m-d H:i'), // Tambahan kolom tanggal untuk verifikasi
        ];
    }
}