<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class controleruser extends Controller
{

    public function profil()
{
    $user = auth()->user(); // Récupérer l'utilisateur connecté
    return view('Navbar.index'); 
}
  
    public function showLoginForm()
    {
        // Assurez-vous que la vue connexion.connexion existe
        return view('welcome');
    }


    public function home()
    {
        return view("connexion.home");
    }
    
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
    
        
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('userc');
        }

        return back()->withErrors([
            'email' => 'Les informations de connexion sont incorrectes.',
        ]);
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Vous avez été déconnecté avec succès.');
    }

    public function index()
{
    if (auth()->guest()) {
        return redirect()->route('login');
    }
    $users = User::all();
    return view('users.index', compact('users'));
}


public function create()
{
    if(Auth::user()->isAdmin()){
        return view('users.create');
    }
    
}
public function edit($id)
{
    // Trouver l'utilisateur par son ID
    if(Auth::user()->isAdmin()){
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }
    
}
public function destroy($id)
{
    if(Auth::user()->isAdmin()){
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Utilisateur supprimé avec succès.');
    }
    
}
public function store(Request $request)
{
    // Validation des champs
    if(Auth::user()->isAdmin()){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:user,admin',
        ]);
    
    

    // Création de l'utilisateur
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
    ]);

    // Rediriger avec un message de succès
    return redirect()->route('admin.users')->with('success', 'Utilisateur créé avec succès.');
    }
}
public function update(Request $request, $id)
{
    // Trouver l'utilisateur
    if(Auth::user()->isAdmin()){

    
    $user = User::findOrFail($id);

    // Validation des champs
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|min:6',
        'role' => 'required|in:user,admin',
    ]);

    // Mise à jour des données
    $user->name = $request->name;
    $user->email = $request->email;
    $user->role = $request->role;

    // Si un mot de passe est fourni, on le met à jour
    if ($request->password) {
        $user->password = Hash::make($request->password);
    }

    // Sauvegarder les changements
    $user->save();

    // Rediriger avec un message de succès
    return redirect()->route('admin.users')->with('success', 'Utilisateur mis à jour avec succès.');
    }
}
public function users_index(){
    if (auth()->guest()) {
        return redirect()->route('login');
    }
    $users = User::all();
    return view('admin.users', compact('users'));
}

}
