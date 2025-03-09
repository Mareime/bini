<?php

namespace App\Imports;

use App\Models\Paiement;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PaiementImport implements ToModel, WithHeadingRow
{
    /**
     * Mapper les données du fichier Excel et les enregistrer dans la base de données.
     *
     * @param array $row
     * @return \App\Models\Paiement|null
     */
    public function model(array $row)
    {
        // Vérification du montant
        $montant = is_numeric($row['montant']) ? $row['montant'] : 0;

        // Vérification et formatage de la date
        try {
            $datePaiement = Carbon::parse($row['date_de_paiement'])->format('Y-m-d');
        } catch (\Exception $e) {
            $datePaiement = now()->format('Y-m-d'); // Mettre la date du jour si erreur
        }

        // Récupérer l'année du paiement
        $annee = date('Y', strtotime($datePaiement));

        // Démarrer une transaction pour garantir l'intégrité des données
        DB::beginTransaction();

        try {
            // Sélectionner et verrouiller la ligne correspondante dans la table `compteur`
            $compteur = DB::table('compteur')
                ->where('annee', $annee)
                ->lockForUpdate() // Verrouiller la ligne pour éviter les conflits
                ->first();

            if (!$compteur) {
                // Si l'année n'existe pas dans la table `compteur`, la créer avec un compteur initialisé à 1
                $id_compt = 1;
                DB::table('compteur')->insert([
                    'annee' => $annee,
                    'compteur' => $id_compt,
                ]);
            } else {
                // Incrémenter le compteur de manière sûre
                $id_compt = $compteur->compteur + 1;
            }

            // Insérer le paiement avec le nouvel `id_compt`
            Paiement::create([
                'montant' => $montant,
                'date_paiement' => $datePaiement,
                'mode_paiement' => $row['mode_de_paiement'] ?? null,
                'id_compte' => $row['compte'] ?? null,
                'id_beneficiaire' => $row['beneficiaire'] ?? null,
                'status' => $row['status'] ?? 'en attente',
                'motif_de_la_depence' => $row['motif_de_la_depense'] ?? 'Motif non spécifié',
                'impulsion' => $row['impulsion'] ?? null,
                'id_compt' => $id_compt, // Associer l'id_compt
            ]);

            // Mettre à jour le compteur dans la table `compteur`
            DB::table('compteur')
                ->where('annee', $annee)
                ->update(['compteur' => $id_compt]);

            // Valider la transaction
            DB::commit();
        } catch (\Exception $e) {
            // En cas d'erreur, annuler la transaction
            DB::rollBack();
            throw $e;  // Re-throw the exception to handle it outside this method
        }

        // Retourner null car cette fonction ne crée pas d'objet Paiement mais gère l'insertion
        return null;
    }
}
