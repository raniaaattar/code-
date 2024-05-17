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

    $sql = "SELECT * FROM etudiant WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $prenom = $row['prenom'];
        $nom = $row['nom'];
        $cni = $row['cni'];
    } else {
        echo "Student not found";
        exit;
    }

    $conn->close();
} else {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h3>Edit Student</h3>
        <form method="post" action="update_student.php">
            <div class="form-group">
                <label for="prenom">First Name</label>
                <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo $prenom; ?>">
            </div>
            <div class="form-group">
                <label for="nom">Last Name</label>
                <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $nom; ?>">
            </div>
            <div class="form-group">
                <label for="cni">CNI</label> 
                <input type="text" class="form-control" id="cni" name="cni" value="<?php echo $cni; ?>">
            </div>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
