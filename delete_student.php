<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "absence"; 

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "DELETE FROM etudiant WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Student deleted successfully');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    header("Location: dashboard.php");
    exit;
}

