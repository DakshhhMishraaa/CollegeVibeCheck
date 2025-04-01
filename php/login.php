<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <div class="fullnavbar">
        <div class="logobar">
            <h1>Logo</h1>
        </div>

        <div class="navbar">
            <a href>Home</a>
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

            <a href="/html/register.html" class="sign-in-btn">
                <h3 class="login-font">Sign-Up</h3>
            </a>
        </div>
    </div>

    <div class="reg-form-div">
        <form action="../php/subdb.php" method="POST" id="regform">
            <label for="name">Name </label>
            <input type="text" id="name" name="username">

            <label for="email">Email </label>
            <input type="email" id="email" name="email">

            <label for="college">Select College </label>
            <select name="college">
                <option value="KJ">KJ Somaiya College of Engineering(Vidyavihar)</option>
                <option value="DJ">DJ Sanghavi</option>
                <option value="NM">NMIMS</option>
                <option value="VJ">VJTI</option>
                <option value="KJSIT">KJ Somaiya Sion College of Engineering(Sion)</option>
            </select>
        </form>
    </div>
    

</body>
</html>