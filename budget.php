<?php 
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Retrieve user_id from session
    $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session

    // Define an associative array to hold category names and their corresponding budgets
    $budgets = array(
        "food" => $_POST['food'],
        "transportation" => $_POST['transportation'],
        "utilities" => $_POST['utilities'],
        "entertainment" => $_POST['entertainment'],
        "shopping" => $_POST['shopping'],
        "other" => $_POST['other']
    );

    // Prepare the SQL statement
    $query = "INSERT INTO user_budget (user_id, category, budget) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($con, $query);

    // Loop through each category and its corresponding budget
    foreach ($budgets as $category => $budget) {
        // Bind parameters to the prepared statement
        mysqli_stmt_bind_param($stmt, 'isd', $user_id, $category, $budget);

        // Execute the prepared statement
        mysqli_stmt_execute($stmt);
    }

    // Check if at least one budget was successfully inserted
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        // Budgets added successfully, redirect or display success message
        header('Location: index.php');
        exit();
    } else {
        // Failed to add budgets
        echo "Failed to add budgets";
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BudgetBuddy</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<div class="header">
        <div class="logo">
            <img src="image/logo.png" alt="Your Logo">
        </div>
    </div>
<a href="logout.php">Logout</a>
<div class="main-content">
<h1>Set Budget for each category</h1>
    <div class="container">
<form method="post">
    <div>
        <input type="number" placeholder="Food" name="food" min="0">
    </div>
    <div>
        <input type="number" placeholder="Transportation" name="transportation" min="0">
    </div>
    <div>
        <input type="number" placeholder="Utilities" name="utilities" min="0">
    </div>
    <div>
        <input type="number" placeholder="Entertainment" name="entertainment" min="0">
    </div>
    <div>
        <input type="number" placeholder="Shopping" name="shopping" min="0">
    </div>
    <div>
        <input type="number" placeholder="Other" name="other" min="0">
    </div>
    <input type="submit" value="Save" name="save_btn">
</form>
</div>
</div>
<div class="footer">
        <a href="dash.php"><i class="fas fa-chart-line"></i> Dashboard</a>
        <a href="index.php"><i class="fas fa-money-bill-alt"></i> Index</a>
        <a href="map.php"><i class="fas fa-map-marker-alt"></i> Map</a>
        <a href="expeneses.php"><i class="fas fa-receipt"></i> Expenses</a>
        <a href="tn.php"><i class="fas fa-receipt"></i>Transactions</a>
    </div>
</body>
</html>
