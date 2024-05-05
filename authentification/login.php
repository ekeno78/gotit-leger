<?php
// Inclure la configuration de la base de données et autres fichiers nécessaires
include 'index.php'; // Fichier contenant la connexion à la base de données
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['Email_utilisateur'];
    $password = $_POST['Password_utilisateur'];

    if ($email != "" && $password != "") {
        // Vérification de l'authentification dans la base de données
        $req = $bdd->prepare("SELECT * FROM utilisateurs WHERE Email_utilisateur = ?");
        $req->execute([$email]);
        $utilisateur = $req->fetch(PDO::FETCH_ASSOC);

        if ($utilisateur) {
            // Essayez de vérifier le mot de passe crypté en premier
            if (password_verify($password, $utilisateur['Password_utilisateur']) || $password == $utilisateur['Password_utilisateur']) {
                // Authentification réussie
                // Stocker des informations sur l'utilisateur dans la session
                $_SESSION['utilisateur'] = $utilisateur;

                // Rediriger tous les utilisateurs vers la même page après connexion
                header("Location: ../index.html");
                exit();
            } else {
                // Authentification échouée, rediriger vers une page de connexion avec un message d'erreur
                header("Location: login.php?error=auth_failed");
                exit();
            }
        } else {
            // Pas d'utilisateur trouvé avec cet email
            header("Location: login.php?error=auth_failed");
            exit();
        }
    }
}
?>
