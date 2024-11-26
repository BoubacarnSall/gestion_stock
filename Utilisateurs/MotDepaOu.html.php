<?php
require '../config/config.php'; 

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'], $_POST['mot_de_passe'])) {
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $sql = "SELECT * FROM utilisateurs WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $sql = "UPDATE utilisateurs SET mot_de_passe = :mot_de_passe WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':mot_de_passe', $mot_de_passe);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $message = "Mot de passe modifié pour l'utilisateur.";
      
        header("Location: authentification.html.php?message=" . urlencode($message));
        exit();
    } else {
        $sql = "SELECT * FROM administrateurs WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $sql = "UPDATE administrateurs SET mot_de_passe = :mot_de_passe WHERE email = :email";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':mot_de_passe', $mot_de_passe);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $message = "Mot de passe modifié pour l'administrateur.";
            header("Location: indx.html.php?message=" . urlencode($message));
            exit();
        } else {
            $message = "Email non trouvé.";
            echo "<script type='text/javascript'>
                window.onload = function() {
                    alert('" . addslashes($message) . "');
                }
            </script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification du Mot de Passe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow-lg" style="width: 100%; max-width: 400px;">
            <h3 class="card-title text-center mb-4"><a href="navbar-brand"><img src="../ressources/logo.jpg" width="140" height="45" alt="logo"></a></h3>
            <form id="passwordForm" action="" method="post">
                <div class="mb-3">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Entrez votre email" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" placeholder="Entrez le nouveau mot de passe" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-success">Modifier</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
