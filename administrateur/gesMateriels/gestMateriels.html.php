<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Matériels</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    <style>
        section {
            background-image: url('../ressources/R.jpg');
            background-size: cover; 
            background-position: center;
            background-repeat: no-repeat;
            padding: 9rem 0; 
        }
       </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <a href="navbar-brand"><img src="../../ressources/logo.jpg" width="140" height="45" alt="logo"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="../sidbar.php">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="../gestUtilisateurs/gestionUtilisateur.html.php">Gestion des Utilisateurs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#">Gestion des Matériels</a>
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
                <h5 class="fs-4 text-center text-success">GESTION DES MATÉRIELS</h5>
            </div>
        </div>
        <div class="dropdown-divider border-success"></div>
        <div class="row">
            <div class="col-md-6">
                <h5 class="font-weight-bold mb-0">Liste des Matériels</h5>
            </div>
            <div class="col-md-6">
            <div class="d-flex justify-content-end">
                <button class="btn btn-success btn-sm mr-3" data-toggle="modal" data-target="#ajouter"><i class="fas fa-folder-plus"></i> Ajouter</button>
                <a href="#" class="btn btn-success btn-sm"><i class="fas fa-table"></i> Exporter</a>
            </div>
            </div>
        </div>
        <div class="dropdown-divider border-success"></div>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-striped" id="materiels">
                    <thead class="custom-table-header">
                        <tr>
                            <th scope="col">N°</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Description</th>
                            <th scope="col">Quantité</th>
                            <th scope="col">Date d'ajout</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require '../../config/config.php';
                        class Materiel {
                            private $db;

                            public function __construct($db) {
                                $this->db = $db;
                            }

                            public function afficher() {
                                try {
                                    $stmt = $this->db->prepare("SELECT * FROM materiels");
                                    $stmt->execute();
                                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                                } catch (PDOException $e) {
                                    echo 'Erreur de requête : ' . $e->getMessage();
                                    return [];
                                }
                            }
                        }

                        $materiel = new Materiel($conn);
                        $materiels = $materiel->afficher();

                        foreach ($materiels as $materiel) {
                            echo "<tr>";
                            echo "<td>" . $materiel['id'] . "</td>";
                            echo "<td>" . $materiel['nom'] . "</td>";
                            echo "<td>" . $materiel['descriptions'] . "</td>";
                            echo "<td>" . $materiel['quantite'] . "</td>";
                            echo "<td>" . $materiel['date_arrive'] . "</td>";
                            echo '<td>
                                    <a href="#" class="text-info mr-2" title="Voir info" onclick="voirInfo(event, ' . $materiel['id'] . ')"><i class="fas fa-info-circle"></i></a>
                                    <a href="#" class="text-warning mr-2" title="Modifier" onclick="modifierMaterielModal(event, ' . $materiel['id'] . ')"><i class="fas fa-edit"></i></a>
                                    <a href="#" class="text-danger" title="Supprimer" onclick="supprimerMateriel(event, ' . $materiel['id'] . ')"><i class="fas fa-trash-alt"></i></a>
                                  </td>';
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</header>
<!-- Modal Ajout -->
<div class="modal fade" id="ajouter" tabindex="-1" role="dialog" aria-labelledby="ajouterModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ajouterModalLabel">Nouveau Matériel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formAjoutMateriel">
                    <div class="form-group">
                        <input type="text" class="form-control" id="nom" name="nom" placeholder="Entrez le nom" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="descriptions" name="descriptions" placeholder="Entrez la description" required>
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" id="quantite" name="quantite" placeholder="Entrez la quantité" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-success" onclick="ajouterMateriel()">Ajouter <i class="fas fa-plus"></i></button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Modification -->
<div class="modal fade" id="modifier" tabindex="-1" role="dialog" aria-labelledby="modifierModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modifierModalLabel">Modifier le matériel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formModifierMateriel">
                    <input type="hidden" id="modifierId" name="id">
                    <div class="form-group">
                        <input type="text" class="form-control" id="modifierNom" name="nom" placeholder="Entrez le nom" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="modifierDescriptions" name="descriptions" placeholder="Entrez la description" required> <!-- Nom corrigé pour correspondre au code PHP -->
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" id="modifierQuantite" name="quantite" placeholder="Entrez la quantité" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-success" onclick="modifierMateriel()">Modifier <i class="fas fa-edit"></i></button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Voir Info -->
<div class="modal fade" id="voirInfoModal" tabindex="-1" role="dialog" aria-labelledby="voirInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="voirInfoModalLabel">Informations du Matériel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Nom:</strong> <span id="infoNom"></span></p>
                <p><strong>Description:</strong> <span id="infoDescription"></span></p>
                <p><strong>Quantité:</strong> <span id="infoQuantite"></span></p>
                <p><strong>Date d'ajout:</strong> <span id="infoDateAjout"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Fermer</button>
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
