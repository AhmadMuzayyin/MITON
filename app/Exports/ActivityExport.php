<?php

namespace App\Exports;

use App\Models\Activity;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class ActivityExport implements FromCollection, WithMapping 
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Activity::with('sumber_dana')->with('pengadaan')->with('pelaksanaan')->with('anggaran')->with('pak')->get();
    }

    public function map($activity): array
    {
        return [
            $activity->rek,
            $activity->kegiatan,
            $activity->nama,
            $activity->sumber_dana->nama,
            $activity->pengadaan->nama,
            $activity->pelaksanaan->nama,
            // $activity->anggaran
            $activity->pak->nama,
            session()->get('kondisi') == 0 ? 'Sebelum PAK' : 'Setelah PAK'
        ];
    }
}
