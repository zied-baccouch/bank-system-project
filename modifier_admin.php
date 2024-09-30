<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Admin</title>

    <!-- Ajout du CDN Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            width: 50%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            padding: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }
    </style>
</head>

<body>

<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bank";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['matricule'])) {
    $matricule = $conn->real_escape_string($_POST['matricule']);

    // Requête SQL pour récupérer les informations de l'admin
    $sql = "SELECT * FROM admin WHERE matricule = '$matricule'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nom = $row['nom'];
        $prenom = $row['prenom'];
        // Ajoutez d'autres champs si nécessaire
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modifier'])) {
    // Récupérez les nouvelles valeurs des champs
    $newMatricule = $conn->real_escape_string($_POST['new_matricule']);
    $newNom = $conn->real_escape_string($_POST['new_nom']);
    $newPrenom = $conn->real_escape_string($_POST['new_prenom']);
    // Ajoutez d'autres champs si nécessaire

    // Requête SQL pour mettre à jour les informations de l'admin
    $updateSql = "UPDATE admin SET matricule='$newMatricule', nom='$newNom', prenom='$newPrenom' WHERE matricule='$matricule'";

    if ($conn->query($updateSql) === TRUE) {
        echo '<script>alert("Modification réussie.");</script>';
        // Redirigez vers la page d'affichage des admins après la modification
        header("Location: option_chef.html");
        exit();
    } else {
        echo '<script>alert("Échec de la modification.");</script>';
    }
}

$conn->close();
?>

<form method="post" action="">
    <label for="matricule">Matricule:</label>
    <input type="text" name="new_matricule" value="<?php echo $matricule; ?>" required>

    <label for="nom">Nom:</label>
    <input type="text" name="new_nom" value="<?php echo $nom; ?>" required>

    <label for="prenom">Prénom:</label>
    <input type="text" name="new_prenom" value="<?php echo $prenom; ?>" required>

    <!-- Ajoutez d'autres champs si nécessaire -->

    <input type="hidden" name="matricule" value="<?php echo $matricule; ?>">
    <button type="submit" name="modifier">Modifier</button>
</form>

<!-- Ajout du script Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>

</html>
