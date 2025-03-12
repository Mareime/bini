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
            <h2>Liste des Comptes</h2>

            <div class="d-flex justify-content-between mb-3">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal">Créer un nouveau compte</button>
                
                <!-- Boutons pour exportation et importation -->
                <div>
                    <a href="{{ route('compte.export') }}" class="btn btn-primary">Exporter</a>
                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#importModal">Importer</button>
                </div>
            </div>

            <!-- Modal pour la création d'un compte -->
            <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createModalLabel">Ajouter un nouveau compte</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('compte.store') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="numero">Numéro du Compte</label>
                                    <input type="text" name="numero" class="form-control" value="{{ old('numero') }}" required>
                                    @error('numero')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>                     
                                <div class="form-group">
                                    <label for="type_compte">Type de Compte</label>
                                    <select name="type_compte" id="type_compte" class="form-control" required>
                                        <option value="courant">Courant</option>
                                        <option value="épargne">Épargne</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="solde">Solde</label>
                                    <input type="number" name="solde" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="date_creation">Date de Création</label>
                                    <input type="date" name="date_creation" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" class="form-control" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success">Créer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal pour l'importation -->
            <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="importModalLabel">Importer un fichier Excel (XLSX) ou CSV</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('compte.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="file">Sélectionnez un fichier à importer :</label>
                                    <input type="file" name="file" id="file" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success">Importer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Messages d'alerte -->
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="mb-3">
                <div class="input-group">
                    <input type="text" id="searchInput" class="form-control" placeholder="Rechercher un compte..." onkeyup="searchComptes()">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                </div>
            </div>
        
            <!-- Tableau des comptes -->
            <table class="table table-hover" id="compteTable">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th>Numéro du Compte</th>
                        <th>Type de Compte</th>
                        <th>Solde</th>
                        <th>Date de Création</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($comptes as $compte)
                        <tr>
                            <th scope="row">{{ $compte->id }}</th>
                            <td>{{ $compte->numero }}</td>
                            <td>{{ $compte->type_compte }}</td>
                            <td>{{ $compte->solde }}</td>
                            <td>{{ $compte->date_creation }}</td>
                            <td>{{ $compte->description }}</td>
                            <td>
                                <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $compte->id }}">Modifier</a>
                                <form action="{{ route('compte.destroy', $compte) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal de modification -->
                        <div class="modal fade" id="editModal{{ $compte->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $compte->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel{{ $compte->id }}">Modifier le compte {{ $compte->numero }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('compte.update', $compte) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="numero">Numéro du Compte</label>
                                                <input type="text" name="numero" class="form-control" value="{{ $compte->numero }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="type_compte">Type de Compte</label>
                                                <select name="type_compte" id="type_compte" class="form-control" required>
                                                    <option value="courant" @if ($compte->type_compte === 'courant') selected @endif>Courant</option>
                                                    <option value="épargne" @if ($compte->type_compte === 'épargne') selected @endif>Épargne</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="solde">Solde</label>
                                                <input type="number" name="solde" class="form-control" value="{{ $compte->solde }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="date_creation">Date de Création</label>
                                                <input type="date" name="date_creation" class="form-control" value="{{ \Carbon\Carbon::parse($compte->date_creation)->format('Y-m-d') }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea name="description" class="form-control" required>{{ $compte->description }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-success">Mettre à jour</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function searchComptes() {
            let input = document.getElementById('searchInput');
            let filter = input.value.toUpperCase();
            let table = document.getElementById('compteTable');
            let tr = table.getElementsByTagName('tr');
            
            for (let i = 1; i < tr.length; i++) {
                let td = tr[i].getElementsByTagName('td');
                let match = false;
                
                for (let j = 0; j < td.length; j++) {
                    if (td[j]) {
                        let txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            match = true;
                            break;
                        }
                    }
                }
                
                if (match) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
