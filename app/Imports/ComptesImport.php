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
        $date_creation = null;
    
      
        if (isset($row['date_de_creation'])) {
            $date_creation = Carbon::parse($row['date_de_creation']);
        }
    
        return new Compte([
            'numero' => $row['numero_du_compte'],  
            'type_compte' => $row['type_de_compte'],  
            'solde' => $row['solde'], 
            'date_creation' => $date_creation,  
            'description' => $row['description'] ?? null,  
        ]);
    }
    
    
}
