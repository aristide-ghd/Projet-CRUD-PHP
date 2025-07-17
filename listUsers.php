<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include 'includes/sign_in_db.php'; // Inclure le fichier de connexion a la base
    include 'includes/db_connected_verify.php'; // Verifier la connexion a la base
    include 'includes/user_functions.php'; // Inclure le fichier des fonctions de l'utilisateur

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
<body style="background-color: #f2f2f2;">
    <?php include 'includes/menu.php'; ?>

    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="successModalLabel"><i class="fas fa-check-circle"></i> Opération réussie</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body" id="successMessage">Notification de succès.</div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <h2 class="mb-4 text-center"><i class="fas fa-users"></i> Liste des utilisateurs</h2>

        <!-- Zone de recherche -->
        <div class="row mb-4">
            <div class="col-md-6 offset-md-3">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" id="searchInput" class="form-control" placeholder="Rechercher un utilisateur (nom, email ou rôle...)">
                </div>
            </div>
        </div>

        <!-- Tableau -->
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
                                    <a href="editpage.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-warning" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger" title="Supprimer" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $user['id'] ?>">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal de confirmation -->
                            <div class="modal fade" id="deleteModal<?= $user['id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $user['id'] ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title"><i class="fas fa-exclamation-triangle"></i> Confirmation</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                        </div>
                                        <div class="modal-body">
                                            Voulez-vous vraiment supprimer <strong><?= htmlspecialchars($user['nom']) ?></strong> ?
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
            <a href="createUserPage.php" class="btn btn-primary">
                <i class="fas fa-user-plus"></i> Ajouter un utilisateur
            </a>
        </div>
    </div>

    <!-- Bootstrap JS local -->
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Modal de succès -->
    <script>
        <?php if (isset($_GET['success'])): ?>
            const successMessage = document.getElementById('successMessage');
            if (successMessage) {
                <?php if ($_GET['success'] == 'deleted'): ?>
                    successMessage.innerHTML = "Utilisateur supprimé avec succès.";
                <?php elseif ($_GET['success'] == 'edited'): ?>
                    successMessage.innerHTML = "Utilisateur modifié avec succès.";
                <?php endif; ?>
                new bootstrap.Modal(document.getElementById('successModal')).show();
                window.history.replaceState(null, null, window.location.pathname);
            }
        <?php endif; ?>
    </script>

    <!-- Script recherche -->
    <script>
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('keyup', () => {
            const filter = searchInput.value.toLowerCase();
            const rows = document.querySelectorAll("table tbody tr");

            rows.forEach(row => {
                const nom = row.cells[1].textContent.toLowerCase();
                const email = row.cells[2].textContent.toLowerCase();
                const role = row.cells[3].textContent.toLowerCase();
                row.style.display = nom.includes(filter) || email.includes(filter) || role.includes(filter) ? "" : "none";
            });
        });
    </script>

</body>
</html>
