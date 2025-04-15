<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tomorrow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>

<body>
    <div class="box">
        <div class="welcome">
            <h1>Hey User!</h1>
            <h2>Login to our page and spill the tea — the world's waiting to hear the uncensored truth about your college</h2>

            <div class="inner-group">
                <button type = "button" onclick="location.href='index.php'" class="homebtn">Home</button>
            </div>

        </div>

        <div class="login-box">
            <form action="login.php" method="POST">
                <div class="form-group">
                    <div class="inner-form-group">
                        <h1>Login to CollegeVibeCheck</h1>
                    </div>
                    <div class="inner-form-group">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" placeholder="Enter your username">
                    </div>
    
                    <div class="inner-group">
                        <label for="password">Password:</label>
                        <div class="password-wrapper">
                            <input type="password" id="password" name="password" placeholder="Enter your password" >
                            <span id="togglePassword" class="fa fa-eye eye-icon"></span>
                        </div>
                    </div>

                    <div class="inner-group">
                        <button type="submit">Login</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
    
    <script src="../js/login.js"></script>
</body>
</html>


<?php
session_start();
require 'dbconnect.php';

if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['username']) && !empty($_POST['password'])){
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $stmt = $conn->prepare("SELECT user_id, username, password, college, branch, yearofstudy FROM users WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows === 1){
        $row = $result->fetch_assoc();

        if(password_verify($pass, $row['password'])){

            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['college'] = $row['college'];
            $_SESSION['branch'] = $row['branch'];
            $_SESSION['yearofstudy'] = $row['yearofstudy'];

            echo "<script>
            alert('Login successful!');
            window.location.href = 'dashboard.php';
            </script>";
        }
        else{
            echo "<script>
            alert('password incorrect!');
            windows.location.back();

            </script>";
        }
    }
    else{
        echo "<script>alert('Username not found');
        window.history.back();
        </script>";
    }
}
?>