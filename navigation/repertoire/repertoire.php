<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REPERTOIRE DES POISSONS</title>
    <link rel="stylesheet" href="./repertoire.css">
  
</head>

<body>
    <header>
        <h2 class="recherche">Répertoire</h2>
        <nav class="navigation">
            <a href="../../index.html">Accueil</a>
            <a href="../map/leaflet.php">Map</a>
            <a href="./repertoire.php">Répertoire</a>
            <a href="../recherche/rechercheB.html">Recherche</a>
            <button class="btnLogin-popup">Connexion</button>
        </nav>
    </header>






<?php

$servername = "172.16.196.254";
$username = "eva";
$password = "eva";

try{
    $bdd = new PDO("mysql:host=$servername; dbname=gotit", $username,$password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "connexion réussie ☺";

    $sql = "SELECT IdPoisson, NomPoisson, NomLatinPoisson, DescriptionPoisson FROM poisson";
    $result = $bdd->query($sql);

    echo "<table class='table table-bordered'>";
    echo "<tr>";
    echo "<th><p class=''>Id</p></th>";
    echo "<th><p class=''>Poisson</p></th>";
    echo "<th><p class=''>Nom Latin </p></th>";
    echo "<th><p class=''>Description</p></th>";
    echo "</tr>";

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $row["IdPoisson"] . "</td>";
        echo "<td>" . $row["NomPoisson"] . "</td>";
        echo "<td>" . $row["NomLatinPoisson"] . "</td>";
        echo "<td>" . $row["DescriptionPoisson"] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
}
catch(PDOException $e){
    echo "Erreur  : ".$e->getMessage();
}
?>
</body>
</html>