<?php
namespace App\Imports;

use App\Models\Compte;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ComptesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Vérifie si la date de création est présente dans la ligne
        if (empty($row['date_de_creation'])) {
            // Si la date de création est manquante, ignore cette ligne
            return null;
        }

        // Initialisation de la date de création
        $date_creation = null;

        // Vérifie si la date est un numéro Excel (valeur numérique)
        if (is_numeric($row['date_de_creation'])) {
            // Convertit le numéro Excel en DateTime
            $date_creation = Date::excelToDateTimeObject($row['date_de_creation']);
        } else {
            // Sinon, essaie de convertir la date sous forme de texte avec Carbon
            try {
                $date_creation = Carbon::parse($row['date_de_creation']);
            } catch (\Exception $e) {
                // Si la date ne peut pas être parsée, retourne null (on ignorera la ligne)
                return null;
            }
        }

        // Crée et retourne l'objet Compte avec les données
        return new Compte([
            'numero' => $row['numero_du_compte'],  
            'type_compte' => $row['type_de_compte'],  
            'solde' => $row['solde'], 
            'date_creation' => $date_creation,  // Utilise la date correctement formatée
            'description' => $row['description'] ?? null,  
        ]);
    }
}
