<?php
  if (isset($_SESSION['error'])) {
      echo "<script>alert('" . $_SESSION['error'] . "');</script>";
      unset($_SESSION['error']);
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="/CollegeVibeCheck/css/register.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tomorrow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>
<body>
    <div class="fullnavbar">
        <div class="logobar">
            <h1>Logo</h1>
        </div>

        <div class="navbar">
            <a href="../php/index.php">Home</a>
            <span>|</span>
            <a href>Colleges</a>
            <span>|</span>
            <a href>Rankings</a>
            <span>|</span>
            <a href>Contact</a>
        </div>

        <div class="navbar2">
            <a href="/php/login.php" class="sign-in-btn">
                <h3 class="login-font">Login</h3>
            </a>

            <a href="/html/register.php" class="sign-in-btn">
                <h3 class="login-font">Sign-Up</h3>
            </a>
        </div>
    </div>
    <div class="form-cont-cont">
        <div class="form-container">
            <form action="register.php"  method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="inner-form-group">
                        <label for="first-name">Username <span class="required">*</span></label>
                        <input type="text" id="first-name" placeholder="Enter First Name" required name="username">
                    </div>
                    <div class="inner-form-group">
                        <label for="college">Select College </label>
                        <select name="college" id="college">
                            <option value="College1"></option>
                            <option value="KJ">KJ Somaiya College of Engineering(Vidyavihar)</option>
                            <option value="DJ">DJ Sanghavi College of Enginnering</option>
                            <option value="NM">NMIMS College of Engineering</option>
                            <option value="VJ">VJTI College of Engineering</option>
                            <option value="KJSIT">KJ Somaiya Sion College of Engineering(Sion)</option>
                        </select>
                    </div>
                    <div class="inner-form-group">
                        <label for="identitycard">Verify Identity <span class="required">*</span></label>
                        <input type="file" id="identitycard" name="identitycard" accept=".jpg, .jpeg" required>
                    </div>
                    <div class="inner-form-group">
                        <label for="college">Select Branch <span class="required">*</label>
                        <select name="branch" id="branch">
                            <option value="College1"></option>
                            <option value="Comps">CE/CSE</option>
                            <option value="EXCP">EXCP</option>
                            <option value="EXTC">EXTC</option>
                            <option value="VJ">RAI</option>
                            <option value="KJSIT">MECH</option>
                        </select>
                    </div>
                    <div class="inner-form-group">
                        <label for="college">Select Year of Study <span class="required">*</label>
                        <select name="yearofstudy" id="yr">
                            <option value="yr1"></option>
                            <option value="FY">FY</option>
                            <option value="SY">SY</option>
                            <option value="TY">TY</option>
                            <option value="LY">LY</option>
                        </select>
                    </div>
                    <div class="inner-form-group">
                        <label for="password">Password <span class="required">*</span></label>
                        <input type="password" id="password" placeholder="Enter your password" name="password" value="<?php echo $_SESSION['old_username'] ?? ''; ?>" required>
                    </div>
                    <div class="inner-form-group">
                        <label for="email">Email Id <span class="required">*</span></label>
                        <input type="email" id="email" placeholder="Enter Email Id" name="email" requried>
                    </div>
                    <div class="inner-form-group">
                        <label for="confirm-password">Confirm Password <span class="required">*</span></label>
                        <input type="password" id="confirm-password" placeholder="Confirm your password" name = "confirm-password" required>
                    </div>
                    <div class="inner-form-group">
                        <button type="submit">Submit</button>
                    </div>
                </div>    
            </form>
        </div>
    </div>
    
    <script src="../js/reg.js"></script>
</body>
</html>


<?php
require 'dbconnect.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $cpass = $_POST['confirm-password'];
    $email = $_POST['email'];
    $college = $_POST['college'];
    $branch = $_POST['branch'];
    $year = $_POST['yearofstudy'];
    $exists = false;
    if ($pass !== $cpass) {
        echo "<script>
            alert('Passwords do not match!');
            window.history.back();
        </script>";
        exit();
    }

    $checkQuery = "SELECT username FROM users WHERE username = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("s", $user);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        //Username exists, tell the user to pick another
        echo "<script>
            alert('Username already exists. Please choose a different one.');
            window.history.back();
        </script>";
        exit(); //Stop the script here
    }

    //Handle file upload
    $targetDir = "../uploads/";
    $fileName = basename($_FILES["identitycard"]["name"]);
    $targetFilePath = $targetDir . uniqid() . "_" . $fileName;
    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
    $uploadOk = 1;
    $allowedTypes = array("jpg", "jpeg", "png");

    if (!in_array($fileType, $allowedTypes)) {
        echo "Only JPG, JPEG & PNG files are allowed.";
        $uploadOk = 0;
    }
    if ($uploadOk && move_uploaded_file($_FILES["identitycard"]["tmp_name"], $targetFilePath)) {
        //Hash password
        $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

        //Insert into DB
        $stmt = $conn->prepare("INSERT INTO users (username, password, email, college, branch, yearofstudy, identity)
                                VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $user, $hashedPassword, $email, $college, $branch, $year, $targetFilePath);

        if ($stmt->execute()) {
            header("Location: ../html/regsuccess.html");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } 
    else {
        echo "File upload failed.";
    }
}
?>
