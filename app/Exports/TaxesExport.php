<?php

namespace App\Exports;

use App\Models\Taxe;
use Maatwebsite\Excel\Concerns\FromCollection;

class TaxesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Taxe::all([ 'nom',
        'pourcentage' ,]);
    }
    public function headings(): array
    {
        return [
            'Nom','Pourcentage'
        ];
    }
}
