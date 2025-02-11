<?php 
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saving Tips</title>
    <link rel="stylesheet" href="styles.css">
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
    <h1>Saving Tips</h1>
    <p>Welcome to the Saving Tips page. Here, you'll find useful tips and resources to help you save money and budget effectively.</p>
    <br><hr><br>
    <h2>1. Create a Budget Plan</h2>
    <p>Start by outlining your monthly income and expenses. Allocate funds for essential expenses like rent, groceries, and bills, then set aside a portion for savings and discretionary spending.</p>
    <p><a href="https://www.thebalance.com/how-to-make-a-budget-1289587" target="_blank">Learn how to create a budget plan.</a></p>
    <br><hr><br>
    <h2>2. Track Your Spending</h2>
    <p>Keep track of your expenses to identify areas where you can cut back. Use apps or spreadsheets to monitor your spending habits and adjust your budget accordingly.</p>
    <p><a href="https://www.nerdwallet.com/article/finance/how-to-track-your-expenses" target="_blank">Explore ways to track your spending.</a></p>
    <br><hr><br>
    <h2>3. Set Financial Goals</h2>
    <p>Define short-term and long-term financial goals to stay motivated. Whether it's building an emergency fund, paying off debt, or saving for a vacation, having clear objectives will help you stay focused.</p>
    <p><a href="https://www.investopedia.com/financial-advisor/setting-smart-financial-goals/" target="_blank">Tips for setting financial goals.</a></p>
    <br><hr><br>
    <h2>4. Avoid Impulse Purchases</h2>
    <p>Avoid making impulse purchases by sticking to your shopping list and avoiding unnecessary expenses. Consider waiting 24 hours before making non-essential purchases to reduce impulse buying.</p>
    <br><hr><br>
    <h2>5. Find Ways to Save</h2>
    <p>Look for opportunities to save money, such as using coupons, buying generic brands, and taking advantage of sales and discounts. Small changes in your spending habits can add up over time.</p>
    <p><a href="https://www.moneycrashers.com/simple-ways-save-money/" target="_blank">Simple ways to save money.</a></p>
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


