<?php

namespace App\Imports;

use App\Models\Taxe;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class TaxesImport implements ToCollection
{
    /**
     * Traite chaque ligne du fichier importé.
     *
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            if (
                isset($row[0]) && 
                isset($row[1]) && 
                is_numeric($row[1]) && 
                $row[1] >= 0 && $row[1] <= 100 
            ) {
               
                Taxe::create([
                    'nom' => $row[0], 
                    'pourcentage' => (float) $row[1], 
                ]);
            }
        }
    }
}
