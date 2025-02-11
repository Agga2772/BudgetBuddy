<?php 
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);


$query = "SELECT amount, category, note, date FROM user_exp WHERE user_id = ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, 'i', $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $amount, $category, $note, $date);


$expenses = array();
while (mysqli_stmt_fetch($stmt)) {
    $expenses[] = array(
        'amount' => $amount,
        'category' => $category,
        'note' => $note,
        'date' => $date
    );
}


mysqli_stmt_close($stmt);


$categories = array("Food", "Transportation", "Utilities", "Entertainment", "Shopping", "Other");


if($_SERVER['REQUEST_METHOD'] == "POST") {
    $amount = $_POST['amount'];
    $category = $_POST['category'];
    $note = $_POST['note'];

    
    $user_id = $_SESSION['user_id']; 

    if(!empty($category) && !empty($note)) {
        $query = "INSERT INTO user_exp (user_id, amount, category, note) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $query);

       
        mysqli_stmt_bind_param($stmt, 'idss', $user_id, $amount, $category, $note);

        
        mysqli_stmt_execute($stmt);

        
        if(mysqli_stmt_affected_rows($stmt) > 0) {
            
            header('Location: expeneses.php');
            exit();
        } else {
            
            echo "Failed to add expense";
        }

        
        mysqli_stmt_close($stmt);
    } else {
        echo "Please enter valid information!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BudgetBuddy - Expenses</title>
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
    <h1>Add Expenses</h1>
    <div class="container">
        <p>Use the form below to add your expenses:</p>
        <form method="post">
            <div>
                <input type="text" placeholder="Amount" name="amount">
            </div>
            <div>
                <select name="category">
                    <?php foreach ($categories as $cat) { ?>
                        <option value="<?php echo $cat; ?>"><?php echo $cat; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div>
                <input type="text" placeholder="Note" name="note">
            </div>
            <input type="submit" value="Save" name="save_btn">
        </form>
    </div>
    <p>These recorded expenses will be displayed on the dashboard with the budget set.</p>
    <br>
    <h1>Expenses</h1>
    <div class="transactions">
        <?php if (empty($expenses)) : ?>
            <p>No expenses recorded yet.</p>
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


