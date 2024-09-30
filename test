<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Récupérer les données du formulaire
    $num_cin = $_POST["num_cin"];
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $sexe = $_POST["sexe"];
    $date_nais = $_POST["date_nais"];
    $numero_tel = $_POST["numero_tel"];
    $adresse = $_POST["adresse"];
    $profession = $_POST["profession"];
    $solde = $_POST["solde"];

    // Connexion à la base de données
    $servername = "localhost";  // Mettez le nom de votre serveur MySQL
    $username = "root"; // Mettez votre nom d'utilisateur MySQL
    $password = ""; // Mettez votre mot de passe MySQL
    $dbname = "bank"; // Mettez le nom de votre base de données

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion à la base de données
    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    // Préparer la requête SQL d'insertion
    $sql = "INSERT INTO users (num_cin, nom, prenom, sexe, date_nais, numero_tel, adresse, profession, solde)
            VALUES ('$num_cin', '$nom', '$prenom', '$sexe', '$date_nais', '$numero_tel', '$adresse', '$profession', '$solde')";

    // Exécuter la requête SQL
    if ($conn->query($sql) === TRUE) {
        echo "Les données ont été insérées avec succès dans la table users.";
    } else {
        echo "Erreur lors de l'insertion des données : " . $conn->error;
    }

    // Fermer la connexion à la base de données
    $conn->close();
}
?>

