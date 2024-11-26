<?php
$server_name = 'localhost';
$user_name = 'root';
$db_name = 'gestion_stocks';
$password = '';

try {
    $conn = new PDO("mysql:host=$server_name;dbname=$db_name", $user_name, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connexion réussie";
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Erreur de connexion à la base de données : ' . $e->getMessage()]);
    exit();
}
?>


