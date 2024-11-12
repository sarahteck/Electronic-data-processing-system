<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$dbname = "business_db"; // Name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add sale or purchase if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $productName = htmlspecialchars($_POST['productName']);
    $productPrice = floatval($_POST['productPrice']);
    $productQuantity = intval($_POST['productQuantity']);
    $customerName = htmlspecialchars($_POST['customerName']);
    
    $total = $productPrice * $productQuantity;

    // Insert data into database
    $sql = "INSERT INTO sales_and_purchases (product_name, product_price, product_quantity, customer_name, action, total)
            VALUES ('$productName', '$productPrice', '$productQuantity', '$customerName', '$action', '$total')";

    if ($conn->query($sql) === TRUE) {
        $successMessage = "Transaction ($action) recorded successfully!";
    } else {
        $errorMessage = "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electronic Data Processing System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Sales and Purchases</h2>
    
    <!-- Display success or error messages -->
    <?php if (isset($successMessage)) { ?>
        <div class="alert alert-success" role="alert">
            <?php echo $successMessage; ?>
        </div>
    <?php } elseif (isset($errorMessage)) { ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $errorMessage; ?>
        </div>
    <?php } ?>

    <!-- Form to submit sales and purchase -->
    <form method="POST" action="sarahnew.php" class="mb-4">
        <div class="form-group">
            <label for="productName">Product Name</label>
            <input type="text" class="form-control" id="productName" name="productName" required>
        </div>
        <div class="form-group">
            <label for="productPrice">Product Price</label>
            <input type="number" step="0.01" class="form-control" id="productPrice" name="productPrice" required>
        </div>
        <div class="form-group">
            <label for="productQuantity">Product Quantity</label>
            <input type="number" class="form-control" id="productQuantity" name="productQuantity" required>
        </div>
        <div class="form-group">
            <label for="customerName">Customer Name</label>
            <input type="text" class="form-control" id="customerName" name="customerName" required>
        </div>
        <div class="form-group">
            <label>Action</label>
            <div>
                <label class="radio-inline"><input type="radio" name="action" value="sale" checked> Sale</label>
                <label class="radio-inline"><input type="radio" name="action" value="purchase"> Purchase</label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <h3 class="mt-5">Reports</h3>
    <a href="sales_and_purchases.php" class="btn btn-secondary">View Sales and Purchases Report</a>
</div>
</body>
</html>
