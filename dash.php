<?php 
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);


$query = "SELECT category, budget FROM user_budget WHERE user_id = ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, 'i', $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $category, $budget);


$budget_data = array();
while (mysqli_stmt_fetch($stmt)) {
    $budget_data[$category] = $budget;
}


mysqli_stmt_close($stmt);


$expense_query = "SELECT category, SUM(amount) AS total_expense FROM user_exp WHERE user_id = ? GROUP BY category";
$expense_stmt = mysqli_prepare($con, $expense_query);
mysqli_stmt_bind_param($expense_stmt, 'i', $_SESSION['user_id']);
mysqli_stmt_execute($expense_stmt);
mysqli_stmt_bind_result($expense_stmt, $category, $total_expense);


$expense_data = array();
while (mysqli_stmt_fetch($expense_stmt)) {
    $expense_data[$category] = $total_expense;
}


mysqli_stmt_close($expense_stmt);


$remaining_budget_data = array();
foreach ($budget_data as $category => $budget) {
    $remaining_budget_data[$category] = $budget - (isset($expense_data[$category]) ? $expense_data[$category] : 0);
}


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
<header class="header">
        <div class="logo">
            <img src="image/logo.png" alt="Your Logo" class="logo-image">
        </div>
        <div class="greeting">
            <p><?php echo $user_data['username']?>!</p>
        </div>
        <div class="logout">
            <a href="logout.php" class="logout-button">Logout</a>
        </div>
    </header>
    <div class="main-content">
    <h1>Dashboard</h1>

    <div id="budgetExceededMessage">
        <?php if ($budget_exceeded): ?>
            <p>One or more categories have exceeded the budget!</p>
        <?php endif; ?>
    </div>

    <div id="budgetChartContainer">
        <canvas id="budgetChart" width="400" height="400"></canvas>
    </div>

    <div class="dashboard-info">
        <h2>Overview</h2>
        <p>Welcome to your BudgetBuddy dashboard! Here, you can track your budget and expenses for different categories.</p>
        <p>The chart below displays your remaining budget and total expenses for each category. If any category exceeds the budget, it will be highlighted.</p>
    </div>

<script>
// Create chart data
var ctx = document.getElementById('budgetChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar', // Change chart type to bar for progress chart
    data: {
        labels: <?php echo json_encode(array_keys($remaining_budget_data)); ?>,
        datasets: [{
            label: 'Remaining Budget',
            data: <?php echo json_encode(array_values($remaining_budget_data)); ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1,
        }, {
            label: 'Total Expenses',
            data: <?php echo json_encode(array_values($expense_data)); ?>,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1,
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value, index, values) {
                        return value; 
                    }
                }
            }
        }
    }
});
</script>
</div>
<footer class="footer">
        <a href="index.php"><i class="fas fa-house"></i> Home</a>
        <a href="dash.php"><i class="fas fa-chart-line"></i> Dashboard</a>
        <a href="budget.php"><i class="fas fa-money-bill-alt"></i> Budget</a>
        <a href="map.php"><i class="fas fa-map-marker-alt"></i> Map</a>
        <a href="expeneses.php"><i class="fas fa-receipt"></i> Expenses</a>
        <a href="tn.php"><i class="fas fa-arrows-alt-v"></i> Tips</a>
    </footer>
</body>
</html>





