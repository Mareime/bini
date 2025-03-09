<?php


namespace App\Imports;

use App\Models\Beneficiaire;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BeneficiairesImport implements ToCollection, WithHeadingRow
{
    /**
     * Gérer les données importées sous forme de collection.
     *
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            if (isset($row['nom'], $row['prenom'], $row['adresse'], $row['telephone'], $row['email'], $row['type_beneficiaire'])) {
                Beneficiaire::updateOrCreate(
                    ['email' => $row['email']], 
                    [
                        'nom' => $row['nom'],
                        'prenom' => $row['prenom'],
                        'adresse' => $row['adresse'],
                        'telephone' => $row['telephone'],
                        'type_beneficiaire' => $row['type_beneficiaire'],
                    ]
                );
            }
        }
    }
    
}
