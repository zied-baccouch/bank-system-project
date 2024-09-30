<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Utilisateur</title>

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
            margin: auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            padding: 20px;
            animation: fadeIn 1s ease-in-out;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
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

// Récupération du numéro CIN de l'utilisateur à modifier
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['num_cin'])) {
    $numCIN = $_POST['num_cin'];

    // Requête SQL pour sélectionner les données de l'utilisateur
    $sql = "SELECT * FROM users WHERE num_cin = '$numCIN'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Utilisateur non trouvé.";
        exit();
    }
} else {
    echo "Numéro CIN non spécifié.";
    exit();
}

// Gestion de la mise à jour
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'modifier') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $sexe = $_POST['sexe'];
    $date_nais = $_POST['date_nais'];
    $numero_tel = $_POST['numero_tel'];
    $adresse = $_POST['adresse'];
    $profession = $_POST['profession'];
    $solde = $_POST['solde'];

    // Requête SQL pour mettre à jour les données de l'utilisateur
    $sql = "UPDATE users SET 
            nom = '$nom',
            prenom = '$prenom',
            sexe = '$sexe',
            date_nais = '$date_nais',
            numero_tel = '$numero_tel',
            adresse = '$adresse',
            profession = '$profession',
            solde = '$solde'
            WHERE num_cin = '$numCIN'";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Mise à jour réussie.");</script>';
    } else {
        echo '<script>alert("Échec de la mise à jour.");</script>';
    }
}
?>

<form action="" method="post">
    <!-- Ajout d'un champ caché pour transmettre le numéro CIN -->
    <input type="hidden" name="num_cin" value="<?php echo $row['num_cin']; ?>">

    <label for="nom">Nom:</label>
    <input type="text" id="nom" name="nom" value="<?php echo $row['nom']; ?>" required>

    <label for="prenom">Prénom:</label>
    <input type="text" id="prenom" name="prenom" value="<?php echo $row['prenom']; ?>" required>

    <label for="sexe">Sexe:</label>
    <input type="text" id="sexe" name="sexe" value="<?php echo $row['sexe']; ?>" required>

    <label for="date_nais">Date de Naissance:</label>
    <input type="date" id="date_nais" name="date_nais" value="<?php echo $row['date_nais']; ?>" required>

    <label for="numero_tel">Numéro de Téléphone:</label>
    <input type="tel" id="numero_tel" name="numero_tel" value="<?php echo $row['numero_tel']; ?>" required>

    <label for="adresse">Adresse:</label>
    <input type="text" id="adresse" name="adresse" value="<?php echo $row['adresse']; ?>" required>

    <label for="profession">Profession:</label>
    <input type="text" id="profession" name="profession" value="<?php echo $row['profession']; ?>" required>

    <label for="solde">Solde:</label>
    <input type="number" id="solde" name="solde" value="<?php echo $row['solde']; ?>" required>

    <input type="hidden" name="action" value="modifier">
    <button type="submit" class="btn btn-primary">Modifier</button>
</form>

<!-- Ajout du script Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
