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
        $email = $_SESSION['email'];
        $oldPassword = $_POST['old_password'];
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];

        // Vérifier si les champs sont vides
        if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
            header("Location: ../pages/change_password.php?error=champsvides");
            exit();
        }

        // Vérifier si les nouveaux mots de passe correspondent
        if ($newPassword !== $confirmPassword) {
            header("Location: ../pages/change_password.php?error=password_do_not_match");
            exit();
        }

        // Vérifier si le nouveau mot de passe est suffisamment long
        if (strlen($newPassword) < 8) {
            header("Location: ../pages/change_password.php?error=password_short");
            exit();
        }

        // Vérifier la complexité du mot de passe
        if (!preg_match('/[A-Z]/', $newPassword) || 
            !preg_match('/[0-9]/', $newPassword) || 
            !preg_match('/[!@#$%^&*()_+=\-]/', $newPassword)) {

            header("Location: ../pages/change_password.php?error=password_weak");
            exit();
        }

        // Vérifier si l'ancien mot de passe est le même que le nouveau
        if ($oldPassword === $newPassword) {
            header("Location: ../pages/change_password.php?error=same_password");
            exit();
        }

        // Vérifier que l’ancien mot de passe est correct et changer le mot de passe
        $success = changePassword($email, $oldPassword, $newPassword, $bdd);

        if (!$success) {
            header("Location: ../pages/change_password.php?error=password_incorrect");
            exit();
        }

        // Succès
        header("Location: ../pages/change_password.php?success=1");
        exit();
    }

?>