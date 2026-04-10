<?php

namespace App\Http\Controllers;

use App\Models\Lending;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Exports\LendingsExport;
use Maatwebsite\Excel\Facades\Excel;

class LendingController extends Controller
{
    /**
     * Menampilkan daftar semua peminjaman.
     */
    public function index()
    {
        $lendings = Lending::with(['item', 'user'])->latest()->get();
        $items = Item::all(); // Untuk dropdown di modal Add

        return view('staff.lending.index', compact('lendings', 'items'));
    }

    /**
     * Menyimpan data peminjaman baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|array',
            'item_id.*' => 'exists:items,id',
            'name' => 'required|string|max:255',
            'total' => 'required|array',
            'total.*' => 'integer|min:1',
            'notes' => 'nullable|string',
            'lending_date' => 'required|date',
        ]);

        $itemIds = $request->item_id;
        $totals = $request->total;

        // 1. Validasi Stok untuk Semua Item
        foreach ($itemIds as $index => $id) {
            $item = Item::findOrFail($id);
            // Available = Total - Repair (Lending tidak dikurangi lagi karena sudah memotong Total)
            $available = $item->total - $item->repair;
            
            if ($totals[$index] > $available) {
                return back()->with('error', 'Total item more than available!')->withInput();
            }
        }

        // 2. Simpan Data (Bulk)
        foreach ($itemIds as $index => $id) {
            $item = Item::findOrFail($id);
            
            Lending::create([
                'item_id' => $id,
                'name' => $request->name,
                'total' => $totals[$index],
                'notes' => $request->notes,
                'lending_date' => $request->lending_date,
                'is_returned' => false,
                'user_id' => auth()->id(),
            ]);

            // Update stok: Kurangi Total, Tambah Lending
            $item->decrement('total', $totals[$index]);
            $item->increment('lending', $totals[$index]);
        }

        return back()->with('success', 'Success add new lending item!');
    }

    /**
     * Menandai barang telah dikembalikan.
     */
    public function returnItem(Lending $lending)
    {
        if ($lending->is_returned) {
            return back()->with('error', 'Barang sudah dikembalikan sebelumnya.');
        }

        $lending->update([
            'is_returned' => true,
            'return_date' => now()
        ]);

        // Update stok: Tambah kembali ke Total, Kurangi Lending
        $lending->item->increment('total', $lending->total);
        $lending->item->decrement('lending', $lending->total);

        return back()->with('success', 'Item is returned!');
    }

    /**
     * Menghapus data peminjaman.
     */
    public function destroy(Lending $lending)
    {
        // Jika belum dikembalikan, kembalikan stoknya dulu sebelum dihapus
        if (!$lending->is_returned) {
            $lending->item->increment('total', $lending->total);
            $lending->item->decrement('lending', $lending->total);
        }

        $lending->delete();

        return back()->with('success', 'Success deleted one data lending!');
    }

    /**
     * Menampilkan detail peminjaman untuk satu barang spesifik (Untuk Admin).
     */
    public function showItemLendings(Item $item)
    {
        $lendings = Lending::where('item_id', $item->id)->with('user')->latest()->get();
        return view('admin.items.lending', compact('item', 'lendings'));
    }

    /**
     * Mengekspor data peminjaman ke Excel.
     */
    public function exportExcel()
    {
        return Excel::download(new LendingsExport, 'lendings.xlsx');
    }
}
