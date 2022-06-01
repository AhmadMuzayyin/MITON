<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithMapping, WithHeadings
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::all();
    }
    public function headings(): array
    {
        return [
            'Kode SKPD',
            'Nama SKPD',
            'Nama Operator',
            'Username',
            'No Telepon Operator',
            'No Telepon Kantor',
            'Alamat Kantor',
            'Nama KPA',
            'Level'
        ];
    }
    public function map($row): array
    {
        return [
            $row->kode_SKPD,
            $row->nama_SKPD,
            $row->nama_operator,
            $row->username,
            $row->no_hp,
            $row->no_kantor,
            $row->alamat_kantor,
            $row->nama_KPA,
            $row->isAdmin == 0 ? 'Operator' : 'Admin'
        ];
    }
}
