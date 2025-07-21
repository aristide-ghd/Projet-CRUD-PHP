<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include '../includes/sign_in_db.php'; // Inclure le fichier de connexion a la base
    include '../includes/db_connected_verify.php'; // Vérifier la connexion a la base
    include '../includes/session_start_verify.php'; // Vérifier si l'utilisateur est connecté

    if (!isset($_GET['id'])) {
        header("Location: ../pages/admin/listUsers.php");
        exit();
    }

    $id = $_GET['id']; // Recuperation de l'id dans URL

    $sql = "SELECT * FROM utilisateurs WHERE id = :id";
    // Récupérer les infos actuelles de l'utilisateur
    $stmt = $bdd -> prepare($sql);
    $stmt -> execute([':id' => $id]);
    $user = $stmt -> fetch();

    if (!$user) {
        header("Location: ../pages/admin/listUsers.php");
        exit();
    }

    if ($_SESSION['role'] !== 'admin') {
        header("Location: ../../index.php?error=accesuserinterdit");
        exit();
    }

    $nom = $_SESSION['nom'] ?? 'Utilisateur';
    $email = $_SESSION['email'] ?? 'inconnu';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier utilisateur</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
</head>
<body class="" style="background-color: #f2f2f2;">
    <?php 
        $basePath = '../';
        include '../includes/menu.php'; 
    ?>

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
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white text-center pt-3">
                        <h4><i class="fas fa-edit"></i> Modifier l'utilisateur</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="../actions/editUser.php?id=<?= $id ?>">
                            <div class="mb-3">
                                <label class="form-label">Nom :</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input 
                                        type="text" 
                                        name="name" 
                                        id="name" 
                                        class="form-control" 
                                        value="<?= htmlspecialchars($user['nom']) ?>" 
                                        required
                                    >
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email :</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input 
                                        type="email" 
                                        name="email" 
                                        id="email" 
                                        class="form-control" 
                                        value="<?= htmlspecialchars($user['email']) ?>" 
                                        required
                                    >
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="../pages/admin/listUsers.php" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Retour
                                </a>
                                <button type="submit" class="btn btn-primary" name="updateUser">
                                    <i class="fas fa-save"></i> Enregistrer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>

    <script>
        // Afficher la modal erreur si error dans l'URL 
        <?php if (isset($_GET['error'])): ?>
            const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            const errorMessage = document.getElementById('errorMessage');

            <?php if ($_GET['error'] == 'champsvides'): ?>
                errorMessage.innerHTML = "Tous les champs doivent être remplis.";
            <?php elseif ($_GET['error'] == 'emailinvalide'): ?>
                errorMessage.innerHTML = "Adresse email invalide.";
            <?php elseif ($_GET['error'] == 'emailpris'): ?>
                errorMessage.innerHTML = "Cet email est déjà utilisé. Veuillez en choisir un autre.";
            <?php else: ?>
                errorMessage.innerHTML = "Une erreur est survenue. Veuillez réessayer.";
            <?php endif; ?>

            errorModal.show();
            window.history.replaceState(null, null, window.location.pathname);
        <?php endif; ?>
    </script>
    
</body>
</html>
