<?php

include 'index.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $identifiant = $_POST['Identifiant'];
    $email = $_POST['Email_utilisateur'];
    // hachage du mot de passe 
    $password = password_hash($_POST['Password_utilisateur'], PASSWORD_DEFAULT);
    $role = 'user'; // Attribuer le rôle 'user' à chaque nouvel utilisateur


    $requete = $bdd->prepare("INSERT INTO utilisateurs (Identifiant, Email_utilisateur, Password_utilisateur, Role) VALUES (:Identifiant, :Email_utilisateur, :Password_utilisateur, :Role)");
    $requete->execute(
        array(
            "Identifiant" => $identifiant,
            "Email_utilisateur" => $email,
            "Password_utilisateur" => $password,
            "Role" => $role // Ajouter le rôle à l'array de paramètres
        )
    );
    header("Location: ../index.html");
    exit();
}

?>
