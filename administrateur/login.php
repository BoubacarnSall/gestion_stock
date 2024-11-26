<?php
session_start();

require '../config/config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST["email"];
    $mot_de_passe = $_POST["password"];

    try {
        $stmt = $conn->prepare("SELECT * FROM administrateurs WHERE email = ?");
        $stmt->execute([$email]);
        $administrateur = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($administrateur) {
            if ($mot_de_passe === $administrateur['mot_de_passe']) {
                $_SESSION['admin_id'] = $administrateur['id'];
                $_SESSION['admin_nom'] = $administrateur['nom'];
                $_SESSION['admin_prenom'] = $administrateur['prenom'];

                echo json_encode(['success' => true, 'message' => 'Connexion réussie.']);
                exit;
            } else {
                echo json_encode(['success' => false, 'message' => 'Mot de passe incorrect.']);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'L\'adresse email n\'existe pas.']);
            exit;
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur de connexion à la base de données : ' . $e->getMessage()]);
        exit;
    }
}
?>
