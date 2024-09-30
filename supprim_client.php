<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affichage et Modification des Utilisateurs</title>

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

        table {
            border-collapse: collapse;
            width: 80%;
            margin-top: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            padding: 20px;
            animation: fadeIn 1s ease-in-out;
        }

        th, td {
            border: 1px solid #dee2e6;
            text-align: left;
            padding: 12px;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        tbody tr:hover {
            background-color: #f2f2f2;
            transition: background-color 0.3s ease-in-out;
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

// Gestion de la suppression
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'supprimer' && isset($_POST['num_cin'])) {
    $numCIN = $_POST['num_cin'];

    // Requête SQL pour supprimer l'utilisateur avec le numéro CIN
    $sql = "DELETE FROM users WHERE num_cin = '$numCIN'";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Suppression réussie.");</script>';
    } else {
        echo '<script>alert("Échec de la suppression.");</script>';
    }
}

// Requête SQL pour sélectionner toutes les colonnes de la table 'users'
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Numéro CIN</th><th>Nom</th><th>Prénom</th><th>Sexe</th><th>Date de naissance</th><th>Numéro de téléphone</th><th>Adresse</th><th>Profession</th><th>Solde</th><th>Supprimer</th><th>modifier</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['num_cin']}</td>";
        echo "<td>{$row['nom']}</td>";
        echo "<td>{$row['prenom']}</td>";
        echo "<td>{$row['sexe']}</td>";
        echo "<td>{$row['date_nais']}</td>";
        echo "<td>{$row['numero_tel']}</td>";
        echo "<td>{$row['adresse']}</td>";
        echo "<td>{$row['profession']}</td>";
        echo "<td>{$row['solde']}</td>";
        echo "<td>
                <form method='post'>
                    <input type='hidden' name='num_cin' value='{$row['num_cin']}' />
                    <input type='hidden' name='action' value='supprimer' />
                    <button type='submit' class='btn btn-danger'>Supprimer</button>
                </form>
              </td>";
        echo "<td>
                <form action='modifier_utilisateur.php' method='post'>
                    <input type='hidden' name='num_cin' value='{$row['num_cin']}' />
                    <button type='submit' class='btn btn-primary'>Modifier</button>
                </form>
              </td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 résultats";
}

// Fermeture de la connexion à la base de données
$conn->close();
?>

<!-- Ajout du script Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
