<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccessCode;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AccessCodeController extends Controller
{
    /**
     * Menampilkan daftar semua kode akses.
     */
    public function index()
    {
        // Mengurutkan berdasarkan data terlama, sehingga data baru ada di bawah
        $accessCodes = AccessCode::orderBy('created_at', 'asc')->paginate(15);
        return view('admin.access_codes.index', compact('accessCodes'));
    }

    /**
     * Menampilkan form untuk membuat kode akses baru.
     */
    public function create()
    {
        return view('admin.access_codes.create');
    }

    /**
     * Menyimpan kode akses baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|min:6|unique:access_codes',
            'description' => 'nullable|string|max:255',
        ]);

        AccessCode::create([
            'code' => $request->code,
            'description' => $request->description,
            'is_active' => $request->has('is_active'), // Checkbox is_active
        ]);

        return redirect()->route('admin.access_codes.index')
                         ->with('success', 'Kode akses baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit kode akses.
     */
    public function edit(AccessCode $accessCode)
    {
        return view('admin.access_codes.edit', compact('accessCode'));
    }

    /**
     * Memperbarui data kode akses di database.
     */
    public function update(Request $request, AccessCode $accessCode)
    {
        $request->validate([
            'code' => [
                'required',
                'string',
                'min:6',
                Rule::unique('access_codes')->ignore($accessCode->id),
            ],
            'description' => 'nullable|string|max:255',
        ]);

        $accessCode->update([
            'code' => $request->code,
            'description' => $request->description,
            'is_active' => $request->has('is_active'), // Checkbox is_active
        ]);

        return redirect()->route('admin.access_codes.index')
                         ->with('success', 'Kode akses berhasil diperbarui.');
    }

    /**
     * Menghapus kode akses dari database.
     */
    public function destroy(AccessCode $accessCode)
    {
        $accessCode->delete();

        return redirect()->route('admin.access_codes.index')
                         ->with('success', 'Kode akses berhasil dihapus.');
    }
}