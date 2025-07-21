<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start(); // Initialiser la session
    $role = $_SESSION['role'] ?? '';
?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  
  <!-- Bootstrap CSS local -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome local -->
  <link rel="stylesheet" href="fontawesome/css/all.min.css">
</head>

<body class="d-flex flex-column" style="height: 100vh; background-color: #f2f2f2;">

    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="successModalLabel"><i class="fas fa-check-circle"></i> Succès</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                  Connexion effectuée avec succès.Vous serez redirigé vers la page d'accueil
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
                    <div class="card-header bg-danger pt-3 text-white text-center">
                        <h4><i class="fas fa-sign-in-alt"></i> Connectez-vous</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="actions/loginUser.php">

                            <div class="mb-3">
                                <label for="email" class="form-label">Email :</label>
                                <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="" class="form-control" name="email" id="email" >
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
                                         
                                    >
                                    <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                        <i class="fas fa-eye-slash"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button class="btn btn-danger col-12" type="submit" name="valider">
                                  <i class="fas fa-lock me-2"></i>Se connecter
                                </button><br>
                                <p class="m-auto">Vous n'avez pas de compte?<a href="forms/sign_up.php">Inscrivez-vous ici</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS local -->
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>

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

    </script>

    <script>
        // Vérifie si 'success=1' est dans l'URL
        const urlParams = new URLSearchParams(window.location.search);
        const role = "<?php echo $role; ?>"; // injecter le rôle PHP dans JS
        const success = urlParams.get('success');
        const error = urlParams.get('error');

        if (success === '1') {
            const modalElement = document.getElementById('successModal');
            const successModal = new bootstrap.Modal(modalElement);
            successModal.show();

            modalElement.addEventListener('shown.bs.modal', function () {
                setTimeout(function () {
                    if (role === 'admin') {
                        window.location.href = "pages/admin/dashboard.php"; 
                    } else if (role === 'user') {
                        window.location.href = "pages/user/interface_user.php";
                    } else {
                        window.location.href = "index.php?error=roleinvalide"; // Redirection par défaut
                    }
                }, 3000);
            });

            window.history.replaceState(null, null, window.location.pathname);
        }

        if (error) {
            const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            const errorMessage = document.getElementById('errorMessage');

            switch (error) {
                case 'champsvides':
                    errorMessage.innerHTML = "Tous les champs doivent être remplis.";
                    break;
                case 'emailinconnu':
                    errorMessage.innerHTML = "Aucun compte trouvé avec cet email.";
                    break;
                case 'motdepasseincorrect':
                    errorMessage.innerHTML = "Le mot de passe est incorrect.";
                    break;
                case 'sessionexpirée': 
                    errorMessage.innerHTML = "Votre session est expirée. Veuillez-vous connecter";
                    break;
                case 'roleinvalide': 
                    errorMessage.innerHTML = "Veuillez-vous inscrire";
                    break;
                case 'accesadmininterdit': 
                    errorMessage.innerHTML = "Vous avez tenté d'accéder à une page réservées aux utilisateurs. Nous vous avons éjecter";
                    break;
                case 'accesuserinterdit': 
                    errorMessage.innerHTML = "Vous avez tenté d'accéder à une page réservées aux administrateurs. Nous vous avons éjecter";
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
