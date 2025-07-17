<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include 'includes/sign_in_db.php'; // Inclure le fichier de connexion a la base
    include 'includes/db_connected_verify.php'; // Verifier la connexion a la base

    // Requête pour compter les utilisateurs
    $requete = $bdd->query("SELECT COUNT(*) FROM utilisateurs");
    $totalUtilisateurs = $requete->fetchColumn();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
</head>
<body style="background-color: #f2f2f2;">
    <?php include 'includes/menu.php'; ?>

    <div class="container py-4">
        <div class="text-center mb-5">
            <h1 class="display-5 fw-bold">Bienvenue sur le Tableau de Bord</h1>
            <p class="lead">Gérez vos utilisateurs facilement depuis cet espace.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card text-white bg-primary h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title"><i class="fas fa-users me-2"></i> Liste des utilisateurs</h5>
                            <p class="card-text">Consultez et gérez tous les utilisateurs enregistrés.</p>
                        </div>
                        <a href="listUsers.php" class="btn btn-light mt-3">Voir la liste</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-white bg-success h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="card-title"><i class="fas fa-user-plus me-2"></i> Ajouter un utilisateur</h5>
                        <p class="card-text">Ajoutez un nouvel utilisateur au système en quelques clics.</p>
                    </div>
                    <a href="createUserPage.php" class="btn btn-light mt-3">Ajouter</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-white bg-danger h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="card-title"><i class="fas fa-sign-out-alt me-2"></i> Déconnexion</h5>
                        <p class="card-text">Terminez votre session en toute sécurité.</p>
                    </div>
                    <a href="#" class="btn btn-light mt-3">Se déconnecter</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte total utilisateurs -->
        <div class="row mb-5 w-100 mt-4 ms-0">
            <div class="col-md-12">
                <div class="card border-primary text-center">
                    <div class="card-body">
                        <h5 class="card-title">Utilisateurs enregistrés</h5>
                        <p class="display-5 fw-bold text-primary">
                            <?= $totalUtilisateurs ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS local -->
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>
