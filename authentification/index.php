<?php

// Définition des paramètres de connexion à la base de données
$servername = "172.16.196.254"; // Adresse du serveur de la base de données
$username = "eva"; // Nom d'utilisateur pour se connecter à la base de données
$password = "eva"; // Mot de passe pour se connecter à la base de données

try {
    // Création d'une nouvelle instance de l'objet PDO pour se connecter à la base de données
    $bdd = new PDO("mysql:host=$servername;dbname=gotit", $username, $password);

    // Configuration de l'attribut PDO pour lever des exceptions en cas d'erreurs
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   
} catch (PDOException $e) {
    // Capture et affichage des erreurs de connexion à la base de données
    echo "Erreur : " . $e->getMessage();
}
?>
