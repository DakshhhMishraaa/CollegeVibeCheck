<?php
// 1. Start the session and include the database connection at the very top
session_start();
include 'dbconnect.php'; // adjust path if needed

// 2. Handle the form submission for registration and login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Since this is only for registration, we assume the action is register.
    // (If you wish to expand with login, you can add a hidden field like <input type="hidden" name="action" value="register">)
    
    // Grab and sanitize the input
    $username = trim($_POST['username']);
    $password = $_POST['password']; // We'll hash below
    $role = $_POST['role']; // Should be 'viewer'
    
    // Check if the username already exists in the database
    $checkStmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
    $checkStmt->bind_param("s", $username);
    $checkStmt->execute();
    $checkStmt->store_result();
    
    if ($checkStmt->num_rows > 0) {
        // Username exists, send an alert and redirect back
        echo "<script>
            alert('Username already exists. Please choose a different one.');
            window.history.back();
        </script>";
        $checkStmt->close();
        $conn->close();
        exit();
    }
    $checkStmt->close();
    
    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert the new user into the database
    $stmt = $conn->prepare("INSERT INTO users (username, password, user_role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $hashedPassword, $role);
    
    if ($stmt->execute()) {
        // Registration succeeded, auto-login the user by setting session variables
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
        
        // Redirect to the homepage (or a logged-in page)
        header("Location: ../php/index.php");
        exit();
    } else {
        echo "Error during registration: " . $conn->error;
    }
    
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CollegeVibeCheck</title>
    <link rel="stylesheet" href="/CollegeVibeCheck/css/index0.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tomorrow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

</head>
<body>
    <div class="fullcontainer" id="fullpage">
        <div class="fullnavbar">
            <div class="logobar">
                <h1>Logo</h1>
            </div>

            <div class="navbar">
                <a href="../php/index.php">Home</a>
                <span>|</span>
                <a href>Colleges</a>
                <span>|</span>
                <a href>Feedbacks</a>
                <span>|</span>
                <a href>Contact</a>
            </div>

            <div class="navbar2">
                <?php if (isset($_SESSION['username'])): ?>
                    <div class="dropdown-container">
                        <button class="sign-in-btn" onclick="toggleDropdown()">
                            <h3 class="login-font"><?php echo htmlspecialchars($_SESSION['username']); ?></h3>
                        </button>
                        <div id="dropdown-menu" class="dropdown-content">
                            <a href="logout.php">Logout</a>
                        </div>
                    </div>

                    
                <?php else: ?>
                    <a href="../php/login.php" class="sign-in-btn">
                        <h3 class="login-font">Login</h3>
                    </a>
                    <a href="#" class="sign-in-btn" onclick="toggle()">
                        <h3 class="login-font">Sign-Up</h3>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    
        <div class="content1">
            <div class="row1">
                <div class="college">
                    <h1>COLLEGE</h1>            
                </div>
                <div class="t1">
                    <p margin="2px">For everyone who wants to experience <br> the college before admissions</p>
                </div>
            </div>

            <div class="row2">
                <div class="t2">
                    <p>Worried if you are making the right choice? you are at the right place</p>
                </div>
            
                <div class="vibecheck">
                    <h1>VIBECHECK</h1>
                </div>
            </div>
        </div>

        <div class="pics">
            <div class="pic1">
                <div class="arrow">
                    <img src="../imgs/Arrow.png" height="200px" width="200px"><!--arrow-->
                </div>
                <div class="feedback">
                    <a href="" class="feedback-link">
                        <h1>Feedback</h1>
                    </a>
                </div>
                <div class="pic11">
                    <img src="../imgs/u22.png">
                </div>
            </div>

            <div class="pic2">
                <div class="pic2-1">
                    <img src="../imgs/u33.png"> 
                </div>
                <div class="pic2-2">
                    <img src="../imgs/u11.png">
                </div>
            </div>

            <div class="pic3">
            <div class="accordion">
                    <div class="accordion-item">
                        <button class="accordion-header">Worried about canteen food? or the mess food?</button>
                        <div class="accordion-content">
                            <p>Login and </p>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <button class="accordion-header">Is the Attendance pretty strict?</button>
                        <div class="accordion-content">
                            <p>We got you covered!</p>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <button class="accordion-header">What about the professors?</button>
                        <div class="accordion-content">
                            <p>We got you covered!</p>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <button class="accordion-header">How is the college culture?</button>
                        <div class="accordion-content">
                            <p>We got you covered!</p>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <button class="accordion-header">How are the college committees and clubs doing?</button>
                        <div class="accordion-content">
                            <p>We got you covered!</p>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </div>

    <!-- Popup code for sign-up --->
    <div id="sign-up-popup">
        <div class="box">
            <div class="welcome">
                <h1>Hey User!</h1>
                <h2>Sign up to our page and spill the tea — the world's waiting to hear the uncensored truth about your college</h2>
                <p><hr></p>
                <h3>Are you a college student?</h3>
                <h2><strong>Student</strong> Sign Up</h2>
                <div class="inner-group">
                    <button type = "button" onclick="location.href='register.php'" class="homebtn">Register</button>
                </div>

            </div>

            <div class="login-box">
                <form action="index.php" method="POST">
                    <div class="form-group">
                        <div class="inner-form-group">
                            <h1><strong>Viewer</strong> Sign Up</h1>
                        </div>
                        <div class="inner-form-group">
                            <h3>Create a username</h3>
                            <label for="username">Username:</label>
                            <input type="text" id="username" name="username" placeholder="Enter your username">
                        </div>
                        <!-- Secretly Assigning a role to this user as 'viewer' -->
                        <input type="hidden" name="role" value="viewer">
    
                        <div class="inner-group">
                            <h3>Create a password</h3>
                            <label for="password">Password:</label>
                            <div class="password-wrapper">
                                <input type="password" id="password" name="password" placeholder="Enter your password" >
                                <span id="togglePassword" class="fa fa-eye eye-icon"></span>
                            </div>
                        </div>

                        <div class="inner-group">
                            <button type="submit" id="continue-button">Continue</button>
                        </div>
                    </div>
                </form>
                <div class="outer-group">
                    <button type="button" class="homebtn" onclick="toggle()">Close</button>
                </div>
            </div>
        </div>
    </div>    

    <!-- Popup code for login -->
    <div>
        <form action="viewerlogin.php" method="POST">

        </form>
    </div>

    <script src="/CollegeVibeCheck/js/index0.js"></script>
</body>
</html>