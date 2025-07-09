<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{
    /**
     * Menampilkan daftar semua departemen.
     */
    public function index()
    {
        // Ini akan 100% mengurutkan berdasarkan nama departemen dari A-Z
        $departments = Department::orderBy('nama_departemen', 'asc')->paginate(10);

        return view('admin.departments.index', compact('departments'));
    }

    /**
     * Menampilkan form untuk membuat departemen baru.
     */
    public function create()
    {
        return view('admin.departments.create');
    }

    /**
     * Menyimpan departemen baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_departemen' => 'required|string|max:255|unique:departments',
        ]);

        Department::create($request->all());

        return redirect()->route('admin.departments.index')
                         ->with('success', 'Departemen baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit departemen.
     */
    public function edit(Department $department)
    {
        return view('admin.departments.edit', compact('department'));
    }

    /**
     * Memperbarui data departemen di database.
     */
    public function update(Request $request, Department $department)
    {
        $request->validate([
            'nama_departemen' => [
                'required',
                'string',
                'max:255',
                Rule::unique('departments')->ignore($department->id),
            ],
        ]);

        $department->update($request->all());

        return redirect()->route('admin.departments.index')
                         ->with('success', 'Departemen berhasil diperbarui.');
    }

    /**
     * Menghapus departemen dari database.
     */
    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()->route('admin.departments.index')
                         ->with('success', 'Departemen berhasil dihapus.');
    }
}