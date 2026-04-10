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
        // Tambahkan 'operatorIn' (relasi baru yang kita buat di model)
        // Load: item, operatorOut=user_id (who lent), operatorIn=user_id_return (who received return)
        $lendings = Lending::with(['item', 'operatorOut', 'operatorIn'])->latest()->get();
        $items = Item::all();

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

        // Validasi Stok untuk Semua Item
        foreach ($itemIds as $index => $id) {
            $item = Item::findOrFail($id);
            // Available = Total - Repair (Lending tidak dikurangi lagi karena sudah memotong Total)
            $available = $item->total - $item->repair;

            if ($totals[$index] > $available) {
                return back()->with('error', 'Total item more than available!')->withInput();
            }
        }

        // Simpan Data (Bulk)
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
            'return_date' => now(),
            // SELESAIKAN CASE: Mencatat siapa yang memproses pengembalian
            'user_id_return' => auth()->id(),
        ]);

        // Update stok: Tambah kembali ke Total, Kurangi Lending
        $lending->item->increment('total', $lending->total);
        $lending->item->decrement('lending', $lending->total);

        // Pesan sukses yang lebih informatif
        return back()->with('success', 'Item returned and verified by ' . auth()->user()->name);
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
        $lendings = Lending::where('item_id', $item->id)->with(['item', 'operatorOut', 'operatorIn'])->latest()->get();
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
