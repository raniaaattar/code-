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
    <title>Search Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h3>Search Student</h3>
        <form action="search_results.php" method="POST">
            <div class="form-group">
                <label for="prenom">First Name:</label>
                <input type="text" class="form-control" id="prenom" name="prenom" required>
            </div>
            <div class="form-group">
                <label for="nom">Last Name:</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>
            <div class="form-group">
                <label for="cni">CNI:</label>
                <input type="text" class="form-control" id="cni" name="cni">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>
</body>
</html>
