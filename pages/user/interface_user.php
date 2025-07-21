<?php
    session_start();
    include '../../includes/session_start_verify.php'; // Vérifier si l'utilisateur est connecté

    if ($_SESSION['role'] !== 'user') {
        header("Location: ../../index.php?error=accesadmininterdit");
        exit();
    }

    $nom = $_SESSION['nom'] ?? 'Utilisateur';
    $email = $_SESSION['email'] ?? 'inconnu';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil Utilisateur</title>
    <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../fontawesome/css/all.min.css">
    <style>
        body {
            background: #f8f9fa;
        }
        .card-custom {
            border-radius: 1rem;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .profile-icon {
            font-size: 4rem;
        }
    </style>
</head>
<body>
    <?php 
        $basePath = '../../';
        include '../../includes/menu.php'; 
    ?>

    <div class="container mt-5 py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-custom p-4">
                    <div class="text-center mb-4">
                        <div class="profile-icon text-primary">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <h4 class="mt-3">Bonjour <?php echo htmlspecialchars($nom); ?> 👋</h4>
                        <p class="text-muted">Voici votre espace personnel</p>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <h5>Vos informations :</h5>
                        <ul class="list-group">
                            <li class="list-group-item"><strong>Nom :</strong> <?php echo htmlspecialchars($nom); ?></li>
                            <li class="list-group-item"><strong>Email :</strong> <?php echo htmlspecialchars($email); ?></li>
                            <li class="list-group-item"><strong>Rôle :</strong> Utilisateur</li>
                        </ul>
                    </div>
                    <div class="text-end">
                        <a href="#" class="btn btn-primary">Voir mes données</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap icons -->
    <link rel="stylesheet" href="../../bootstrap-icons/bootstrap-icons.css">
    <script src="../../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
