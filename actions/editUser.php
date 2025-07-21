<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include '../includes/sign_in_db.php'; // Inclure le fichier de connexion a la base
    include '../includes/db_connected_verify.php'; // Verifier la connexion a la base
    include '../includes/user_functions.php'; // Inclure le fichier des fonctions de l'utilisateur

    // Si le formulaire est soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_GET['id'])) {
            header("Location: ../pages/admin/listUsers.php");
            exit();
        }
        // Condition a la soumission du formulaire en appuyant sur Enregistrer
        // Utile pour la gestion de plusieurs formulaire sur la meme page ou plusieurs boutons a gérer
        if(isset($_POST['updateUser'])) {

            $id = $_GET['id'];
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            // Vérifier si l'email existe déjà pour un autre utilisateur
            $sql = "SELECT COUNT(*) FROM utilisateurs WHERE email = :email AND id != :id";
            $stmt = $bdd->prepare($sql);
            $stmt->execute([
                ':email' => $email,
                ':id'    => $id
            ]);
            $nbDoublons = $stmt->fetchColumn();

            // SI les champs sont vides
            if (empty($name) || 
                empty($email)) {
                // Si les champs sont vides
                header("Location: ../forms/editpage.php?id=$id&error=champsvides"); 
                exit();

            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // si l'email est invalide
                header("Location: ../forms/editpage.php?id=$id&error=emailinvalide");
                exit();

            } elseif ($nbDoublons > 0) {
                // Redirection avec message d'erreur si email déjà utilisé
                header("Location: ../forms/editpage.php?id=$id&error=emailpris");
                exit();
            }
            else {
                // Appeler la fonction updateUser si tout va bien
                updateUser($bdd, $id, $name, $email);

                header("Location: ../pages/admin/listUsers.php?success=edited");
                exit();
            }
        }
    }
?>
