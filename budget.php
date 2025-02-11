<?php 
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);


if ($_SERVER['REQUEST_METHOD'] == "POST") {
   
    $user_id = $_SESSION['user_id']; 

    
    $budgets = array(
        "food" => $_POST['food'],
        "transportation" => $_POST['transportation'],
        "utilities" => $_POST['utilities'],
        "entertainment" => $_POST['entertainment'],
        "shopping" => $_POST['shopping'],
        "other" => $_POST['other']
    );

   
    $query = "INSERT INTO user_budget (user_id, category, budget) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($con, $query);

   
    foreach ($budgets as $category => $budget) {
        
        mysqli_stmt_bind_param($stmt, 'isd', $user_id, $category, $budget);

       
        mysqli_stmt_execute($stmt);
    }

    
    if (mysqli_stmt_affected_rows($stmt) > 0) {
       
        header('Location: index.php');
        exit();
    } else {
       
        echo "Failed to add budgets";
    }

    
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
    <h1>Set Budget for Each Category</h1>
    <p>Enter the budget amount for each category below. This will help you keep track of your expenses and manage your finances effectively.</p>
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
