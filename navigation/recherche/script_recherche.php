<?php 
// Récupération du mot-clé de recherche depuis la requête GET
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

// Informations de connexion à la base de données
$servername = "172.16.196.254";
$username = "eva";
$password = "eva";

try{
    // Connexion à la base de données MySQL en utilisant PDO
    $bdd = new PDO("mysql:host=$servername; dbname=gotit", $username,$password);
    // Configuration du mode d'affichage des erreurs PDO pour faciliter le débogage
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}

catch(PDOException $e){
    // En cas d'erreur lors de la connexion à la base de données, affichage de l'erreur
    echo "Erreur  : ".$e->getMessage();
}

// Ajout du caractère % à la fin du mot-clé pour rechercher les poissons commençant par cette lettre
$keyword = $keyword . '%';

// Préparation de la requête SQL pour sélectionner le nom des poissons qui correspondent au mot-clé
$smtp = $bdd->prepare("SELECT * FROM poisson WHERE NomPoisson LIKE :keyword ");
// Exécution de la requête en remplaçant :keyword par la valeur du mot-clé
$smtp->execute(array(
    ":keyword"=>$keyword));
// Récupération des résultats sous forme de tableau associatif
$res = $smtp->fetchAll(PDO::FETCH_ASSOC);

// Conversion du tableau associatif en format JSON et affichage du résultat
echo json_encode($res);

?>
