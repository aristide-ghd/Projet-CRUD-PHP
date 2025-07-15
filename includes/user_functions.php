<?php
    // Fonction pour créer un utilisateur
    function createUser($bdd, $name, $email, $password,) {
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

    // Liste des utilisateurs
    function readUsers($bdd) {
        $sql = "SELECT id, nom, email, role FROM utilisateurs";
        $stmt = $bdd -> prepare($sql);
        $stmt -> execute();
        
        // Retourner tous les utilisateurs avec fetch pour obtenir un tableau de résultats
        return $stmt->fetchAll();
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
?>