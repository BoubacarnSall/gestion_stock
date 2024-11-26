<?php
require '../config/config.php';
$errorMessage = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $queryAdmin = "SELECT * FROM administrateurs WHERE email = :email AND mot_de_passe = :password";
    $stmtAdmin = $conn->prepare($queryAdmin);
    $stmtAdmin->bindParam(':email', $email);
    $stmtAdmin->bindParam(':password', $password);
    $stmtAdmin->execute();

    if ($stmtAdmin->rowCount() > 0) {
        header("Location: ../administrateur/sidbar.php");
        exit();
    } else {
        $queryUser = "SELECT * FROM utilisateurs WHERE email = :email AND mot_de_passe = :password";
        $stmtUser = $conn->prepare($queryUser);
        $stmtUser->bindParam(':email', $email);
        $stmtUser->bindParam(':password', $password);
        $stmtUser->execute();

        if ($stmtUser->rowCount() > 0) {
            header("Location: sidbarUt.php");
            exit();
        } else {
            $errorMessage = "Email ou mot de passe incorrect.";
        }
    }
}

// Inclure le formulaire HTML
include '../index.html';

// Afficher le message d'erreur si nécessaire
if (!empty($errorMessage)) {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Erreur',
                text: '" . addslashes($errorMessage) . "',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    </script>";
}
?>
