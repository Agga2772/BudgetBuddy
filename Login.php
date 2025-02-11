<?php 
session_start();

include("connection.php");
include("functions.php");


    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
       $username = $_POST['username'];
       $password = $_POST['password'];

       if(!empty($username) && !empty($password))
       {

         $query = "select * from users where username = '$username' limit 1";

        $result = mysqli_query($con, $query);

        if($result)
        {
            if($result && mysqli_num_rows($result) >0)
        {
            $user_data = mysqli_fetch_assoc($result);
            
            if($user_data['password'] = $password)
            {

                $_SESSION['user_id'] = $user_data['user_id'];
                header("Location: index.php");
                die;
            }
        }
    }
    echo "Wrong Username and Password";
       }else
       {
       echo "PLease enter vaild information!";
    
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="account.css">
    </head>
    <body>
    <div class="container">
        <form method="post" action="login.php">
            <h1>Login</h1>
            <div>
                <input type="text" placeholder="Username" name="username">
            </div>
            <div>
                <input type="password" placeholder="password" name="password">
            </div>
            <input type="submit" value="Login" class="loginbtn" name="login_Btn">
            <div>
                Don't have an account?
            <br>
            <a href="signup.php">Sign up</a>
            </div>
        </form>
        </div>
    </body>
</html>
