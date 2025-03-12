<?php
include "../includes/db.php";
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: ../public/login.php");
    exit();
}

$query = "SELECT users.name AS resident, products.name AS product, votes.vote 
          FROM votes 
          JOIN users ON votes.user_id = users.id 
          JOIN products ON votes.product_id = products.id";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Votes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Manage Votes</h2>
    <table class="table table-bordered">
        <tr>
            <th>Resident</th>
            <th>Product</th>
            <th>Vote</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row["resident"]); ?></td>
            <td><?php echo htmlspecialchars($row["product"]); ?></td>
            <td><?php echo htmlspecialchars($row["vote"]); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <a href="admin.php" class="btn btn-primary">Back to Admin Panel</a>
</div>

</body>
</html>
