<?php

namespace App\Http\Controllers;

use App\Exports\CategoryExport;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CategoryController extends Controller
{
    /**
     * Menampilkan daftar semua kategori.
     * Mengambil seluruh data dari tabel categories dan mengirimnya ke view.
     */
    public function index()
    {
        // Mengambil semua data kategori beserta total item di masing-masing kategori
        $categories = Category::withCount('items')->latest()->get();

        // Mengirim data kategori ke halaman view admin.categories.index
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Menyimpan kategori baru ke database.
     * Memvalidasi input lalu membuat record baru di tabel categories.
     */
    public function store(Request $request)
    {
        // Validasi input dari form, pastikan nama dan divisi diisi
        $request->validate([
            'name' => 'required|string|max:255',
            'division_pj' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'division_pj.required' => 'Divisi penanggung jawab wajib diisi.',
        ]);

        // Membuat record kategori baru di database
        Category::create([
            'name' => $request->name,
            'division_pj' => $request->division_pj,
        ]);

        // Redirect kembali ke halaman daftar kategori dengan pesan sukses
        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Memperbarui data kategori yang sudah ada.
     * Mencari kategori berdasarkan ID, memvalidasi input, lalu meng-update record.
     */
    public function update(Request $request, Category $category)
    {
        // Validasi input dari form edit
        $request->validate([
            'name' => 'required|string|max:255',
            'division_pj' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'division_pj.required' => 'Divisi penanggung jawab wajib diisi.',
        ]);

        // Memperbarui data kategori di database
        $category->update([
            'name' => $request->name,
            'division_pj' => $request->division_pj,
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Menghapus kategori dari database.
     * Mencari kategori berdasarkan ID lalu menghapus record tersebut.
     */
    public function destroy(Category $category)
    {
        // Menghapus data kategori dari database
        $category->delete();

        // Redirect kembali dengan pesan sukses
        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }

    public function export()
    {
        return Excel::download(new CategoryExport, 'categories.xlsx');
    }
}
