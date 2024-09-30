<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout de Montant</title>

    <!-- Ajout du CDN Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 50%;
            margin: auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            padding: 30px;
            animation: fadeIn 1s ease-in-out;
            border-radius: 10px;
            transition: box-shadow 0.3s ease-in-out;
        }

        .container:hover {
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #007bff;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            transition: border-color 0.3s ease-in-out;
        }

        input:focus {
            border-color: #007bff;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease-in-out;
        }

        button:hover {
            background-color: #0056b3;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 10px;
            font-size: 18px;
            text-align: center;
            margin-top: 20px;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 10px;
            font-size: 18px;
            text-align: center;
            margin-top: 20px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
    </style>
</head>
<body>
<?php
// Assurez-vous que vous avez déjà une connexion active à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bank";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['num_cin']) && isset($_POST['montant'])) {
    $numCIN = $_POST['num_cin'];
    $montant = $_POST['montant'];
    $date = date('Y-m-d'); // Obtient la date actuelle au format 'YYYY-MM-DD'

    // Vérifier si le numéro CIN existe dans la table 'users'
    $checkUserSql = "SELECT * FROM users WHERE num_cin = '$numCIN'";
    $userResult = $conn->query($checkUserSql);

    if ($userResult->num_rows > 0) {
        // Le numéro CIN existe, exécuter la requête d'insertion et de mise à jour
        $sql = "INSERT INTO ajout (num_cin, montant, date) VALUES ('$numCIN', '$montant', '$date');";
        $sql .= "UPDATE users SET solde = solde + '$montant' WHERE num_cin = '$numCIN'";

        if ($conn->multi_query($sql) === TRUE) {
            $successMessage = "Montant ajouté avec succès! Solde mis à jour.";
        } else {
            $errorMessage = "Erreur lors de l'ajout du montant: " . $conn->error;
        }
    } else {
        // Le numéro CIN n'existe pas dans la table 'users'
        $errorMessage = "Erreur: Le numéro CIN n'appartient à aucun utilisateur.";
    }
}

// N'oubliez pas de fermer la connexion à la base de données à la fin de la page
$conn->close();
?>

<div class="container">
    <h2>Ajout de Montant</h2>

    <form action="" method="post">
        <div class="form-group">
            <label for="num_cin">Numéro CIN:</label>
            <input type="text" id="num_cin" name="num_cin" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="montant">Montant à envoyer:</label>
            <input type="text" id="montant" name="montant" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Envoyer Montant</button>
    </form>

    <!-- Affichage du résultat -->
    <?php if (isset($successMessage)): ?>
        <div class="success"><?php echo $successMessage; ?></div>
    <?php elseif (isset($errorMessage)): ?>
        <div class="error"><?php echo $errorMessage; ?></div>
    <?php endif; ?>
</div>

<!-- Ajout du script Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
