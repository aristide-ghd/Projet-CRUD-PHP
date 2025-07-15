<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Inclure la connexion
    include 'includes/sign_in_db.php';
    // Verifier la connexion a la base de données
    include 'includes/db_connected_verify.php';
    // Inclure la fonction pour lire les utilisateurs
    include 'includes/user_functions.php';

    // Récupérer les utilisateurs
    $users = readUsers($bdd);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Liste des utilisateurs</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="fontawesome/css/all.min.css">
</head>
<body style="background-color: #f2f2f2;" class="p-5">

    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="successModalLabel"><i class="fas fa-check-circle"></i> Opération réussie</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body" id="successMessage">
                    Notification de succès.
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <h2 class="mb-4 text-center"><i class="fas fa-users"></i> Liste des utilisateurs</h2>

        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($users) > 0): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= htmlspecialchars($user['id']) ?></td>
                                <td><?= htmlspecialchars($user['nom']) ?></td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td>
                                    <?php if ($user['role'] === 'admin'): ?>
                                        <span class="badge bg-danger"><i class="fas fa-crown"></i> Admin</span>
                                    <?php else: ?>
                                        <span class="badge bg-success"><i class="fas fa-user"></i> Utilisateur</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <!-- Bouton Modifier -->
                                    <a href="editpage.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <!-- Bouton Supprimer -->
                                    <button 
                                        class="btn btn-sm btn-danger" 
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteModal<?= $user['id'] ?>">
                                            <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            <!-- Modal de confirmation suppression -->
                            <div class="modal fade" id="deleteModal<?= $user['id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $user['id'] ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title" id="deleteModalLabel<?= $user['id'] ?>"><i class="fas fa-exclamation-triangle"></i> Confirmation</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                        </div>
                                        <div class="modal-body">
                                            Voulez-vous vraiment supprimer l'utilisateur <strong><?= htmlspecialchars($user['nom']) ?></strong> ?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                            <a href="deleteUser.php?id=<?= $user['id'] ?>" class="btn btn-danger">Supprimer</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Aucun utilisateur enregistré.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mb-3">
            <a href="index.php" class="btn btn-primary">
                <i class="fas fa-user-plus"></i> Ajouter un utilisateur
            </a>
        </div>
    </div>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>

    <script>
        // Afficher la modal success si success=deleted et success=edited dans l'URL
        <?php if (isset($_GET['success'])): ?>
            const successMessage = document.getElementById('successMessage');

            if (successMessage) {
                <?php if ($_GET['success'] == 'deleted'): ?>
                    successMessage.innerHTML = "Utilisateur supprimé avec succès.";
                <?php elseif ($_GET['success'] == 'edited'): ?>
                    successMessage.innerHTML = "Utilisateur modifié avec succès.";
                <?php endif; ?>

                const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();
                window.history.replaceState(null, null, window.location.pathname);
            }
        <?php endif; ?>
    </script>
</body>
</html>
