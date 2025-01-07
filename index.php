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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Your Page Title</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="image/logo.png" alt="Your Logo">
        </div>
    </div>

   
    <div class="main-content">
     
    </div>

   
    <div class="footer">
        <a href="dash.php"><i class="fas fa-chart-line"></i> Dashboard</a>
        <a href="budget.php"><i class="fas fa-money-bill-alt"></i> Budget</a>
        <a href="map.php"><i class="fas fa-map-marker-alt"></i> Map</a>
        <a href="expeneses.php"><i class="fas fa-receipt"></i> Expenses</a>
    </div>
</body>
</html>
