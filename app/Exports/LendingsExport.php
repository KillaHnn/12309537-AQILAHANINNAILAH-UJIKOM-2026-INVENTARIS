<?php

namespace App\Exports;

use App\Models\Lending;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LendingsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Lending::with(['item', 'user'])->latest()->get();
    }

    /**
     * Header kolom di Excel.
     */
    public function headings(): array
    {
        return [
            'No',
            'Item Name',
            'Total',
            'Borrower Name',
            'Notes',
            'Lending Date',
            'Status',
            'Staff In Charge',
        ];
    }

    /**
     * Mapping data ke baris Excel.
     */
    public function map($lending): array
    {
        static $no = 1;
        return [
            $no++,
            $lending->item->name,
            $lending->total,
            $lending->name,
            $lending->notes ?? '-',
            \Carbon\Carbon::parse($lending->lending_date)->format('d M Y H:i'),
            $lending->is_returned ? 'Returned' : '-',
            $lending->user->name ?? 'System',
        ];
    }
}
