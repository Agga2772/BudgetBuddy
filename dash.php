<?php 
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);

// Fetch budgets from the database
$query = "SELECT category, budget FROM user_budget WHERE user_id = ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, 'i', $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $category, $budget);

// Store budgets in an associative array
$budget_data = array();
while (mysqli_stmt_fetch($stmt)) {
    $budget_data[$category] = $budget;
}

// Close the prepared statement
mysqli_stmt_close($stmt);

// Calculate total expenses for each category
$expense_query = "SELECT category, SUM(amount) AS total_expense FROM user_exp WHERE user_id = ? GROUP BY category";
$expense_stmt = mysqli_prepare($con, $expense_query);
mysqli_stmt_bind_param($expense_stmt, 'i', $_SESSION['user_id']);
mysqli_stmt_execute($expense_stmt);
mysqli_stmt_bind_result($expense_stmt, $category, $total_expense);

// Store total expenses in an associative array
$expense_data = array();
while (mysqli_stmt_fetch($expense_stmt)) {
    $expense_data[$category] = $total_expense;
}

// Close the prepared statement
mysqli_stmt_close($expense_stmt);

// Calculate remaining budget for each category
$remaining_budget_data = array();
foreach ($budget_data as $category => $budget) {
    $remaining_budget_data[$category] = $budget - (isset($expense_data[$category]) ? $expense_data[$category] : 0);
}

// Check if any expenses exceed the budget
$budget_exceeded = false;
foreach ($remaining_budget_data as $budget) {
    if ($budget < 0) {
        $budget_exceeded = true;
        break;
    }
}

?>

<!DOCTYPE html>
<html>
<head>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BudgetBuddy</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        #budgetChartContainer {
            width: 50%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #budgetExceededMessage {
            text-align: center;
            color: red;
            font-weight: bold;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<div class="header">
        <div class="logo">
            <img src="image/logo.png" alt="Your Logo">
        </div>
    </div>

<div class="main-content">
<h1>Dashboard</h1>

<div id="budgetExceededMessage">
    <?php if ($budget_exceeded): ?>
        Budget has been exceeded!
    <?php endif; ?>
</div>

<div id="budgetChartContainer">
    <canvas id="budgetChart" width="400" height="400"></canvas>
</div>

<script>
// Create chart data
var ctx = document.getElementById('budgetChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode(array_keys($remaining_budget_data)); ?>,
        datasets: [{
            label: 'Expenses',
            data: <?php echo json_encode(array_values($expense_data)); ?>,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1,
            fill: false
        }, {
            label: 'Remaining Budget',
            data: <?php echo json_encode(array_values($remaining_budget_data)); ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1,
            fill: false
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
</div>
<div class="footer">
        <a href="index.php"><i class="fas fa-chart-line"></i> Index</a>
        <a href="budget.php"><i class="fas fa-money-bill-alt"></i> Budget</a>
        <a href="map.php"><i class="fas fa-map-marker-alt"></i> Map</a>
        <a href="expeneses.php"><i class="fas fa-receipt"></i> Expenses</a>
        <a href="tn.php"><i class="fas fa-receipt"></i>Transactions</a>
    </div>
</body>
</html>


