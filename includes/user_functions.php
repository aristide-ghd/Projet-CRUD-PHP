<?php
    // Fonction pour créer un utilisateur
    function createUser($bdd, $name, $email, $password) {
        // Hachage du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Préparer la requête
        $sql = "INSERT INTO utilisateurs (nom, email, mot_de_passe) VALUES (:nom, :email, :mot_de_passe)";
        $stmt = $bdd -> prepare($sql);

        // Exécuter la requête
        $stmt -> execute([
            ':nom' => $name,
            ':email' => $email,
            ':mot_de_passe' => $hashedPassword
        ]);
    }

    // Fonction pour se connecter
    function loginUser($email, $bdd) {
        $stmt = $bdd -> prepare("SELECT * FROM utilisateurs WHERE email = :email");
        $stmt -> bindParam(':email', $email);
        $stmt -> execute();

        return $stmt -> fetch(PDO::FETCH_ASSOC);
    }

    // Liste des utilisateurs
    function readUsers($bdd) {
        $sql = "SELECT id, nom, email, role FROM utilisateurs";
        $stmt = $bdd -> prepare($sql);
        $stmt -> execute();
        
        // Retourner tous les utilisateurs avec fetch pour obtenir un tableau de résultats
        return $stmt -> fetchAll();
    }

    // Modification d'un utilisateur
    function updateUser($bdd, $id, $nom, $email) {
        $sql = "UPDATE utilisateurs SET nom = :nom, email = :email WHERE id = :id";
        $stmt = $bdd -> prepare($sql);
        $stmt -> execute([
            ':nom'   => $nom,
            ':email' => $email,
            ':id'    => $id
        ]);
    }

    // Suppression d'un utilisateur
    function deleteUser($bdd, $id) {
        $sql = "DELETE FROM utilisateurs WHERE id = :id";
        $stmt = $bdd -> prepare($sql);
        $stmt -> execute([':id' => $id]);
    }

    // Fonction pour changer le mot de passe après vérification de l'ancien
    function changePassword($email, $oldPassword, $newPassword, $bdd) {
        // Récupérer l'utilisateur
        $stmt = $bdd -> prepare("SELECT mot_de_passe FROM utilisateurs WHERE email = :email");
        $stmt -> bindParam(':email', $email);
        $stmt -> execute();
        $user = $stmt -> fetch(PDO::FETCH_ASSOC);

        // Vérifier si l'utilisateur existe et que l'ancien mot de passe est correct
        if ($user && password_verify($oldPassword, $user['mot_de_passe'])) {
            // Hacher le nouveau mot de passe
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Mettre à jour le mot de passe
            $updateStmt = $bdd -> prepare("UPDATE utilisateurs SET mot_de_passe = :newPassword WHERE email = :email");
            $updateStmt -> bindParam(':newPassword', $hashedPassword);
            $updateStmt -> bindParam(':email', $email);

            return $updateStmt -> execute(); // true si la mise à jour a réussi
        } else {
            return false; // Ancien mot de passe incorrect
        }
    }

?>