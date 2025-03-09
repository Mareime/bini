<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compte extends Model
{
    use HasFactory;
    protected $table = 'compte';

    protected $dates = ['date_creation'];
    
    protected $fillable = [
        'numero',
        'type_compte',
        'solde',
        'date_creation',
        'description',
    ];

}
