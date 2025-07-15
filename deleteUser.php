<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Inclure le fichier de connexion a la base de données
    include 'includes/sign_in_db.php';
    // Verifier la connexion a la base
    include 'includes/db_connected_verify.php';
    // Inclure la fonction de suppression
    include 'includes/user_functions.php';

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
