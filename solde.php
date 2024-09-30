<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation Solde</title>

    <!-- Ajout du CDN Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column; /* Allow the header to be on top */
            align-items: center;
        }

        header {
            text-align: center;
            padding: 20px 0;
        }

        header img {
            max-width: 100%;
            height: auto;
            border-bottom: 2px solid #007bff; /* Optional border below the image */
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
            margin-top: 20px; /* Adjusted margin-top for spacing */
        }

        /* Rest of your existing styles... */

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

        .result-container {
        margin-top: 20px;
        text-align: center;
    }

    .result {
        background-color: #d4edda;
        color: #155724;
        padding: 10px;
        border: 1px solid #c3e6cb;
        border-radius: 5px;
        margin-top: 10px;
    }

    .error {
        background-color: #f8d7da;
        color: #721c24;
        padding: 10px;
        border: 1px solid #f5c6cb;
        border-radius: 5px;
        margin-top: 10px;
    }
    </style>
</head>

<body>

    <header>
        <img src="background.png" alt="Background Image">
    </header>

<div class="container">
    <h2>Consultation Solde</h2>

    <form action="" method="post">
        <div class="form-group">
            <label for="num_cin">Numéro CIN:</label>
            <input type="text" id="num_cin" name="num_cin" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Consulter Solde</button>
    </form>

    <!-- Affichage du solde ou message d'erreur -->
    <?php
    // Assurez-vous que vous avez déjà une connexion active à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bank";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['num_cin'])) {
        $numCIN = $_POST['num_cin'];

        // Requête SQL pour récupérer le solde de l'utilisateur
        $sql = "SELECT solde FROM users WHERE num_cin = '$numCIN'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $solde = $row['solde'];
            echo "<div class='result-container'><div class='result'>Solde actuel: $solde</div></div>";
        } else {
            echo "<div class='result-container'><div class='error'>Utilisateur non trouvé.</div></div>";
        }
    }

    // N'oubliez pas de fermer la connexion à la base de données à la fin de la page
    $conn->close();
    ?>
</div>

<!-- Ajout du script Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
