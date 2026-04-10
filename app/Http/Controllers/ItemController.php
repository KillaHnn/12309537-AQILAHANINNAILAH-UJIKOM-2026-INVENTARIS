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
        // Validasi input dari form
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

        // Membuat record item baru di database
        Item::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'total' => $request->total,
            'repair' => 0,
            'lending' => 0,
        ]);

        // Redirect kembali ke halaman daftar items dengan pesan sukses
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
        // Validasi input: memastikan jumlah kerusakan baru minimal 0
        $request->validate([
            'new_broke_item' => 'sometimes|integer|',
            'new_total' => 'sometimes|integer|min:0',
        ], [
            'new_broke_item.integer' => 'Jumlah barang rusak baru harus berupa angka.',
            'new_broke_item.min' => 'Jumlah barang rusak baru tidak boleh kurang dari 0.',
            'new_total.integer' => 'Jumlah total harus berupa angka.',
            'new_total.min' => 'Jumlah total tidak boleh kurang dari 0.',
        ]);

        $updateData = [];

        // Handle new total update if provided
        if ($request->filled('new_total')) {
            $newTotal = (int) $request->new_total;
            $updateData['total'] = max(0, $newTotal);
        }

        // Handle new broke item update if provided
        if ($request->filled('new_broke_item')) {
            $newBroke = (int) $request->new_broke_item;
            $updateData['repair'] = $item->repair + $newBroke;
            // Only subtract from total if no new_total provided
            if (!isset($updateData['total'])) {
                $updateData['total'] = $item->total - $newBroke;
            }
        }

        if (!empty($updateData)) {
            $item->update($updateData);
        }

        // Build success message
        $message = 'Data berhasil diperbarui!';
        if ($request->filled('new_broke_item')) {
            $newBroke = (int) $request->new_broke_item;
            $message = 'Data kerusakan barang berhasil diperbarui! (+' . $newBroke . ' item rusak)';
        }
        if ($request->filled('new_total')) {
            $newTotal = (int) $request->new_total;
            $message = 'Total barang berhasil diperbarui menjadi ' . $newTotal . ' item!';
        }

        return redirect()->route('admin.items.index')
            ->with('success', $message);
    }

    /**
     * Menghapus barang dari database.
     * Mencari item berdasarkan ID lalu menghapus record tersebut.
     */
    public function destroy(Item $item)
    {
        // Menghapus data item dari database
        $item->delete();

        // Redirect kembali dengan pesan sukses
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
