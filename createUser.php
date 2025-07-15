<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Inclure le fichier de connexion
    include 'includes/sign_in_db.php';
    // Verifier la connexion a la base de données
    include 'includes/db_connected_verify.php';
    // Inclure la fonction pour créer un utilisateur
    include 'includes/user_functions.php';

    // Vérifier si le formulaire a été soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupérer les données du formulaire
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $confirmPassword = trim($_POST['confirm_password']);

        // Vérifier si un des champs est vide
        if (empty($name) || 
            empty($email) || 
            empty($password) ||
            empty($confirmPassword)) {

            header("Location: index.php?error=champsvides");
            exit();
        }

        // Verifier la validité de l'email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: index.php?error=emailinvalide");
            exit();
        }

        // Vérifier si l'email existe déjà
        $sql = "SELECT * FROM utilisateurs WHERE email = :email";
        $stmt = $bdd->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        if ($user) {
            header("Location: index.php?error=emailexiste");
            exit();
        }

        // Validité du mot de passe
        if (strlen($password) < 8) {
            header("Location: index.php?error=passwordcourt");
            exit();
        }

        if (!preg_match('/[A-Z]/', $password) || 
            !preg_match('/[0-9]/', $password) || 
            !preg_match('/[!@#$%^&*()_+=\-]/', $password)) {

            header("Location: index.php?error=passwordfaible");
            exit();
        }

        // Vérifier si les mots de passe correspondent
        if ($password !== $confirmPassword) {
            header("Location: index.php?error=mdpnonidentique");
            exit();
        }

        // Appeler la fonction
        createUser($bdd, $name, $email, $password);

        header("Location: index.php?success=1");
        exit();
    }
?>
