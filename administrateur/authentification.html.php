<?php
require '../config/config.php';

$errorMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to check if the user is an administrator
    $queryAdmin = "SELECT * FROM administrateurs WHERE email = :email AND mot_de_passe = :password";
    $stmtAdmin = $conn->prepare($queryAdmin);
    $stmtAdmin->bindParam(':email', $email);
    $stmtAdmin->bindParam(':password', $password);
    $stmtAdmin->execute();

    if ($stmtAdmin->rowCount() > 0) {
        // Redirect to the administrator dashboard
        header("Location: sidbar.php");
        exit();
    } else {
        // Query to check if the user is a regular user
        $queryUser = "SELECT * FROM utilisateurs WHERE email = :email AND mot_de_passe = :password";
        $stmtUser = $conn->prepare($queryUser);
        $stmtUser->bindParam(':email', $email);
        $stmtUser->bindParam(':password', $password);
        $stmtUser->execute();

        if ($stmtUser->rowCount() > 0) {
            // Redirect to the user dashboard
            header("Location: ../Utilisateurs/sidbarUt.php");
            exit();
        } else {
            $errorMessage = "Email ou mot de passe incorrect.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Gestion de Stocks</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="./Utilisateurs/style.css"> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
            <?php if (!empty($errorMessage)): ?>
                <script>
                    Swal.fire({
                        title: "Erreur",
                        text: "<?= $errorMessage ?>",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                </script>
            <?php endif; ?>
            <div class="card p-4 shadow-lg" style="width: 100%; max-width: 400px;">
                <h3 class="card-title text-center mb-4"><a><img src="../ressources/logo.jpg" width="140" height="45" alt="logo"></a></h3>
                <form id="loginForm" action="" method="POST">
                    <div class="mb-3">
                        <input type="text" id="email" name="email" class="form-control" placeholder="Entrez votre email" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" id="password" name="password" class="form-control" placeholder="Entrez votre Mot de passe" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success shadow-lg-9">Connexion</button>
                    </div>
                    <div class="text-center mt-3">
                    <a href="../Utilisateurs/MotDepaOu.html.php">Mot de passe oublié</a>
                    </div>
                </form>
            </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
</body>
</html>