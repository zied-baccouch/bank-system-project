<?php
// Inclure la bibliothèque TCPDF
require_once('tcpdf/tcpdf.php');

// Initialiser les variables
$errorMessage = "";

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['num_cin']) && isset($_POST['date_debut']) && isset($_POST['date_fin'])) {
    $numCIN = $_POST['num_cin'];
    $dateDebut = $_POST['date_debut'];
    $dateFin = $_POST['date_fin'];

    // Connexion à la base de données avec PDO
    $dsn = "mysql:host=localhost;dbname=bank";
    $username = "root";
    $password = "";

    try {
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Vérifier si le numéro CIN existe dans la base de données
        $checkUserSql = "SELECT * FROM users WHERE num_cin = :numCIN";
        $checkUserStmt = $pdo->prepare($checkUserSql);
        $checkUserStmt->bindParam(':numCIN', $numCIN, PDO::PARAM_STR);
        $checkUserStmt->execute();

        if ($checkUserStmt->rowCount() > 0) {
            // Le numéro CIN existe, récupérer les informations de l'utilisateur
            $userRow = $checkUserStmt->fetch(PDO::FETCH_ASSOC);
            $nom = $userRow['nom'];
            $prenom = $userRow['prenom'];

            // Créer un nouvel objet PDF
            $pdf = new TCPDF();

            // Définir les données d'en-tête et de pied de page
            $pdf->SetHeaderData('background.png', 210, 'Extrait de compte', 'Header');
            $pdf->setFooterData(['0', 64, 0], ['0', 64, 0]);

            // Ajouter une page au PDF
            $pdf->AddPage();

            // Ajouter du texte au PDF avec les informations de l'extrait
            $pdf->SetFont('helvetica', 'B', 14);
            $pdf->Cell(190, 10, 'Extrait de compte pour ' . $prenom . ' ' . $nom . ' (' . $numCIN . ') du ' . $dateDebut . ' au ' . $dateFin, 0, 1, 'C');

            // Ajouter du style CSS pour les données de la table "ajout"
            $style = '<style>
                        .ajout-table {
                            width: 100%;
                            border-collapse: collapse;
                            margin-top: 10px;
                        }
                        .ajout-table th, .ajout-table td {
                            border: 1px solid #ddd;
                            padding: 8px;
                            text-align: left;
                        }
                        .ajout-header {
                            background-color: #f2f2f2;
                            font-weight: bold;
                        }
                        .ajout-title {
                            color: #3366cc; /* Change color to your preference */
                            font-size: 18px;
                            margin-top: 20px;
                        }
                    </style>';
            $pdf->writeHTML($style, true, false, false, false, '');

            // Afficher les données de la table "ajout"
            $ajoutSql = "SELECT * FROM ajout WHERE num_cin = :numCIN AND date BETWEEN :dateDebut AND :dateFin";
            $ajoutStmt = $pdo->prepare($ajoutSql);
            $ajoutStmt->bindParam(':numCIN', $numCIN, PDO::PARAM_STR);
            $ajoutStmt->bindParam(':dateDebut', $dateDebut, PDO::PARAM_STR);
            $ajoutStmt->bindParam(':dateFin', $dateFin, PDO::PARAM_STR);
            $ajoutStmt->execute();

            if ($ajoutStmt->rowCount() > 0) {
                $pdf->Cell(190, 10, 'Ajouts:', 0, 1, '', 0, '', 0, true, 'C');
                $pdf->SetTextColor(51, 102, 204); // Change color to your preference

                // Utiliser writeHTML pour ajouter le tableau avec les données
                $html = '<table class="ajout-table">';
                $html .= '<tr class="ajout-header"><th>Date</th><th>Montant</th></tr>';
                while ($row = $ajoutStmt->fetch(PDO::FETCH_ASSOC)) {
                    $html .= '<tr><td>' . $row['date'] . '</td><td>' . $row['montant'] . ' dt</td></tr>';
                }
                $html .= '</table>';

                $pdf->writeHTML($html, true, false, false, false, '');
            }

            // Ajouter du style CSS pour les données de la table "retirer"
            $style = '<style>
                        .retirer-table {
                            width: 100%;
                            border-collapse: collapse;
                            margin-top: 10px;
                        }
                        .retirer-table th, .retirer-table td {
                            border: 1px solid #ddd;
                            padding: 8px;
                            text-align: left;
                        }
                        .retirer-header {
                            background-color: #f2f2f2;
                            font-weight: bold;
                        }
                        .retirer-title {
                            color: #ff3300; /* Change color to your preference */
                            font-size: 18px;
                            margin-top: 20px;
                        }
                    </style>';
            $pdf->writeHTML($style, true, false, false, false, '');

            // Afficher les données de la table "retirer"
            $retirerSql = "SELECT * FROM retirer WHERE num_cin = :numCIN AND date BETWEEN :dateDebut AND :dateFin";
            $retirerStmt = $pdo->prepare($retirerSql);
            $retirerStmt->bindParam(':numCIN', $numCIN, PDO::PARAM_STR);
            $retirerStmt->bindParam(':dateDebut', $dateDebut, PDO::PARAM_STR);
            $retirerStmt->bindParam(':dateFin', $dateFin, PDO::PARAM_STR);
            $retirerStmt->execute();

            if ($retirerStmt->rowCount() > 0) {
                $pdf->Cell(190, 10, 'Retraits:', 0, 1, '', 0, '', 0, true, 'C');
                $pdf->SetTextColor(255, 51, 0); // Change color to your preference

                // Utiliser writeHTML pour ajouter le tableau avec les données
                $html = '<table class="retirer-table">';
                $html .= '<tr class="retirer-header"><th>Date</th><th>Montant</th></tr>';
                while ($row = $retirerStmt->fetch(PDO::FETCH_ASSOC)) {
                    $html .= '<tr><td>' . $row['date'] . '</td><td>' . $row['montant'] . ' dt</td></tr>';
                }
                $html .= '</table>';

                $pdf->writeHTML($html, true, false, false, false, '');
            }

            // Nom du fichier PDF généré
            $filename = 'extrait_compte.pdf';

            // Sortie du PDF en téléchargement
            $pdf->Output($filename, 'D');
            $pdf->close();
        } else {
            // Le numéro CIN n'existe pas dans la base de données
            $errorMessage = "Erreur: Le numéro CIN n'appartient à aucun utilisateur.";
        }
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    } finally {
        // Fermeture de la connexion à la base de données
        $pdo = null;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Extrait de Compte</title>

    <!-- Ajout du CDN Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h2>Demande d'Extrait de Compte</h2>

    <!-- Affichage de l'erreur si elle existe -->
    <?php if (!empty($errorMessage)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $errorMessage; ?>
        </div>
    <?php endif; ?>

    <form action="" method="post">
        <div class="form-group">
            <label for="num_cin">Numéro CIN :</label>
            <input type="text" id="num_cin" name="num_cin" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="date_debut">Date de début :</label>
            <input type="date" id="date_debut" name="date_debut" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="date_fin">Date de fin :</label>
            <input type="date" id="date_fin" name="date_fin" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Générer Extrait PDF</button>
    </form>
</div>

<!-- Ajout du script Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
