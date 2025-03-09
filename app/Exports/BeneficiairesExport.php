<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Beneficiaire;
use Maatwebsite\Excel\Concerns\WithHeadings;
class BeneficiairesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Beneficiaire::all([ 'nom',
        'prenom',
        'adresse',
        'telephone',
        'email',
        'type_beneficiaire']);
        //
    }
     /**
     * Définit les en-têtes de colonne pour le fichier Excel exporté.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
        'nom',
        'prenom',
        'adresse',
        'telephone',
        'email',
        'type_beneficiaire'
        ];
    }
}
