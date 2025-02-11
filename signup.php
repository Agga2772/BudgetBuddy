<?php 
session_start();

include("connection.php");
include("functions.php");

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate email format
    if(!empty($name) && !empty($username) && !empty($email) && !empty($password) && filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare the SQL statement
        $query = "INSERT INTO users (user_id, name, username, email, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $query);
        $user_id = random_num(15);
        mysqli_stmt_bind_param($stmt, 'sssss', $user_id, $name, $username, $email, $hashed_password);

        // Execute the prepared statement
        mysqli_stmt_execute($stmt);

        // Check if the query was successful
        if(mysqli_stmt_affected_rows($stmt) > 0) {
            // Registration successful, redirect to login page
            header('Location: login.php');
            exit();
        } else {
            // Registration failed
            echo "Registration failed";
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
    <title>Signup</title>
    <link rel="stylesheet" href="account.css">
</head>
<body>
<div class="container">
    <form method="post">
        <h1>Signup</h1>
        <div>
            <input type="text" placeholder="Full Name" name="name">
        </div>
        <div>
            <input type="text" placeholder="Username" name="username">
        </div>
        <div>
            <input type="text" placeholder="Email" name="email">
        </div>
        <div>
            <input type="password" placeholder="Password" name="password">
        </div>
        <input type="submit" value="Signup"  name="signup_Btn">
        <div>
            Do you have an account?
            <br>
            <a href="login.php">Login</a>
        </div>
    </form>
    </div>
</body>
</html>

