<?php
header('Content-Type: application/json');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../../config/config.php';

$action = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : null);

file_put_contents('php://stderr', "Action reçue : $action\n", FILE_APPEND);

switch ($action) {
    case 'afficher':
        afficherMateriels($conn);
        break;
    case 'ajouter':
        ajouterMateriel($conn);
        break;
    case 'modifier':
        modifierMateriel($conn);
        break;
    case 'supprimer':
        supprimerMateriel($conn);
        break;
    case 'recuperer':
        recupererMateriel($conn);
        break;
    default:
        echo json_encode(['success' => false, 'error' => 'Action non reconnue.']);
        break;
}

function afficherMateriels($conn) {
    file_put_contents('php://stderr', "Appel à afficherMateriels\n", FILE_APPEND);
    $query = 'SELECT * FROM materiels';
    $stmt = $conn->query($query);

    $materiels = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'data' => $materiels]);
}

function ajouterMateriel($conn) {
    file_put_contents('php://stderr', "Appel à ajouterMateriel\n", FILE_APPEND);
    $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
    $descriptions = isset($_POST['descriptions']) ? $_POST['descriptions'] : '';
    $quantite = isset($_POST['quantite']) ? $_POST['quantite'] : '';

    $query = "INSERT INTO materiels (nom, descriptions, quantite, date_arrive) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $nom);
    $stmt->bindParam(2, $descriptions);
    $stmt->bindParam(3, $quantite);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Matériel ajouté avec succès.']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Erreur lors de l\'ajout du matériel.']);
    }
}

function modifierMateriel($conn) {
    file_put_contents('php://stderr', "Appel à modifierMateriel\n", FILE_APPEND);
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
    $descriptions = isset($_POST['descriptions']) ? $_POST['descriptions'] : '';
    $quantite = isset($_POST['quantite']) ? $_POST['quantite'] : '';

    $query = "UPDATE materiels SET nom = ?, descriptions = ?, quantite = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $nom);
    $stmt->bindParam(2, $descriptions);
    $stmt->bindParam(3, $quantite);
    $stmt->bindParam(4, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Matériel modifié avec succès.']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Erreur lors de la modification du matériel.']);
    }
}

function supprimerMateriel($conn) {
    file_put_contents('php://stderr', "Appel à supprimerMateriel\n", FILE_APPEND);
    
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $query = "DELETE FROM materiels WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $id);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Matériel supprimé avec succès.']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Erreur lors de la suppression du matériel.']);
    }
}

function recupererMateriel($conn) {
    file_put_contents('php://stderr', "Appel à recupererMateriel\n", FILE_APPEND);
    $id = isset($_GET['id']) ? $_GET['id'] : '';

    $query = "SELECT * FROM materiels WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $id);
    $stmt->execute();

    $materiel = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($materiel) {
        echo json_encode(['success' => true, 'data' => $materiel]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Matériel non trouvé.']);
    }
}
?>
