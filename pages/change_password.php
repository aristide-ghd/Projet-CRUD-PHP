<?php
    session_start();
    include '../includes/session_start_verify.php'; // Vérifier si l'utilisateur est connecté

    $nom = $_SESSION['nom'] ?? 'Utilisateur';
    $email = $_SESSION['email'] ?? 'inconnu';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Changer le mot de passe</title>
  <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../fontawesome/css/all.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column" style="height: 100vh; background-color: #f2f2f2;">
    <?php 
        $basePath = '../';
        include '../includes/menu.php'; 
    ?>

    <div class="container mt-5 py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg rounded-5">
                    <div class="card-header bg-primary text-white text-center rounded-top-5">
                        <h4><i class="fas fa-key me-2 mt-3"></i>Changer le mot de passe</h4>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="../actions/validate_password.php">
                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-lock me-2"></i>Ancien mot de passe</label>
                                <input type="password" name="current_password" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-lock-open me-2"></i>Nouveau mot de passe</label>
                                <input type="password" name="new_password" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-lock me-2"></i>Confirmer le mot de passe</label>
                                <input type="password" name="confirm_password" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-success w-100"><i class="fas fa-save me-2"></i>Changer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS local -->
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
