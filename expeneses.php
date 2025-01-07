<?php 
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);

// Predefined list of categories
$categories = array("Food", "Transportation", "Utilities", "Entertainment", "Shopping", "Other");

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $amount = $_POST['amount'];
    $category = $_POST['category'];
    $note = $_POST['note'];

    // Retrieve user_id from session
    $user_id = $_SESSION['user_id']; 

    if(!empty($category) && !empty($note))
    {
        
        $query = "INSERT INTO user_exp (user_id, amount, category, note) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $query);

        // Bind parameters to the prepared statement
        mysqli_stmt_bind_param($stmt, 'idss', $user_id, $amount, $category, $note);

        // Execute the prepared statement
        mysqli_stmt_execute($stmt);

        // Check if the query was successful
        if(mysqli_stmt_affected_rows($stmt) > 0) {
            // Expense added successfully, redirect or display success message
            header('Location: expeneses.php');
            exit();
        } else {
            // Failed to add expense
            echo "Failed to add expense";
        }

        // Close the prepared statement
        mysqli_stmt_close($stmt);
    }
    else
    {
        echo "Please enter valid information!";
    }
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
<h1>Add Expenses</h1>
<div class="container">
<form method="post">
    <div>
        <input type="text" placeholder="Amount" name="amount">
    </div>
    <div>
        <!-- Dropdown select menu for categories -->
        <select name="category">
            <?php foreach ($categories as $cat) { ?>
                <option value="<?php echo $cat; ?>"><?php echo $cat; ?></option>
            <?php } ?>
        </select>
    </div>
    <div>
        <input type="text" placeholder="Note" name="note">
    </div>
    <input type="submit" value="save"  name="save_btn">
</form>
</div>
</div>
<div class="footer">
        <a href="dash.php"><i class="fas fa-chart-line"></i> Dashboard</a>
        <a href="budget.php"><i class="fas fa-money-bill-alt"></i> Budget</a>
        <a href="map.php"><i class="fas fa-map-marker-alt"></i> Map</a>
        <a href="index.php"><i class="fas fa-receipt"></i> Index</a>
        <a href="tn.php"><i class="fas fa-receipt"></i>Transactions</a>
    </div>
</body>
</html>
