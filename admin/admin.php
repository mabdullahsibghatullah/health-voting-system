<?php
session_start();
include "../includes/db.php";

// Check if user is logged in and is an admin
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: ../public/login.php");
    exit();
}

// Fetch total users, products, and votes
$total_users = $conn->query("SELECT COUNT(*) AS count FROM users WHERE role='resident'")->fetch_assoc()["count"];
$total_products = $conn->query("SELECT COUNT(*) AS count FROM products")->fetch_assoc()["count"];
$total_votes = $conn->query("SELECT COUNT(*) AS count FROM votes")->fetch_assoc()["count"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand">Admin Panel</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="add_resident.php">Add Resident</a></li>
                <li class="nav-item"><a class="nav-link" href="add_product.php">Add Product</a></li>
                <li class="nav-item"><a class="nav-link" href="manage_votes.php">Manage Votes</a></li>
                <li class="nav-item"><a class="nav-link btn btn-danger text-white" href="../public/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2>Welcome, Admin!</h2>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-center bg-info text-white">
                <div class="card-body">
                    <h4>Total Residents</h4>
                    <h2><?php echo $total_users; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center bg-success text-white">
                <div class="card-body">
                    <h4>Total Products</h4>
                    <h2><?php echo $total_products; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center bg-warning text-white">
                <div class="card-body">
                    <h4>Total Votes</h4>
                    <h2><?php echo $total_votes; ?></h2>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
