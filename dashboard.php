<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prof Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h3>Prof Dashboard</h3>
        <a href="search_form.php" class="btn btn-primary my-2">Chercher un étudiant</a>
        <a href="add_student_form.php" class="btn btn-success my-2">Add Student</a>
        
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>CNI</th> 
                    <th>Absence Count</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "absence"; 

                $conn = new mysqli($servername, $username, $password, $dbname);

                
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT etudiant.id, etudiant.prenom, etudiant.nom, etudiant.cni, SUM(presence.statut) AS absence_count 
                        FROM etudiant 
                        LEFT JOIN presence ON etudiant.id = presence.id_etudiant 
                        GROUP BY etudiant.id";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["prenom"] . "</td>";
                        echo "<td>" . $row["nom"] . "</td>";
                        echo "<td>" . $row["cni"] . "</td>";
                        echo "<td>" . $row["absence_count"] . "</td>";
                        echo "<td>
                                <a href='edit_student.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm'>Edit</a>
                                <a href='delete_student.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this student?\")'>Delete</a>
                            </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No students found</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</body>
</html>
