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

if (isset($_POST['attendance'])) {
    $etudiant_username = $_SESSION['username'];
    $date = date("Y-m-d");
    $statut = ($_POST['attendance'] == 'absent') ? 1 : 0;

    $sql_id = "SELECT id FROM Etudiant WHERE cni='$etudiant_username'";


    $result_id = $conn->query($sql_id);
    if ($result_id->num_rows == 1) {
        $row = $result_id->fetch_assoc();
        $etudiant_id = $row['id'];
        

        $sql = "INSERT INTO presence (id_etudiant, date, statut) VALUES ('$etudiant_id', '$date', '$statut')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Attendance recorded successfully. You will be logged out in 3 seconds.')</script>";
            echo "<script>setTimeout(function(){ window.location.href = 'logout.php'; }, 3000);</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error: Unable to retrieve etudiant's ID<br>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Welcome, <?php echo $_SESSION['username']; ?> </h2>

        <form method="post" action="">
            <div class="btn-group mt-3" role="group" aria-label="Attendance">
                <button type="submit" class="btn btn-lg btn-danger" name="attendance" value="absent">Absent</button>
                <button type="submit" class="btn btn-lg btn-success" name="attendance" value="present">Present</button>
            </div>
        </form>
    </div>
    <a href="logout.php" class="btn btn-danger">Logout</a>
</body>
</html>
