<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;
    protected $dates = ['date_paiement'];
    protected $guarded = ['id']; 
    protected $primaryKey = 'id';
    protected $table = 'paiement';
    protected $fillable = [
        'montant',
        'date_paiement',
        'mode_paiement',
        'id_compte',
        'id_beneficiaire',
        'status',
        'impulsion'
    ];

    public function compte()
{
    return $this->belongsTo(Compte::class, 'id_compte');
}
public function beneficiaire()
{
    return $this->belongsTo(Beneficiaire::class, 'id_beneficiaire');
}
public function taxes()
{
    return $this->belongsToMany(Taxe::class, 'paiement_taxe', 'paiement_id', 'taxe_id');
}

}
