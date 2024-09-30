<?php
$connect = mysqli_connect("localhost", "root", "", "bank");

if (!$connect) {
    die("La connexion a échoué : " . mysqli_connect_error());
}

if (isset($_POST["submit"])) {
    // Vérifie si tous les champs sont remplis
    if (empty($_POST['nom']) || empty($_POST['prenom']) || empty($_POST['matricule'])) {
        echo "<script> alert('Veuillez remplir tous les champs!'); </script>";
    } else {
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $matricule = $_POST["matricule"];

        // Vérifie si le matricule est déjà présent dans la table admin
        $dup = mysqli_query($connect, "SELECT * FROM admin WHERE matricule = '$matricule'");
        if (mysqli_num_rows($dup) > 0) {
            echo "<script> alert('L'utilisateur existe déjà.'); </script>";
        } else {
            // Utilisation de requêtes préparées pour éviter les attaques par injection SQL
            $query = "INSERT INTO admin (matricule, nom, prenom) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($connect, $query);

            // Liaison des paramètres
            mysqli_stmt_bind_param($stmt, "sss", $matricule, $nom, $prenom);

            // Exécution de la requête
            if (mysqli_stmt_execute($stmt)) {
                echo "<script> alert('Enregistrement réussi.'); </script>";
            } else {
                echo "<script> alert('Erreur lors de l'enregistrement.'); </script>";
            }

            // Fermeture de la requête préparée
            mysqli_stmt_close($stmt);
        }
    }
}

// Fermeture de la connexion à la base de données
mysqli_close($connect);
?>
