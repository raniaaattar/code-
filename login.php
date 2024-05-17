<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "absence";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username']; 
    $password = $_POST['password'];
    $isAdmin = isset($_POST['isAdmin']) ? 1 : 0;

    if ($isAdmin) {
        $sql = "SELECT * FROM Admin WHERE username='$username' AND password='$password'";
        $dashboard = "dashboard.php";
    } else {
        $sql = "SELECT * FROM Etudiant WHERE cni='$username' AND password='$password'"; 
        $dashboard = "etudiant_dashboard.php";
    }

    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $username;
        $_SESSION['id'] = $row['id']; 
        header("Location: $dashboard");
        exit;
    } else {
        echo "Verify your password and username";
    }
}

$conn->close();

