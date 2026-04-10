<?php

namespace App\Exports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ItemsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    /**
     * Mengambil data items beserta relasinya.
     */
    public function collection()
    {
        return Item::with('category')->get();
    }

    /**
     * Menentukan header kolom di Excel (sesuai referensi screenshot).
     */
    public function headings(): array
    {
        return [
            'Category',
            'Name Item',
            'Total',
            'Repair Total',
            'Last Updated',
        ];
    }

    /**
     * Memetakan data model ke baris Excel.
     */
    public function map($item): array
    {
        return [
            $item->category->name,
            $item->name,
            $item->total,
            // Jika repair 0, tampilkan dash '-' agar persis seperti di screenshot
            $item->repair == 0 ? '-' : $item->repair,
            // Format tanggal: Jan 14, 2023
            $item->updated_at->format('M d, Y'),
        ];
    }

    /**
     * Memberikan styling pada sheet (Bold headers dan Borders).
     */
    public function styles(Worksheet $sheet)
    {
        $rowCount = Item::count();
        $range = 'A1:E' . ($rowCount + 1);

        return [
            // Baris pertama (Headings) dibuat Bold
            1 => ['font' => ['bold' => true]],

            // Memberikan border ke seluruh cell yang ada datanya
            $range => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
            ],
        ];
    }
}
