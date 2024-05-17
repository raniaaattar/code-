<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "absence";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $cni = $_POST['cni']; 
    $password = $_POST['password'];

    $sql = "INSERT INTO etudiant (nom, prenom, cni, password) VALUES ('$nom', '$prenom', '$cni', '$password')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Student added successfully');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();

