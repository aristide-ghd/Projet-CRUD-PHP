<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include '../includes/session_start_verify.php'; // Vérifier si l'utilisateur est connecté

    if ($_SESSION['role'] !== 'admin') {
        header("Location: ../index.php?error=accesuserinterdit");
        exit();
    }

    $nom = $_SESSION['nom'] ?? 'Utilisateur';
    $email = $_SESSION['email'] ?? 'inconnu';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Créer un utilisateur</title>
  
  <!-- Bootstrap CSS local -->
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome local -->
  <link rel="stylesheet" href="../fontawesome/css/all.min.css">
</head>

<body class="d-flex flex-column" style="height: 100vh; background-color: #f2f2f2;">
    <?php 
        $basePath = '../';
        include '../includes/menu.php'; 
    ?>

    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="successModalLabel"><i class="fas fa-check-circle"></i> Succès</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    Utilisateur créé avec succès. Veuillez vérifier dans la liste des utilisateurs
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="errorModalLabel"><i class="fas fa-exclamation-circle"></i> Erreur</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body" id="errorMessage">
                Une erreur est survenue.
            </div>
            </div>
        </div>
    </div>

    <div class="container py-5 mt-5">
        <div class="row justify-content-center mt-3">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary pt-3 text-white text-center">
                        <h4><i class="fas fa-user-plus"></i> Créer un utilisateur</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="../actions/createUserTreatment.php">
                        
                            <div class="mb-3">
                                <label for="name" class="form-label">Nom :</label>
                                <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control" name="name" id="name" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email :</label>
                                <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="" class="form-control" name="email" id="email" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe :</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input 
                                        type="password" class="form-control" name="password" id="password" 
                                        pattern="^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*()_+=\-]).{8,}$"
                                        title="Au moins 8 caractères, une majuscule, un chiffre et un caractère spécial"
                                        required 
                                    >
                                    <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                        <i class="fas fa-eye-slash"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirmer mot de passe :</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input 
                                        type="password" class="form-control" name="confirm_password" id="confirm_password" 
                                        pattern="^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*()_+=\-]).{8,}$"
                                        title="Au moins 8 caractères, une majuscule, un chiffre et un caractère spécial"
                                        required 
                                    >
                                    <span class="input-group-text" id="toggleConfirmPassword" style="cursor: pointer;">
                                        <i class="fas fa-eye-slash"></i>
                                    </span>
                                </div>
                            </div>


                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Enregistrer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS local -->
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>

    <script>
        // Mot de passe principale
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Changer l'icône
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });

        // Confirmation mot de passe
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const confirmPasswordInput = document.getElementById('confirm_password');

        toggleConfirmPassword.addEventListener('click', function () {
            const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordInput.setAttribute('type', type);

            // Changer l'icone
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });

        // Afficher la modal success si success=1 dans l'URL
        <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
            const modalElement = document.getElementById('successModal');
            const successModal = new bootstrap.Modal(modalElement);
            successModal.show();

            // Nettoyer l'URL (supprimer ?success=1 sans recharger)
            window.history.replaceState(null, null, window.location.pathname);
        <?php endif; ?>

        // Afficher la modal erreur si error dans l'URL 
        <?php if (isset($_GET['error'])): ?>
            const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            const errorMessage = document.getElementById('errorMessage');

            <?php if ($_GET['error'] == 'champsvides'): ?>
                errorMessage.innerHTML = "Tous les champs doivent être remplis.";
            <?php elseif ($_GET['error'] == 'emailinvalide'): ?>
                errorMessage.innerHTML = "Adresse email invalide.";
            <?php elseif ($_GET['error'] == 'emailexiste'): ?>
                errorMessage.innerHTML = "Cet email est déjà utilisé. Veuillez en choisir un autre.";
            <?php elseif ($_GET['error'] == 'passwordcourt'): ?>
                errorMessage.innerHTML = "Le mot de passe doit contenir au moins 8 caractères.";
            <?php elseif ($_GET['error'] == 'passwordfaible'): ?>
                errorMessage.innerHTML = "Le mot de passe doit contenir une majuscule, un chiffre et un caractère spécial.";
            <?php elseif ($_GET['error'] == 'mdpnonidentique'): ?>
                errorMessage.innerHTML = "Les deux mots de passe ne correspondent pas.";
            <?php else: ?>
                errorMessage.innerHTML = "Une erreur est survenue. Veuillez réessayer.";
            <?php endif; ?>

            errorModal.show();
            window.history.replaceState(null, null, window.location.pathname);
        <?php endif; ?>

    </script>

</body>
</html>
