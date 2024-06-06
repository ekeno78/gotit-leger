<?php
// Connexion à la base de données
$servername = "172.16.196.254";
$username = "eva";
$password = "eva";

try {
    $bdd = new PDO("mysql:host=$servername;dbname=gotit", $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les données des lieux avec les poissons correspondants
    $stmt = $bdd->query("SELECT lieux.*, GROUP_CONCAT(poisson.NomPoisson SEPARATOR ', ') AS poissons
                        FROM lieux
                        LEFT JOIN Contenir ON lieux.Id_lieux = Contenir.Id_lieux
                        LEFT JOIN poisson ON Contenir.IdPoisson = poisson.IdPoisson
                        GROUP BY lieux.Id_lieux");
    $lieux = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Map des Spots de Pêche</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin="" />
    <link rel="stylesheet" href="./map.css">

    <style>
        /* Ajouter le style pour le conteneur de la carte */
        #map-container {
            margin-top: 160px; /* Ajustez la marge en haut pour compenser la hauteur de la barre de navigation */
            height: calc(100vh - 250px); /* Utilisation de calc pour ajuster la hauteur de la carte en fonction de la hauteur de la fenêtre du navigateur */
            filter: hue-rotate(0deg); /* Transformer la couleur de la mer en rose */
        }

        #map {
            height: 150%;
            width: 100%;
            border: 2px solid #ccc; /* Ajoutez une bordure pour plus de clarté */
            border-radius: 10px; /* Ajoutez un peu de style à la bordure */
        }
        
        .logo {
            width: 150px;
            height: auto;
        }
    </style>
</head>
<body>
<header>
    <a href="#"><img src="../../image/logo.png" alt="Logo" class="logo"></a>
    <nav class="navigation">
        <a href="../../index.html">Accueil</a>
        <a href="./leaflet.php">Map</a>
        <a href="../repertoire/repertoire.php">Répertoire</a>
        <a href="../recherche/rechercheB.html">Recherche</a>
        <button class="btnLogin-popup">Connexion</button>
    </nav>
</header>
<div id="map-container">
    <div id="map"></div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>
<script>
    var map = L.map('map').setView([46.166667, -1.150000], 7);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    <?php foreach ($lieux as $lieu) : ?>
        L.marker([<?= $lieu['latitude'] ?>, <?= $lieu['longitude'] ?>], {
            icon: L.icon({
                iconUrl: '../../image/marker.png', // Utilisation de l'image personnalisée
                iconSize: [40, 40], // Taille de l'icône
                iconAnchor: [15, 30], // Point d'ancrage de l'icône
                popupAnchor: [0, -30] // Point d'ancrage du popup
            })
        }).addTo(map).bindPopup("<b><?= $lieu['nom'] ?></b><br>Poissons: <?= $lieu['poissons'] ?>");
    <?php endforeach; ?>

    // Centrer la carte et la placer en bas de la page
    map.invalidateSize();
    map.setView([46.166667, -1.150000], 7);
</script>
</body>
</html>
