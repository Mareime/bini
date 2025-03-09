<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            display: flex;
            height: 100vh;
            margin: 0;
            background-color: #f8f9fa;
            overflow: hidden;
        }
        .sidebar {
            width: 250px;
            background: linear-gradient(180deg, #343a40, #212529);
            color: white;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 2px 0px 10px rgba(0,0,0,0.1);
        }
        .sidebar h2 a {
            color: white;
            text-decoration: none;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .nav-links {
            flex-grow: 1;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 12px;
            margin: 5px 0;
            border-radius: 5px;
            transition: background 0.3s, transform 0.2s;
        }
        .sidebar a i {
            margin-right: 10px;
        }
        .sidebar a:hover {
            background: #495057;
            transform: scale(1.05);
        }
        .logout {
            margin-top: auto;
            background: #dc3545;
            text-align: center;
            font-weight: bold;
            padding: 12px;
            border-radius: 5px;
            transition: background 0.3s, transform 0.2s;
        }
        .logout:hover {
            background: #c82333;
            transform: scale(1.05);
        }
        .content {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
            background-color: #fff;
        }
        .card {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
        }
        .card-body {
            text-align: center;
        }
        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .card-text {
            font-size: 2.5rem;
            font-weight: 600;
        }
        .badge-custom {
            font-size: 1.2rem;
            margin-left: 10px;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
            }
            .content {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="nav-links">
            <h2><a href="{{ route('admin.dashboard')}}">Dashboard</a></h2>
            <a href="{{ route('admin.compt_index')}}"><i class="fas fa-wallet"></i> Comptes</a>
            <a href="{{ route("admin.benefi_index")}}"><i class="fas fa-users"></i> Bénéficiaires</a>
            <a href="{{route("admin.paieme_index")}}"><i class="fas fa-credit-card"></i> Paiements</a>
            <a href="{{route("admin.taxes_index")}}"><i class="fas fa-money-bill-wave"></i> Taxes</a>
            <a href="{{route('admin.compteure_index')}}"><i class="fas fa-calendar-alt"></i> Année/id</a>
            <a href="{{route("admin.users")}}"><i class="fas fa-users-cog"></i> Utilisateurs</a>
        </div>
        <a class="logout" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
    </div>
    <div>
    </div>
    <div class="content" id="content">
        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#importPaiementModal">Importer</button>

        <div class="container">
            <h1>Liste des Paiements</h1>
            
            <button class="btn btn-warning"><a href="{{ route('paiements.export') }}" class="btn btn-success">Exporter</a></button>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPaiementModal">Ajouter un Paiement</button>
            <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#importPaiementModal">Importer des Paiements</button>
            {{-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#eddPaiementModal">Ajouter un Paiement</button> --}}
            @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

            <table class="table mt-4">
                    <!-- Barre de recherche -->
    <div class="mb-3">
        <div class="input-group">
            <input type="text" id="searchInput" class="form-control" placeholder="Rechercher un paiement..." onkeyup="searchPaiements()">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
        </div>
    </div>
    <table class="table mt-4">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Montant</th>
                        <th>Date de Paiement</th>
                        <th>Mode de Paiement</th>
                        <th>Compte</th>
                        <th>Bénéficiaire</th>
                        <th>Status</th>
                        <th>Motif de la dépense</th>
                        <th>Impulsion</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="paiements-list">
                    @foreach ($paiements as $paiement)
                    <tr class="paiement-item" data-id="{{ $paiement->id }}">
                        <th>{{ $paiement->id }}</th>
                        <td>{{ $paiement->montant }}</td>
                        <td>{{ \Carbon\Carbon::parse($paiement->date_paiement)->format('Y-m-d') }}</td>
                        <td>{{ $paiement->mode_paiement }}</td>
                        <td>{{ $paiement->id_compte }}</td>
                        <td>{{ $paiement->id_beneficiaire }}</td>
                        <td>{{ $paiement->status }}</td>
                        <td>{{ $paiement->motif_de_la_depence }}</td>
                        <td>{{ $paiement->impulsion }}</td>
                        <td>
                            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $paiement->id }}">
                                Modifier
                            </a>
                            <div class="modal fade" id="editModal{{ $paiement->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $paiement->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel{{ $paiement->id }}">Modifier le Paiement</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                        </div>
                            
                                        <div class="modal-body">
                                            <form action="{{ route('paiements.update1', $paiement->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                            
                                                <div class="mb-3">
                                                    <label for="montant{{ $paiement->id }}" class="form-label">Montant</label>
                                                    <input type="number" step="0.01" class="form-control" id="montant{{ $paiement->id }}" name="montant" value="{{ old('montant', $paiement->montant) }}" required>
                                                </div>
                            
                                                <div class="mb-3">
                                                    <label for="mode_paiement{{ $paiement->id }}" class="form-label">Mode de Paiement</label>
                                                    <select class="form-control" id="mode_paiement{{ $paiement->id }}" name="mode_paiement" required>
                                                        <option value="carte" {{ $paiement->mode_paiement == 'carte' ? 'selected' : '' }}>Carte</option>
                                                        <option value="virement" {{ $paiement->mode_paiement == 'virement' ? 'selected' : '' }}>Virement</option>
                                                        <option value="cheque" {{ $paiement->mode_paiement == 'cheque' ? 'selected' : '' }}>Chèque</option>
                                                        <option value="espèces" {{ $paiement->mode_paiement == 'espèces' ? 'selected' : '' }}>Espèces</option>
                                                    </select>
                                                </div>
                            
                                                <div class="mb-3">
                                                    <label for="id_compte{{ $paiement->id }}" class="form-label">Compte</label>
                                                <select class="form-control" id="id_compte" name="id_compte" required>
                                                    @foreach ($comptes as $compte)
                                                        <option value="{{ $compte->id }}" @if($compte->id == $paiement->id_compte) selected @endif>{{ $compte->numero }}</option>
                                                    @endforeach
                                                </select>
                                                    </select>
                                                </div>
                            
                                                <div class="mb-3">
                                                    <label for="id_beneficiaire{{ $paiement->id }}" class="form-label">Bénéficiaire</label>
                                                    <select class="form-control" id="id_beneficiaire{{ $paiement->id }}" name="id_beneficiaire" required>
                                                        @foreach($beneficiaires as $beneficiaire)
                                                            <option value="{{ $beneficiaire->id }}" {{ $paiement->id_beneficiaire == $beneficiaire->id ? 'selected' : '' }}>
                                                                {{ $beneficiaire->nom }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                            
                                                <div class="mb-3">
                                                    <label for="status{{ $paiement->id }}" class="form-label">Statut</label>
                                                    <select class="form-control" id="status{{ $paiement->id }}" name="status" required>
                                                        <option value="en attente" {{ $paiement->status == 'en attente' ? 'selected' : '' }}>En attente</option>
                                                        <option value="réussi" {{ $paiement->status == 'réussi' ? 'selected' : '' }}>Réussi</option>
                                                        <option value="échoué" {{ $paiement->status == 'échoué' ? 'selected' : '' }}>Échoué</option>
                                                    </select>
                                                </div>
                            
                                                <div class="mb-3">
                                                    <label for="motif_de_la_depence{{ $paiement->id }}" class="form-label">Motif de la Dépense</label>
                                                    <input type="text" class="form-control" id="motif_de_la_depence{{ $paiement->id }}" name="motif_de_la_depence" value="{{ old('motif_de_la_depence', $paiement->motif_de_la_depence) }}" required>
                                                </div>
                            
                                                <div class="mb-3">
                                                    <label for="impulsion{{ $paiement->id }}" class="form-label">Impulsion</label>
                                                    <select class="form-control" id="impulsion{{ $paiement->id }}" name="impulsion" required>
                                                        <option value="TVA" {{ $paiement->impulsion == 'TVA' ? 'selected' : '' }}>TVA</option>
                                                        <option value="IMF" {{ $paiement->impulsion == 'IMF' ? 'selected' : '' }}>IMF</option>
                                                        <option value="loyer" {{ $paiement->impulsion == 'loyer' ? 'selected' : '' }}>Loyer</option>
                                                        <option value="Exonéré" {{ $paiement->impulsion == 'Exonéré' ? 'selected' : '' }}>Exonéré</option>
                                                    </select>
                                                </div>
                            
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <a href="{{ route('paiements.show', $paiement->id) }}" class="btn btn-primary">Voir</a>
                            <form action="{{ route('paiements.destroy1', $paiement->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce paiement ?')">
                                    Supprimer
                                </button>
                            </form>
                            
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
{{-- kkkkkkkkk --}}
    <!-- Modal Ajouter un Paiement -->
    <div class="modal fade" id="addPaiementModal" tabindex="-1" aria-labelledby="addPaiementModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPaiementModalLabel">Ajouter un Paiement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('paiements.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="montant" class="form-label">Montant</label>
                            <input type="number" class="form-control @error('montant') is-invalid @enderror" id="montant" name="montant" required value="{{ old('montant') }}">
                            @error('montant')
                            <div class="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="date_paiement">Date de Paiement</label>
                            <input type="date" class="form-control @error('date_paiement') is-invalid @enderror" id="date_paiement" name="date_paiement" value="{{ old('date_paiement', \Carbon\Carbon::now()->format('Y-m-d')) }}">
                            @error('date_paiement')
                                <div class="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="mode_paiement">Mode de Paiement</label>
                            <select class="form-control @error('mode_paiement') is-invalid @enderror" id="mode_paiement" name="mode_paiement" required>
                                <option value="carte" @if(old('mode_paiement') == 'carte') selected @endif>Carte</option>
                                <option value="virement" @if(old('mode_paiement') == 'virement') selected @endif>Virement</option>
                                <option value="cheque" @if(old('mode_paiement') == 'cheque') selected @endif>Chèque</option>
                                <option value="espèces" @if(old('mode_paiement') == 'espèces') selected @endif>Espèces</option>
                            </select>
                            @error('mode_paiement')
                                <div class="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="id_compte">Compte</label>
                            <select class="form-control @error('id_compte') is-invalid @enderror" id="id_compte" name="id_compte" required>
                                @foreach ($comptes as $compte)
                                    <option value="{{ $compte->id }}" @if(old('id_compte') == $compte->id) selected @endif>{{ $compte->numero }}</option>
                                @endforeach
                            </select>
                            @error('id_compte')
                                <div class="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="id_beneficiaire">Bénéficiaire</label>
                            <select class="form-control @error('id_beneficiaire') is-invalid @enderror" id="id_beneficiaire" name="id_beneficiaire" required>
                                @foreach ($beneficiaires as $beneficiaire)
                                    <option value="{{ $beneficiaire->id }}" @if(old('id_beneficiaire') == $beneficiaire->id) selected @endif>{{ $beneficiaire->nom }} {{ $beneficiaire->prenom }}</option>
                                @endforeach
                            </select>
                            @error('id_beneficiaire')
                                <div class="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="status">Statuts</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="en attente" @if(old('status') == 'en attente') selected @endif>En attente</option>
                                <option value="réussi" @if(old('status') == 'réussi') selected @endif>Réussi</option>
                                <option value="échoué" @if(old('status') == 'échoué') selected @endif>Échoué</option>
                            </select>
                            @error('status')
                                <div class="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="motif_de_la_depence">Motif de la dépense</label>
                            <input type="text" class="form-control @error('motif_de_la_depence') is-invalid @enderror" id="motif_de_la_depence" name="motif_de_la_depence" required value="{{ old('motif_de_la_depence') }}">
                            @error('motif_de_la_depence')
                                <div class="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="impulsion">Impulsion</label>
                            <select class="form-control @error('impulsion') is-invalid @enderror" id="impulsion" name="impulsion" required>
                                <option value="">-- Choisissez --</option>
                                <option value="TVA" @if(old('impulsion') == 'TVA') selected @endif>TVA</option>
                                <option value="IMF" @if(old('impulsion') == 'IMF') selected @endif>IMF</option>
                                <option value="loyer" @if(old('impulsion') == 'loyer') selected @endif>Loyer</option>
                                <option value="Exonéré" @if(old('impulsion') == 'Exonéré') selected @endif>Exonéré</option>
                            </select>
                            @error('impulsion')
                                <div class="alert">{{ $message }}</div>
                             @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


{{-- 
    <div class="modal fade" id="editModal{{ $paiement->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $paiement->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel{{ $paiement->id }}">Modifier le Paiement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
    
                <div class="modal-body">
                    <form action="{{ route('paiements.update1', $paiement->id) }}" method="POST">
                        @csrf
                        @method('PUT')
    
                        <div class="mb-3">
                            <label for="montant{{ $paiement->id }}" class="form-label">Montant</label>
                            <input type="number" step="0.01" class="form-control" id="montant{{ $paiement->id }}" name="montant" value="{{ old('montant', $paiement->montant) }}" required>
                        </div>
    
                        <div class="mb-3">
                            <label for="mode_paiement{{ $paiement->id }}" class="form-label">Mode de Paiement</label>
                            <select class="form-control" id="mode_paiement{{ $paiement->id }}" name="mode_paiement" required>
                                <option value="carte" {{ $paiement->mode_paiement == 'carte' ? 'selected' : '' }}>Carte</option>
                                <option value="virement" {{ $paiement->mode_paiement == 'virement' ? 'selected' : '' }}>Virement</option>
                                <option value="cheque" {{ $paiement->mode_paiement == 'cheque' ? 'selected' : '' }}>Chèque</option>
                                <option value="espèces" {{ $paiement->mode_paiement == 'espèces' ? 'selected' : '' }}>Espèces</option>
                            </select>
                        </div>
    
                        <div class="mb-3">
                            <label for="id_compte{{ $paiement->id }}" class="form-label">Compte</label>
                            <select class="form-control" id="id_compte{{ $paiement->id }}" name="id_compte" required>
                                @foreach($comptes as $compte)
                                    <option value="{{ $compte->id }}" {{ $paiement->id_compte == $compte->id ? 'selected' : '' }}>
                                        {{ $compte->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
    
                        <div class="mb-3">
                            <label for="id_beneficiaire{{ $paiement->id }}" class="form-label">Bénéficiaire</label>
                            <select class="form-control" id="id_beneficiaire{{ $paiement->id }}" name="id_beneficiaire" required>
                                @foreach($beneficiaires as $beneficiaire)
                                    <option value="{{ $beneficiaire->id }}" {{ $paiement->id_beneficiaire == $beneficiaire->id ? 'selected' : '' }}>
                                        {{ $beneficiaire->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
    
                        <div class="mb-3">
                            <label for="status{{ $paiement->id }}" class="form-label">Statut</label>
                            <select class="form-control" id="status{{ $paiement->id }}" name="status" required>
                                <option value="en attente" {{ $paiement->status == 'en attente' ? 'selected' : '' }}>En attente</option>
                                <option value="réussi" {{ $paiement->status == 'réussi' ? 'selected' : '' }}>Réussi</option>
                                <option value="échoué" {{ $paiement->status == 'échoué' ? 'selected' : '' }}>Échoué</option>
                            </select>
                        </div>
    
                        <div class="mb-3">
                            <label for="motif_de_la_depence{{ $paiement->id }}" class="form-label">Motif de la Dépense</label>
                            <input type="text" class="form-control" id="motif_de_la_depence{{ $paiement->id }}" name="motif_de_la_depence" value="{{ old('motif_de_la_depence', $paiement->motif_de_la_depence) }}" required>
                        </div>
    
                        <div class="mb-3">
                            <label for="impulsion{{ $paiement->id }}" class="form-label">Impulsion</label>
                            <select class="form-control" id="impulsion{{ $paiement->id }}" name="impulsion" required>
                                <option value="TVA" {{ $paiement->impulsion == 'TVA' ? 'selected' : '' }}>TVA</option>
                                <option value="IMF" {{ $paiement->impulsion == 'IMF' ? 'selected' : '' }}>IMF</option>
                                <option value="loyer" {{ $paiement->impulsion == 'loyer' ? 'selected' : '' }}>Loyer</option>
                                <option value="Exonéré" {{ $paiement->impulsion == 'Exonéré' ? 'selected' : '' }}>Exonéré</option>
                            </select>
                        </div>
    
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Modal Importer des Paiements -->
    <div class="modal fade" id="importPaiementModal" tabindex="-1" aria-labelledby="importPaiementModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importPaiementModalLabel">Importer des Paiements</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('paiements.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label">Choisir un fichier CSV</label>
                            <input type="file" class="form-control" id="file" name="file" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Importer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function searchPaiements() {
            let input = document.getElementById("searchInput").value.toLowerCase();
            let rows = document.querySelectorAll("#paiements-list .paiement-item");
            rows.forEach(row => {
                let text = row.innerText.toLowerCase();
                if (text.includes(input)) {
                    row.style.display = ""; 
                } else {
                    row.style.display = "none"; 
                }
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 