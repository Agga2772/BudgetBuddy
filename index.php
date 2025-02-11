<?php 
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>BudgetBuddy</title>
</head>
<body>
    <header class="header">
        <div class="logo">
            <img src="image/logo.png" alt="Your Logo" class="logo-image">
        </div>
        <div class="greeting">
            <p>Welcome, <?php echo $user_data['username']; ?>!</p>
        </div>
        <div class="logout">
            <a href="logout.php" class="logout-button">Logout</a>
        </div>
    </header>

    <main class="main-content">
        <section class="overview">
            <h1>BudgetBuddy</h1>
            <p>Welcome to BudgetBuddy. Here, you can manage your expenses, set budgets, explore nearby stores, and more.</p>
        </section>
        <br><hr><br>

        <!-- Feature Highlights Section -->
        <section class="feature-highlights">
            <div class="feature">
                <i class="fas fa-cogs"></i>
                <h3>Expense Management</h3>
                <p>Easily track and categorize your expenses to stay on top of your finances.</p>
            </div>
            <br><hr><br>
            <div class="feature">
                <i class="fas fa-chart-line"></i>
                <h3>Budget Setting</h3>
                <p>Set monthly budgets and receive alerts when you're nearing your limits.</p>
            </div>
            <br><hr><br>
            <div class="feature">
                <i class="fas fa-map-marker-alt"></i>
                <h3>Nearby Stores</h3>
                <p>Find nearby stores and explore their offerings and price ranges.</p>
            </div>
        </section>
    </main>
    
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


