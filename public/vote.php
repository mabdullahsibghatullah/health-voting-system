<?php
include "../includes/db.php";
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST["product_id"];
    $vote = $_POST["vote"];
    $user_id = $_SESSION["user_id"];

    // Prevent duplicate votes
    $check_vote = $conn->query("SELECT * FROM votes WHERE user_id = '$user_id' AND product_id = '$product_id'");
    if ($check_vote->num_rows == 0) {
        $query = "INSERT INTO votes (user_id, product_id, vote) VALUES ('$user_id', '$product_id', '$vote')";
        $conn->query($query);
    }

    header("Location: products.php");
    exit();
}

$result = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vote for a Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Vote for a Product</h2>
    <form method="post">
        <select name="product_id" class="form-select mb-3">
            <?php while ($row = $result->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['name']); ?></option>
            <?php endwhile; ?>
        </select>
        <button name="vote" value="yes" class="btn btn-success">Vote Yes</button>
        <button name="vote" value="no" class="btn btn-danger">Vote No</button>
    </form>
    <a href="dashboard.php" class="btn btn-primary mt-3">Back to Dashboard</a>
</div>

</body>
</html>
