<?php

$servername = "172.16.196.254";
$username = "eva";
$password = "eva";

try{
    $bdd = new PDO("mysql:host=$servername; dbname=gotit", $username,$password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "connexion réussie ☺";

}
catch(PDOException $e){
    echo "Erreur  : ".$e->getMessage();
}

// test BDD insertion de données
//$bdd->exec("INSERT INTO utilisateurs (Identifiant, Email_utilisateur, Password_utilisateur) VALUES ('eva', 'eva@hotmail.com', 'eva')");


// URL API POISSON ET LIEU 
// 'https://hubeau.brgm-rec.fr/api/v1/etat_pisticole/observations?size=20'


?>

