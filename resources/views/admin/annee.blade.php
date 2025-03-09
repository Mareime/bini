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
        <div class="container mt-5">
            <h1 class="mb-4">Liste des Compteurs</h1>
    
            <!-- Bouton pour ouvrir le modal d'ajout -->
            <button type="button" class="btn btn-dark mb-3" data-bs-toggle="modal" data-bs-target="#compteurModal">
                Ajouter un nouveau compteur
            </button>
    
            <!-- Affichage du message de succès -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
    
            <!-- Liste des compteurs -->
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Année</th>
                        <th>Compteur</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($compteurs as $compteur)
                        <tr>
                            <td>{{ $compteur->id }}</td>
                            <td>{{ $compteur->annee }}</td>
                            <td>{{ $compteur->compteur }}</td>
                            <td>
                                <!-- Lien pour ouvrir le modal d'édition -->
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#compteurModal"
                                        data-annee="{{ $compteur->annee }}" data-compteur="{{ $compteur->compteur }}" data-id="{{ $compteur->id }}">
                                    Éditer
                                </button>
    
                                <!-- Formulaire pour supprimer un compteur -->
                                <form action="{{ route('compteurs.destroy', $compteur->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    
        <!-- Modal pour Ajouter et Modifier les Compteurs -->
        <div class="modal fade" id="compteurModal" tabindex="-1" aria-labelledby="compteurModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="compteurModalLabel">Ajouter un Compteur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="compteurForm" action="{{ route('compteurs.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" id="compteurId"> <!-- Pour modifier un compteur -->
                            <div class="mb-3">
                                <label for="annee" class="form-label">Année</label>
                                <input type="number" class="form-control" id="annee" name="annee" required>
                            </div>
                            <div class="mb-3">
                                <label for="compteur" class="form-label">Compteur</label>
                                <input type="number" class="form-control" id="compteur" name="compteur" required>
                            </div>
                            <button type="submit" class="btn btn-dark w-100" id="submitBtn">Ajouter</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
        <script>
            // Script pour préremplir le formulaire lors de l'édition
const modal = document.getElementById('compteurModal');
modal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const annee = button.getAttribute('data-annee');
    const compteur = button.getAttribute('data-compteur');
    const id = button.getAttribute('data-id');

    // Mettre à jour le formulaire avec les données de l'élément à modifier
    const modalTitle = modal.querySelector('.modal-title');
    const submitButton = modal.querySelector('#submitBtn');
    const form = modal.querySelector('#compteurForm');
    const anneeInput = modal.querySelector('#annee');
    const compteurInput = modal.querySelector('#compteur');
    const idInput = modal.querySelector('#compteurId');

    // Si un id existe, c'est un mode édition
    if (id) {
        modalTitle.textContent = "Modifier un Compteur";
        submitButton.textContent = "Modifier";
        form.action = `/compteurs/${id}`;
        idInput.value = id;
        anneeInput.value = annee;
        compteurInput.value = compteur;

        // Ajouter la méthode PUT
        const methodInput = document.createElement('input');
        methodInput.setAttribute('type', 'hidden');
        methodInput.setAttribute('name', '_method');
        methodInput.setAttribute('value', 'PUT');
        form.appendChild(methodInput);
    } else {
        modalTitle.textContent = "Ajouter un Compteur";
        submitButton.textContent = "Ajouter";
        form.action = "{{ route('compteurs.store') }}";
        anneeInput.value = '';
        compteurInput.value = '';
        idInput.value = '';
    }
});


            // script>
            </script>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
