<?php
    // Mot de passe à hacher
    $motDePasse = "";

    // Génération du hash
    $hash = password_hash($motDePasse, PASSWORD_DEFAULT);

    // Affichage du hash
    echo "<h3>Mot de passe : $motDePasse</h3>";
    echo "<p><strong>Hash :</strong> $hash</p>";
?>