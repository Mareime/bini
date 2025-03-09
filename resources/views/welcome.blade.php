<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login</title>

  <!-- MDB CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.css" rel="stylesheet" />

  <style>
    .divider:after,
    .divider:before {
      content: "";
      flex: 1;
      height: 1px;
      background: #eee;
    }

    .h-custom {
      height: calc(100% - 73px);
    }

    @media (max-width: 450px) {
      .h-custom {
        height: 100%;
      }
    }

    /* Custom Button Style */
    .btn-custom {
      width: 100%; /* Make the button span the width of the container */
      max-width: 400px; 
      margin-left: 65px;
    }
  </style>
</head>
<body>
  <section class="vh-100">
    <div class="container-fluid h-custom">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-md-9 col-lg-6 col-xl-5">
          <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
            class="img-fluid" alt="Sample image">
        </div>
        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
          <form action="{{ route('login.post') }}" method="POST">
            @csrf

            <!-- Title -->
            <div class="divider d-flex align-items-center my-4">
              <p class="text-center fw-bold mx-3 mb-0">Connexion</p>
            </div>

            <!-- Alert messages -->
            @if (session('success'))
              <div class="alert alert-success">
                  {{ session('success') }}
              </div>
            @endif

            @if ($errors->any())
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
            @endif

            <!-- Email input -->
            <div class="form-outline mb-4">
              <input type="email" name="email" id="form3Example3" class="form-control form-control-lg"
                placeholder="Entrez un email valide" required />
              <label class="form-label" for="form3Example3">Adresse e-mail</label>
            </div>

            <!-- Password input -->
            <div class="form-outline mb-3">
              <input type="password" name="password" id="form3Example4" class="form-control form-control-lg"
                placeholder="Entrez le mot de passe" required />
              <label class="form-label" for="form3Example4">Mot de passe</label>
            </div>

            <!-- Forgot password link -->
            {{-- <div class="d-flex justify-content-between align-items-center mb-4">
              <a href="#!" class="text-body">Mot de passe oublié ?</a>
            </div> --}}

            <!-- Login button -->
            <div class="text-center text-lg-start mt-4 pt-2">
              <button type="submit" class="btn btn-primary btn-lg btn-custom">Se connecter</button>
              {{-- <p class="small fw-bold mt-2 pt-1 mb-0">Pas encore de compte ? <a href="#!" class="link-danger">S'inscrire</a></p> --}}
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
  <script>
    // Empêcher l'utilisateur d'utiliser la fonction "Retour"
    window.history.pushState(null, null, window.location.href);
    window.onpopstate = function() {
      window.history.pushState(null, null, window.location.href);
    };
  </script>
  <!-- MDB JS -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.js"></script>
</body>
</html>