<?php
namespace App\Exports;

use App\Models\Compte;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ComptesExport implements FromCollection, WithHeadings
{
    /**
     * Récupère toutes les données à exporter.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Récupère toutes les données des comptes depuis la base de données
        return Compte::all(['numero', 'type_compte', 'solde', 'date_creation', 'description']);
    }

    /**
     * Définit les en-têtes de colonne pour le fichier Excel exporté.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Numéro du Compte',
            'Type de Compte',
            'Solde',
            'Date de Création',
            'Description'
        ];
    }
}
