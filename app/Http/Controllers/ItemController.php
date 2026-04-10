<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Exports\ItemsExport;
use Maatwebsite\Excel\Facades\Excel;

class ItemController extends Controller
{
    /**
     * Menampilkan daftar semua barang.
     * Mengambil data items beserta relasi category-nya, lalu mengirim ke view.
     */
    public function index()
    {
        // Mengambil semua data item beserta kategori-nya, diurutkan dari yang terbaru
        $items = Item::with('category')->latest()->get();

        // Mengambil semua kategori untuk dropdown di form Add/Edit
        $categories = Category::all();

        // Mengirim data ke halaman view sesuai role
        if (auth()->user()->role == 'admin') {
            return view('admin.items.index', compact('items', 'categories'));
        }

        return view('staff.items.index', compact('items', 'categories'));
    }

    /**
     * Menyimpan barang baru ke database.
     * Memvalidasi input lalu membuat record baru di tabel items.
     */
    public function store(Request $request)
    {
        // 1. Validasi input dari form
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'total' => 'required|integer|min:0',
        ], [
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'name.required' => 'Nama barang wajib diisi.',
            'total.required' => 'Jumlah total wajib diisi.',
            'total.integer' => 'Jumlah total harus berupa angka.',
            'total.min' => 'Jumlah total tidak boleh kurang dari 0.',
        ]);

        // 2. Membuat record item baru di database
        Item::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'total' => $request->total,
            'repair' => 0,
            'lending' => 0,
        ]);

        // 3. Redirect kembali ke halaman daftar items dengan pesan sukses
        return redirect()->route('admin.items.index')
            ->with('success', 'Barang berhasil ditambahkan!');
    }

    /**
     * Memperbarui data barang (khusus menambah jumlah barang rusak / repair).
     * 
     * Logika:
     * - Form edit hanya mengirimkan field "new_broke_item" (jumlah kerusakan baru).
     * - Nilai new_broke_item akan DITAMBAHKAN ke kolom repair yang sudah ada.
     * - Contoh: repair saat ini = 2, new_broke_item = 1 → repair baru = 2 + 1 = 3.
     */
    public function update(Request $request, Item $item)
    {
        // 1. Validasi input: memastikan jumlah kerusakan baru minimal 0
        $request->validate([
            'total' => 'required|integer|min:0',
            'new_broke_item' => 'required|integer|min:0',
        ], [
            'new_broke_item.required' => 'Jumlah barang rusak baru wajib diisi.',
            'new_broke_item.integer' => 'Jumlah harus berupa angka.',
            'new_broke_item.min' => 'Jumlah tidak boleh kurang dari 0.',
        ]);

        // 2. Mengambil jumlah kerusakan baru dari form
        $newBroke = (int) $request->new_broke_item;

        // Menambahkan jumlah kerusakan baru ke repair yang sudah ada (akumulasi)
        $item->update([
            'total' => $request->total,
            'repair' => $item->repair + $newBroke,
            'total' => $item->total - $newBroke,
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->route('admin.items.index')
            ->with('success', 'Data kerusakan barang berhasil diperbarui! (+' . $newBroke . ' item rusak)');
    }

    /**
     * Menghapus barang dari database.
     * Mencari item berdasarkan ID lalu menghapus record tersebut.
     */
    public function destroy(Item $item)
    {
        // 1. Menghapus data item dari database
        $item->delete();

        // 2. Redirect kembali dengan pesan sukses
        return redirect()->route('admin.items.index')
            ->with('success', 'Barang berhasil dihapus!');
    }
    /**
     * Mengekspor data barang ke file Excel.
     */
    public function exportExcel()
    {
        return Excel::download(new ItemsExport, 'items.xlsx');
    }
}
