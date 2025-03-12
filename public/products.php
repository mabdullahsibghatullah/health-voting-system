<?php
include "../includes/db.php";
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Fetch products with vote counts
$query = "SELECT products.*, 
                 SUM(CASE WHEN votes.vote = 'yes' THEN 1 ELSE 0 END) AS yes_votes, 
                 SUM(CASE WHEN votes.vote = 'no' THEN 1 ELSE 0 END) AS no_votes 
          FROM products 
          LEFT JOIN votes ON products.id = votes.product_id 
          GROUP BY products.id";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Available Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Available Products</h2>
    <table class="table table-bordered">
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Category</th>
            <th>Price</th>
            <th>Yes Votes</th>
            <th>No Votes</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row["name"]); ?></td>
            <td><?php echo htmlspecialchars($row["description"]); ?></td>
            <td><?php echo htmlspecialchars($row["category"]); ?></td>
            <td>$<?php echo number_format($row["price"], 2); ?></td>
            <td><?php echo $row["yes_votes"] ?? 0; ?></td>
            <td><?php echo $row["no_votes"] ?? 0; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <a href="dashboard.php" class="btn btn-primary">Back to Dashboard</a>
</div>

</body>
</html>
