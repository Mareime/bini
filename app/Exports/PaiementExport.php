<?php

namespace App\Exports;
use Carbon\Carbon;
use App\Models\Paiement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PaiementExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * Récupérer les paiements pour l'exportation.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Paiement::all([
            'montant',
            'date_paiement',
            'mode_paiement',
            'id_compte',
            'id_beneficiaire',
            'status',
            'motif_de_la_depence',
            'impulsion'
        ]);
    }

    /**
     * Définition des en-têtes du fichier Excel.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Montant',
            'Date de Paiement',
            'Mode de Paiement',
            'Compte',
            'Bénéficiaire',
            'Status',
            'Motif de la dépense',
            'Impulsion'
        ];
    }

    /**
     * Mapper les données pour correspondre aux en-têtes.
     *
     * @param Paiement $paiement
     * @return array
     */
    public function map($paiement): array
    {
        return [
            $paiement->montant,
            Carbon::parse($paiement->date_paiement)->format('Y-m-d'),
            $paiement->mode_paiement,
            $paiement->compte->id,
            $paiement->beneficiaire->id,
            $paiement->status,
            $paiement->motif_de_la_depence,
            $paiement->impulsion
        ];
    }
}
