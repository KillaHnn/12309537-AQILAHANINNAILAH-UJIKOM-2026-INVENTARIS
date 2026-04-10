<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class UsersExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $role;

    public function __construct($role = null)
    {
        $this->role = $role;
    }

    /**
     * Mengambil data users (dengan filter role jika ada).
     */
    public function collection()
    {
        $query = User::query();
        
        if ($this->role) {
            $query->where('role', $this->role);
        }

        return $query->latest()->get();
    }

    /**
     * Menentukan header kolom di Excel.
     */
    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Password',
        ];
    }

    /**
     * Memetakan data model ke baris Excel.
     */
    public function map($user): array
    {
        return [
            $user->name,
            $user->email,
            $user->initial_password ?? 'This account already edited the password',
        ];
    }

    /**
     * Memberikan styling pada sheet.
     */
    public function styles(Worksheet $sheet)
    {
        $rowCount = User::count();
        $range = 'A1:E' . ($rowCount + 1);

        return [
            // Bold headings
            1 => ['font' => ['bold' => true]],

            // Add borders
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
