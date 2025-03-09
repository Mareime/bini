<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

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

    <div class="content" id="content">
        <div class="container">
            <h2 class="mb-4">Liste des Bénéficiaires</h2>
            
            <!-- Bouton pour ouvrir la modal -->
            <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createModal">Créer un nouveau Bénéficiaire</button>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-3 d-flex justify-content-end">
                <a href="{{ route('beneficiaire.export') }}" class="btn btn-primary mr-2">Exporter</a>
                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#importModal">Importer</button>       
            </div>
              <!-- Barre de recherche -->
            <div class="mb-3">
                <div class="input-group">
                    <input type="text" id="searchInput" class="form-control" placeholder="Rechercher un bénéficiaire..." onkeyup="searchBeneficiaires()">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                </div>
            </div>
            <!-- Modal pour l'ajout d'un bénéficiaire -->
        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Ajouter un Bénéficiaire</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <form action="{{ route('beneficiaire.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nom">Nom</label>
                                <input type="text" name="nom" id="nom" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="prenom">Prénom</label>
                                <input type="text" name="prenom" id="prenom" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="adresse">Adresse</label>
                                <input type="text" name="adresse" id="adresse" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="telephone">Téléphone</label>
                                <input type="text" name="telephone" id="telephone" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="type_beneficiaire">Type de Bénéficiaire</label>
                                <select name="type_beneficiaire" id="type_beneficiaire" class="form-control" required>
                                    <option value="personne">Personne</option>
                                    <option value="entreprise">Entreprise</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-success">Ajouter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

            <!-- Modal pour l'importation -->
            <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="importModalLabel">Importer un fichier Excel (XLSX) ou CSV</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('beneficiaire.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="file">Sélectionner un fichier à importer</label>
                                    <input type="file" name="file" id="file" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-success">Importer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tableau des bénéficiaires -->
            <table class="table table-bordered table-striped" id="beneficiaireTable">
                <thead class="thead-dark">
                    <tr>
                        <th>Id</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Adresse</th>
                        <th>Téléphone</th>
                        <th>Email</th>
                        <th>Type de Bénéficiaire</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($beneficiaires as $beneficiaire)
                    <tr>
                        <td>{{ $beneficiaire->id }}</td>
                        <td>{{ $beneficiaire->nom }}</td>
                        <td>{{ $beneficiaire->prenom }}</td>
                        <td>{{ $beneficiaire->adresse }}</td>
                        <td>{{ $beneficiaire->telephone }}</td>
                        <td>{{ $beneficiaire->email }}</td>
                        <td>{{ $beneficiaire->type_beneficiaire }}</td>
                        <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $beneficiaire->id }}">
                                Modifier
                            </button>
                            
                            <form action="{{ route('beneficiaire.destroy', $beneficiaire) }}" method="POST" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce bénéficiaire ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                            </form>

                            <!-- Modal pour Modifier -->
                        <div class="modal fade" id="editModal{{ $beneficiaire->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $beneficiaire->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel{{ $beneficiaire->id }}">Modifier le Bénéficiaire</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('beneficiaire.update', $beneficiaire) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="nom">Nom</label>
                                                <input type="text" name="nom" id="nom" class="form-control" value="{{ old('nom', $beneficiaire->nom) }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="prenom">Prénom</label>
                                                <input type="text" name="prenom" id="prenom" class="form-control" value="{{ old('prenom', $beneficiaire->prenom) }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="adresse">Adresse</label>
                                                <input type="text" name="adresse" id="adresse" class="form-control" value="{{ old('adresse', $beneficiaire->adresse) }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="telephone">Téléphone</label>
                                                <input type="text" name="telephone" id="telephone" class="form-control" value="{{ old('telephone', $beneficiaire->telephone) }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $beneficiaire->email) }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="type_beneficiaire">Type de Bénéficiaire</label>
                                                <select name="type_beneficiaire" id="type_beneficiaire" class="form-control" required>
                                                    <option value="personne" {{ $beneficiaire->type_beneficiaire == 'personne' ? 'selected' : '' }}>Personne</option>
                                                    <option value="entreprise" {{ $beneficiaire->type_beneficiaire == 'entreprise' ? 'selected' : '' }}>Entreprise</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                            <button type="submit" class="btn btn-success">Mettre à jour</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function searchBeneficiaires() {
            let input = document.getElementById("searchInput").value.toLowerCase();
            let table = document.getElementById("beneficiaireTable");
            let rows = table.getElementsByTagName("tr");

            for (let i = 1; i < rows.length; i++) { // commencer à partir de 1 pour ignorer l'en-tête
                let cells = rows[i].getElementsByTagName("td");
                let found = false;

                // Vérifier si le texte dans chaque cellule correspond à la recherche
                for (let j = 0; j < cells.length; j++) {
                    if (cells[j].innerText.toLowerCase().includes(input)) {
                        found = true;
                        break;
                    }
                }

                // Afficher ou cacher la ligne en fonction de la recherche
                rows[i].style.display = found ? "" : "none";
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
