<?php
$connect = mysqli_connect("localhost", "root", "", "bank");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $matricule = $_POST["matricule"];

    $res = mysqli_query($connect, "SELECT * FROM chef WHERE nom = '$nom' AND prenom = '$prenom'");
    $row = mysqli_fetch_assoc($res);

    if (mysqli_num_rows($res) > 0) {
        if ($matricule == $row["matricule"]) {
            header("Location: option_chef.html");
            exit();
        } else {
            echo "<script> alert('Wrong matricule'); </script>";   
        }
    } else {
        echo "<script> alert('User not registered'); </script>";
    }
}
?>
