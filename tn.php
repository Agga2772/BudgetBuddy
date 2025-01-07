<?php 
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);

// Fetch all expenses for the user from the database
$query = "SELECT amount, category, note, date FROM user_exp WHERE user_id = ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, 'i', $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $amount, $category, $note, $date);

// Store expenses in an array
$expenses = array();
while (mysqli_stmt_fetch($stmt)) {
    $expenses[] = array(
        'amount' => $amount,
        'category' => $category,
        'note' => $note,
        'date' => $date
    );
}

// Close the prepared statement
mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
<a href="budget.php">budget</a>
<a href="index.php">index</a>
<a href="dash.php">dash</a>
<a href="map.php">map</a>
<div class="main-content">
<h1>Transactions</h1>

<?php if (empty($expenses)) : ?>
    <p>No expenses recorded.</p>
<?php else : ?>
    <ul>
        <?php foreach ($expenses as $expense) : ?>
            <li>
                <strong>Amount:</strong> <?php echo $expense['amount']; ?><br>
                <strong>Category:</strong> <?php echo $expense['category']; ?><br>
                <strong>Note:</strong> <?php echo $expense['note']; ?><br>
                <strong>Timestamp:</strong> <?php echo $expense['date']; ?><br>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
        </div>
<div class="footer">
        <a href="dash.php"><i class="fas fa-chart-line"></i> Dashboard</a>
        <a href="budget.php"><i class="fas fa-money-bill-alt"></i> Budget</a>
        <a href="map.php"><i class="fas fa-map-marker-alt"></i> Map</a>
        <a href="expeneses.php"><i class="fas fa-receipt"></i> Expenses</a>
        <a href="index.php"><i class="fas fa-receipt"></i> Index</a>
</div>
</body>
</html>

