<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CategoryExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Category::with('items')->get()->map(function ($category) {
            return [
                'name' => $category->name,
                'division_pj' => $category->division_pj,
                'total_items' => $category->items_count, // Menggunakan accessor untuk menghitung total barang
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Name',
            'Division PJ',
            'Total Items',
        ];
    }

    public function map($category): array
    {
        return [
            $category->name,
            $category->division_pj,
            $category->items_count, // Menampilkan total barang di kategori ini
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $rowCount = Category::count();
        $range = 'A1:C' . ($rowCount + 1);

        // Bold header
        $sheet->getStyle('A1:C1')->getFont()->setBold(true);

        // Border untuk semua sel
        $sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    }
}
