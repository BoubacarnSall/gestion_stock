<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs - Gestion de Stocks</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    <!-- <link rel="stylesheet" href="../stylenav.css"> -->
    <!-- <style>
        section {
            background-image: url('../ressources/R.jpg');
            background-size: cover; 
            background-position: center;
            background-repeat: no-repeat;
            padding: 9rem 0; 
        }

       </style> -->
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <a href="navbar-brand"><img src="../../ressources/logo.jpg" width="140" height="45" alt="logo"></a>
        <!-- <a class="navbar-brand" href="#">Groupe Balling</a>
        <a class="navbar-brand" href="#">Gestion de stock</a> -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="../sidbar.php">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="gestionUtilisateur.html.php">Gestion des Utilisateurs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="../gesMateriels/gestMateriels.html.php">Gestion des Matériels</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="../authentification.html.php">Déconnexion</a>
                </li>
            </ul>
        </div>
    </nav>
<header>
<section class="container py-5">
    <div class="row">
        <div class="col-lg-8 col-sm mb-5 mx-auto">
            <h5 class="fs-4 text-center text-success">GESTION DES UTILISATEURS</h5>
        </div>
    </div>
    <div class="dropdown-divider border-success"></div>
    <div class="row">
        <div class="col-md-6">
            <h5 class="font-weight-bold mb-0">Liste des Utilisateurs</h5>
        </div>
        <div class="col-md-6">
        <div class="d-flex justify-content-end">
            <button class="btn btn-success btn-sm mr-5" data-toggle="modal" data-target="#ajouterModal">
                <i class="fas fa-folder-plus"></i> Ajouter
            </button>
            <a href="#" class="btn btn-success btn-sm mr-5"><i class="fas fa-table"></i> Exporter</a>
        </div>
        </div>
    </div>
    <div class="dropdown-divider border-success"></div>
    <div class="row">
        <div class="table-responsive">
            <table class="table table-striped" id="utilisateursTable">
                <thead class="custom-table-header">
                    <tr>
                        <th scope="col">N°</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Prénom</th>
                        <th scope="col">Email</th>
                        <th scope="col">Date d'ajout</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div> 
</section>  
</header>
<!-- Modal Ajout -->
<div class="modal fade" id="ajouterModal" tabindex="-1" role="dialog" aria-labelledby="ajouterModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ajouterModalLabel">Nouveau Utilisateur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formAjoutUtilisateur">
                    <div class="form-group">
                        <input type="text" class="form-control" id="nom" name="nom" placeholder="Entrez le nom" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Entrez le prénom" required>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Entrez l'email" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" placeholder="Entrez le mot de passe" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <button type="submit" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Modifier -->
<div class="modal fade" id="modifierModal" tabindex="-1" role="dialog" aria-labelledby="modifierModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modifierModalLabel">Modifier Utilisateur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formModifierUtilisateur">
                    <input type="hidden" id="modifierId" name="id">
                    <div class="form-group">
                        <input type="text" class="form-control" id="modifierNom" name="nom" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="modifierPrenom" name="prenom" required>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" id="modifierEmail" name="email" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="modifierMotDePasse" name="mot_de_passe" required>
                    </div>
                    <button type="submit" class="btn btn-secondary" data-dismiss = "modal">Annuler</button>
                    <button type="submit" class="btn btn-primary" >Modifier</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Info -->
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoModalLabel">Informations Utilisateur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Nom :</strong> <span id="infoNom"></span></p>
                <p><strong>Prénom :</strong> <span id="infoPrenom"></span></p>
                <p><strong>Email :</strong> <span id="infoEmail"></span></p>
                <p><strong>Date d'ajout :</strong> <span id="infoDateAjout"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Erreur -->
<div class="modal fade" id="erreurModal" tabindex="-1" role="dialog" aria-labelledby="erreurModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="erreurModalLabel">Erreur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="function.js"></script>
</body>
<footer class="footer bg-success text-white mt-5 py-2">
    <div class="container text-center">
        <p>&copy; 2024 Group Balling. Tous droits réservés.</p>
    </div>
</footer>
</html>
