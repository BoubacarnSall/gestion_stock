<?php
header('Content-Type: application/json');
require '../../config/config.php';

$action = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : null);

switch ($action) {
    case 'ajouter':
        ajouterUtilisateur($conn);
        break;
    case 'modifier':
        modifierUtilisateur($conn);
        break;
    case 'supprimer':
        supprimerUtilisateur($conn);
        break;
    case 'afficher':
        afficherUtilisateur($conn);
        break;
    case 'recuperer':
        recupererUtilisateur($conn);
        break;
    case 'exporter';
        exporterUtilisateur($conn);
        break;
    default:
        echo json_encode(['success' => false, 'error' => 'Action non reconnue.']);
}

function ajouterUtilisateur($conn) {
    $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
    $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $mot_de_passe = isset($_POST['mot_de_passe']) ? $_POST['mot_de_passe'] : '';

    $checkQuery = "SELECT * FROM utilisateurs WHERE email = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bindParam(1, $email);
    $checkStmt->execute();

    if ($checkStmt->rowCount() > 0) {
        echo json_encode(['success' => false, 'error' => 'L\'adresse e-mail existe déjà.']);
        return;
    }

    $query = "INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, date_arrive) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $nom);
    $stmt->bindParam(2, $prenom);
    $stmt->bindParam(3, $email);
    $stmt->bindParam(4, $mot_de_passe);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Utilisateur ajouté avec succès']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Erreur lors de l\'ajout de l\'utilisateur']);
    }
}

function modifierUtilisateur($conn){
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
    $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $mot_de_passe = isset($_POST['mot_de_passe']) ? $_POST['mot_de_passe'] : '';

    $query = "UPDATE utilisateurs SET nom = ?, prenom = ?, email = ?, mot_de_passe = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $nom);
    $stmt->bindParam(2, $prenom);
    $stmt->bindParam(3, $email);
    $stmt->bindParam(4, $mot_de_passe);
    $stmt->bindParam(5, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Utilisateur modifié avec succès']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Erreur lors de la modification de l\'utilisateur']);
    }
}

function supprimerUtilisateur($conn){
    $id = isset($_GET['id']) ? $_GET['id'] : '';

    $query = "DELETE FROM utilisateurs WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Utilisateur supprimé avec succès']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Erreur lors de la suppression de l\'utilisateur']);
    }
}

function afficherUtilisateur($conn){
    $query = "SELECT * FROM utilisateurs";
    $stmt = $conn->query($query);

    $utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'data' => $utilisateurs]);
}

function recupererUtilisateur($conn){
    $id = isset($_GET['id']) ? $_GET['id'] : '';

    $query = "SELECT * FROM utilisateurs WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $id);
    $stmt->execute();

    $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($utilisateur) {
        echo json_encode(['success' => true, 'data' => $utilisateur]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Utilisateur non trouvé']);
    }
}

function exporterUtilisateur($conn) {
    // Préparer et exécuter la requête pour obtenir les données des utilisateurs
    $query = "SELECT * FROM utilisateurs";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    // Récupérer toutes les données en tant que tableau associatif
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Commencer à créer le contenu du tableau en HTML
    $contenu = "<table border='1'>";
    $contenu .= "<tr>";
    $contenu .= "<th>Nom</th>";
    $contenu .= "<th>Prénom</th>";
    $contenu .= "<th>Email</th>";
    $contenu .= "</tr>";

    // Ajouter les données des utilisateurs dans les lignes du tableau
    foreach ($data as $row) {
        $contenu .= "<tr>";
        $contenu .= "<td>" . htmlspecialchars($row['nom']) . "</td>";
        $contenu .= "<td>" . htmlspecialchars($row['prenom']) . "</td>";
        $contenu .= "<td>" . htmlspecialchars($row['email']) . "</td>";
        $contenu .= "</tr>";
    }

    $contenu .= "</table>";

    $phpWord = new \PhpOffice\PhpWord\PhpWord();
    $section = $phpWord->addSection();
    \PhpOffice\PhpWord\Shared\Html::addHtml($section, $contenu);

    // Sauvegarder le fichier Word
    $fileName = 'utilisateurs.docx';
    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
    $objWriter->save($fileName);

    // Proposer le fichier en téléchargement
    header('Content-Description: File Transfer');
    header('Content-Disposition: attachment; filename=' . basename($fileName));
    header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    header('Content-Transfer-Encoding: binary');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Expires: 0');
    readfile($fileName);

    // Supprimer le fichier après téléchargement
    unlink($fileName);
}

?>
