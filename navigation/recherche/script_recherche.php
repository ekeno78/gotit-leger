<?php 
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

$servername = "172.16.196.254";
$username = "eva";
$password = "eva";

try{
    $bdd = new PDO("mysql:host=$servername; dbname=gotit", $username,$password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}

catch(PDOException $e){
    echo "Erreur  : ".$e->getMessage();
}

$smtp = $bdd->prepare("SELECT * FROM poisson WHERE NomPoisson LIKE :keyword ");
$smtp->execute(array(
    ":keyword"=>'%'.$keyword.'%'));
$res = $smtp->fetchALl(PDO::FETCH_ASSOC);

echo json_encode($res);

?>