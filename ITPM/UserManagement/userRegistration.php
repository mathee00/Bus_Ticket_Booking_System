<?php
session_start();

    include("./includes/config.php");
    include("./includes/function.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Bus Ticket</title>

    <link rel="stylesheet" href="css/userRegistration.css">
    <link rel="shortcut icon" type="image/png" href="images/logob.png">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body>

    <!----------navigation bar---------->
    <div class="header">
        <div class="navbar">
            <img src="images/logob.png" class="logo">
            <nav>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a class="active" href="#">User Registration</a></li>
                    <li><a href="#">Admin Login</a></li>
                </ul>
            </nav>
        </div>
        <hr>
    
        <!----------registration form---------->
        <section>
            <div class = "container">
                <div class="register-form">
                    <div>
                        <h2>Create User Account</h2>
                    </div>
                    <div>
                        <img src="./images/register.svg" class = "register-image"></img>
                    </div>
                    <form action="./includes/signup.php" method="POST">
                        <div class = "form-inner">
                            <div class = "input-box">
                                <label class = "form-label">First Name</label>
                                <input type = "text" name = "firstname" id = "firstname"></input>
                            </div>
                            <div class = "input-box">
                                <label class = "form-label">Last Name</label>
                                <input type = "text" name = "lastname" id = "lastname"></input>
                            </div>
                            <div class = "input-box">
                                <label class = "form-label">Username</label>
                                <input type = "text" name = "username" id = "username"></input>
                            </div>
                            <div class = "input-box">
                                <label class = "form-label">Email Address</label>
                                <input type = "email" name = "email" id = "email"></input>
                            </div>
                            <div class = "input-box">
                                <label class = "form-label">Password</label>
                                <input type = "password" name = "password" id = "password"></input>
                            </div>
                            <div class = "input-box">
                                <label class = "form-label">Confirm Password</label>
                                <input type = "password" name = "cpassword" id = "cpassword"></input>
                            </div>
                        </div>
                        <div>
                            <button class = "input-button" name="submit" type = "submit">Register</button>
                        </div>
                        <div>
                            <span class = "input-login-link">Already have an account? <a href = "userLogin.php">Login</a></span>
                        </div> 
                    </form>
                </div>
            </div>

            <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "emptyinput") {
                    echo '<script>alert("Fill in all fields!")</script>';
                } else if ($_GET["error"] == "invalidusername") {
                    echo '<script>alert("Choose a proper username!")</script>';
                } else if ($_GET["error"] == "usernamelength") {
                    echo '<script>alert("Username must be at least 6 characters!")</script>';
                } else if ($_GET["error"] == "invalidemail") {
                    echo '<script>alert("Choose a proper email!")</script>';
                } else if ($_GET["error"] == "passwordlength") {
                    echo '<script>alert("Password length must be 8 - 12 characters!")</script>';
                } else if ($_GET["error"] == "passwordmismatch") {
                    echo '<script>alert("Password do not match!")</script>';
                } else if ($_GET["error"] == "stmtfailed") {
                    echo '<script>alert("Something went wrong, try again!")</script>';
                } else if ($_GET["error"] == "usernameexists") {
                    echo '<script>alert("Username or email already taken!")</script>';
                } else if ($_GET["error"] == "none") {
                    header("location: userLogin.php");
                    exit();
                }
            }
            ?>
        </section>

        <!----------footer---------->
        <div class="footer">
            <a href=""><i class="lab la-linkedin"></i></a>
            <a href=""><i class="lab la-instagram"></i></a>
            <a href=""><i class="lab la-facebook"></i></a>
            <a href=""><i class="lab la-twitter"></i></a>
            <hr>
            <p>Copyright 2022 © SLIIT Y3S1 IT Students. All Rights Reserved.</p>
        </div>
    </div>

</body>
</html>