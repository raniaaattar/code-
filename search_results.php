<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "absence"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['prenom']) && isset($_POST['nom'])) {
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $cni = $_POST['cni']; 

    $sql = "SELECT etudiant.id, etudiant.prenom, etudiant.nom, etudiant.cni, presence.date
            FROM etudiant
            LEFT JOIN presence ON etudiant.id = presence.id_etudiant
            WHERE etudiant.prenom LIKE '%$prenom%' AND etudiant.nom LIKE '%$nom%' AND etudiant.cni LIKE '%$cni%' AND presence.statut = 1";

    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h3>Search Results</h3>
        <?php
        if ($result->num_rows > 0) {
            echo "<ul>";
            while ($row = $result->fetch_assoc()) {
                echo "<li>" . $row['prenom'] . " " . $row['nom'] . " - CNI: " . $row['cni'] . " - Absent Date: " . $row['date'] . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No absent students found.</p>";
        }
        ?>
        <a href="dashboard.php" class="btn btn-primary">Back to Dashboard</a>
    </div>
</body>
</html>

<?php   $conn->close(); ?>
