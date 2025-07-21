<?php
    session_start(); // Initialiser la session
    session_regenerate_id(true); // Regenere l'id de session pour plus de securité

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Inclure le fichier de connexion
    include '../includes/sign_in_db.php';
    // Verifier la connexion a la base de données
    include '../includes/db_connected_verify.php';
    // Inclure la fonction pour créer un utilisateur
    include '../includes/user_functions.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        if (empty($email) || empty($password)) {

            header("Location: ../index.php?error=champsvides");
            exit();
        }

        $utilisateur = loginUser($email, $bdd);

        if ($utilisateur) {
            if (password_verify($password, $utilisateur['mot_de_passe'])) {

                $_SESSION['id'] = $utilisateur['id'];
                $_SESSION['email'] = $utilisateur['email'];
                $_SESSION['nom'] = $utilisateur['nom'];
                $_SESSION['role'] = $utilisateur['role'];
                $_SESSION['logged_in'] = true; 

                header("Location: ../index.php?success=1");
                exit();

            } else {
                header("Location: ../index.php?error=motdepasseincorrect");
                exit();
            }
        } else {
            header("Location: ../index.php?error=emailinconnu");
            exit();
        }
    }
?>