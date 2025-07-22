<?php
    session_start();
    include '../includes/session_start_verify.php';

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $nom = $_SESSION['nom'] ?? 'Utilisateur';
    $email = $_SESSION['email'] ?? 'inconnu';
    $basePath = '../';
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

    <?php include '../includes/menu.php'; ?>

    <!-- Modal succès -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="successModalLabel"><i class="fas fa-check-circle"></i> Succès</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">Changement de mot de passe effectué avec succès.</div>
            </div>
        </div>
    </div>

    <!-- Modal erreur -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="errorModalLabel"><i class="fas fa-exclamation-circle"></i> Erreur</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body" id="errorMessage">Une erreur est survenue.</div>
            </div>
        </div>
    </div>

    <!-- Formulaire -->
    <div class="container mt-5 py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg rounded-5">
                    <div class="card-header bg-primary text-white text-center rounded-top-5">
                        <h4><i class="fas fa-key me-2 mt-3"></i>Changer le mot de passe</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="../actions/validate_password.php">

                            <!-- Ancien mot de passe -->
                            <div class="mb-3">
                                <label for="old_password" class="form-label">Ancien mot de passe :</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input 
                                        type="password" class="form-control" name="old_password" id="old_password"
                                        required
                                    >
                                    <span class="input-group-text toggle-password" data-target="old_password" style="cursor: pointer;">
                                        <i class="fas fa-eye-slash"></i>
                                    </span>
                                </div>
                            </div>

                            <!-- Nouveau mot de passe -->
                            <div class="mb-3">
                                <label for="new_password" class="form-label">Nouveau mot de passe :</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock-open"></i></span>
                                    <input 
                                        type="password" class="form-control" name="new_password" id="new_password"
                                        pattern="^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*()_+=\-]).{8,}$"
                                        title="Au moins 8 caractères, une majuscule, un chiffre et un caractère spécial"
                                        required
                                    >
                                    <span class="input-group-text toggle-password" data-target="new_password" style="cursor: pointer;">
                                        <i class="fas fa-eye-slash"></i>
                                    </span>
                                </div>
                            </div>

                            <!-- Confirmation -->
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirmer le nouveau mot de passe :</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input 
                                        type="password" class="form-control" name="confirm_password" id="confirm_password"
                                        required
                                    >
                                    <span class="input-group-text toggle-password" data-target="confirm_password" style="cursor: pointer;">
                                        <i class="fas fa-eye-slash"></i>
                                    </span>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success w-100"><i class="fas fa-save me-2"></i>Changer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        // Gérer l'affichage/masquage des mots de passe
        document.querySelectorAll('.toggle-password').forEach(function (toggle) {
            toggle.addEventListener('click', function () {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon = this.querySelector('i');

                if (input.type === "password") {
                    input.type = "text";
                    icon.classList.remove("fa-eye-slash");
                    icon.classList.add("fa-eye");
                } else {
                    input.type = "password";
                    icon.classList.remove("fa-eye");
                    icon.classList.add("fa-eye-slash");
                }
            });
        });
    </script>

    <script>
        // Vérifie si 'success=1' est dans l'URL
        const urlParams = new URLSearchParams(window.location.search);
        const success = urlParams.get('success');
        const error = urlParams.get('error');

        if (success === '1') {
            const modalElement = document.getElementById('successModal');
            const successModal = new bootstrap.Modal(modalElement);
            successModal.show();

            window.history.replaceState(null, null, window.location.pathname);
        }

        if (error) {
            const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            const errorMessage = document.getElementById('errorMessage');

            switch (error) {
                case 'champsvides':
                    errorMessage.innerHTML = "Tous les champs doivent etre remplis.";
                    break;
                case 'password_incorrect':
                    errorMessage.innerHTML = "L'ancien mot de passe est incorrect.";
                    break;
                case 'password_do_not_match':
                    errorMessage.innerHTML = "Les nouveaux mots de passe ne correspondent pas.";
                    break;
                case 'same_password':
                    errorMessage.innerHTML = "Le nouveau mot de passe doit etre different de l'ancien.";
                    break;
                case 'password_short': 
                    errorMessage.innerHTML = "Le nouveau mot de passe doit contenir au moins 8 caractères.";
                    break;
                case 'password_weak': 
                    errorMessage.innerHTML = "Le mot de passe doit contenir une majuscule, un chiffre et un caractère spécial.";
                    break;
                default:
                    errorMessage.innerHTML = "Une erreur est survenue. Veuillez réessayer.";
            }

            errorModal.show();
            window.history.replaceState(null, null, window.location.pathname);
        }
    </script>
</body>
</html>
