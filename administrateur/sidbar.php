<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Accueil - Gestion de Stocks</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- <link rel="stylesheet" href="stylenav.css"> -->
    <style>
        section {
            background-image: url('../ressources/R.jpg');
            background-size: cover; 
            background-position: center;
            background-repeat: no-repeat;
            color: #08d62e;
            padding: 9rem 0; 
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <a href="navbar-brand"><img src="../ressources/logo.jpg" width="150" height="45" alt="logo"></a>
        <!-- <a class="navbar-brand" href="#">Groupe Balling</a>
        <a class="navbar-brand" href="#">Gestion de stock</a> -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="sidbar.php">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="gestUtilisateurs/gestionUtilisateur.html.php">Gestion des Utilisateurs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="gesMateriels/gestMateriels.html.php">Gestion des Matériels</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="authentification.html.php">Déconnexion</a>
                </li>
            </ul>
        </div>
    </nav>

    <header class="bg-light py-4">
        <div class="container text-center">
            <h1 class="display-4">Bienvenue dans le Système de Gestion de Stocks</h1>
            <p class="lead">Gérez vos utilisateurs et matériels de manière simple et efficace.</p>
            <h2 class="mt-4"><span class="font-weight-bold">Groupe Balling</span> C'est moi</h2>
        </div>
    </header>
    <section>

    </section>

    <footer class="footer bg-success text-white mt-5 py-2">
        <div class="container text-center">
            <p>&copy; 2024 Group Balling. Tous droits réservés.</p>
        </div>
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
