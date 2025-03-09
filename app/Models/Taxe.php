<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taxe extends Model
{
    use HasFactory;

    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'taxes';

    /**
     * Les attributs assignables en masse.
     *
     * @var array
     */
    protected $fillable = [
        'nom',        // Nom de la taxe (ex: TVA, IRF, etc.)
        'pourcentage' // Pourcentage de la taxe
    ];

    /**
     * Définir les relations Many-to-Many avec Paiement (si applicable).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function paiements()
    {
        return $this->belongsToMany(Paiement::class, 'paiement_taxe', 'taxe_id', 'paiement_id');
    }
}
