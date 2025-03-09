<?php
// App\Models\Beneficiaire.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficiaire extends Model
{
    use HasFactory;

    protected $table = 'beneficiaire';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'adresse',
        'type_beneficiaire',
    ];

    // Définir la relation hasMany avec Paiement
    public function paiements()
    {
        return $this->hasMany(Paiement::class, 'id_beneficiaire');
    }
}
