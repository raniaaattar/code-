<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $cni = $_POST['cni'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "absence"; 

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE etudiant SET prenom='$prenom', nom='$nom', cni='$cni' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Student updated successfully');</script>";
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
} else {
    header("Location: dashboard.php");
    exit;
}

