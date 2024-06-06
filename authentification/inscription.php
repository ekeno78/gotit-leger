<?php
// Vérifie s'il y a un paramètre 'error' dans l'URL et affiche un message d'erreur le cas échéant
if (isset($_GET['error'])) {
    echo '<p style="color:red;">' . htmlspecialchars($_GET['error']) . '</p>';
}
?>

<?php
// Inclusion du fichier de connexion à la base de données
include 'index.php';

// Démarre une session PHP pour gérer les sessions utilisateur
session_start();

// Vérifie si la requête est de type POST (soumission du formulaire)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupère les valeurs des champs du formulaire pour éviter les erreurs si les champs sont vides
    $identifiant = $_POST['Identifiant'] ?? '';
    $email = $_POST['Email_utilisateur'] ?? '';
    $password = $_POST['Password_utilisateur'] ?? '';

    // Vérifie que tous les champs du formulaire sont remplis
    if (!empty($identifiant) && !empty($email) && !empty($password)) {
        // Hachage du mot de passe 
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $role = 'user'; // Attribue le rôle 'user' à chaque nouvel utilisateur par défaut

        try {
            // Prépare la requête d'insertion dans la base de données
            $requete = $bdd->prepare("INSERT INTO utilisateurs (Identifiant, Email_utilisateur, Password_utilisateur, Role)
             VALUES (:Identifiant, :Email_utilisateur, :Password_utilisateur, :Role)");
            
            // Exécute la requête avec les valeurs fournies par l'utilisateur
            $requete->execute([
                "Identifiant" => $identifiant,
                "Email_utilisateur" => $email,
                "Password_utilisateur" => $hashed_password,
                "Role" => $role
            ]);

            // Redirige l'utilisateur vers la page d'accueil en cas de succès
            header("Location: ../index.html");
            exit();
        } catch (PDOException $e) {
            // En cas d'erreur pendant l'insertion, redirige vers la page d'inscription avec un message d'erreur
            $error = "Erreur lors de l'inscription : " . $e->getMessage();
            header("Location: inscription.php?error=" . urlencode($error));
            exit();
        }
    } else {
        // Si tous les champs ne sont pas remplis, redirige vers la page d'inscription avec un message d'erreur
        $error = "Veuillez remplir tous les champs.";
        header("Location: inscription.php?error=" . urlencode($error));
        exit();
    }
}
?>
