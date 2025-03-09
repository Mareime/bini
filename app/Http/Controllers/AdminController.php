<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paiement;
use App\Models\Compte;
use App\Models\Beneficiaire;
use App\Models\Taxe;
use App\Models\Compteur;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Fetch data from the models
        $paiements = Paiement::all();
        $comptes = Compte::all();
        $beneficiaires = Beneficiaire::all();
        $taxes = Taxe::all();
        $compteurs = Compteur::all();
        $users = User::all();
    
        // Pass the data to the view
        return view('admin.dashboard', [
            'paiements' => $paiements,
            'comptes' => $comptes,
            'beneficiaires' => $beneficiaires,
            'taxes' => $taxes,
            'compteurs' => $compteurs,
            'users' => $users,
        ]);
    }
    

    public function compt_index()
    {
        if (auth()->guest()) {
            return redirect()->route('login');
        }
        $comptes = Compte::all();
        return view('admin.compte', compact('comptes'));
    }
    
    public function benefi_index()
    {
        if (auth()->guest()) {
            return redirect()->route('login');
        }
        $beneficiaires = Beneficiaire::all();
        return view('admin.beneficiere', compact('beneficiaires'));
    }

    public function paieme_index()
    {
        if (auth()->guest()) {
            return redirect()->route('login');
        }
        $paiements = Paiement::all();
        $comptes = Compte::all(); 
        $beneficiaires = Beneficiaire::all(); 
        return view('admin.paiment', compact('paiements','comptes','beneficiaires'));
    }

    public function taxes_index()
    {
        if (auth()->guest()) {
            return redirect()->route('login');
        }
        $taxes = Taxe::all();
        return view('admin.taxes', compact('taxes'));
    }
    public function compteure_index(){
        if (auth()->guest()) {
            return redirect()->route('login');
        }
        $compteurs=Compteur::all();
        return view('admin.annee',compact('compteurs'));

    }

    public function getStats()
{
    return response()->json([
        'comptes' => Compte::count(),
        'beneficiaires' => Beneficiaire::count(),
        'paiements' => Paiement::count(),
        'taxes' => Taxe::count(),
        'users' => User::count(),
        'id_annee' => Compte::count() // Si vous avez un modèle Compteur
    ]);
}
}

