<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include 'includes/sign_in_db.php'; // Inclure le fichier de connexion a la base de données
    include 'includes/db_connected_verify.php'; // Verifier la connexion a la base
    include 'includes/user_functions.php'; // Inclure la fonction de suppression

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        // appeler la fonction de suppression
        deleteUser($bdd,$id);

        header("Location: listUsers.php?success=deleted");
        exit();
    }
    else {
        header("Location: listUsers.php");
        exit();
    }
?>
