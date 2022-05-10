<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Ticket</title>

    <link rel="stylesheet" href="css/userLogin.css">
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
                    <li><a class="active" href="#">User Login</a></li>
                    <li><a href="../admin.php">Admin Login</a></li>
                </ul>
            </nav>
        </div>
        <hr>
    
        <!----------login form---------->
        <section>
            <div class="container">
                <div class = "login-form">
                    <div>
                        <h2>Login</h2>
                    </div>
                    <div>
                        <img src="./images/login.svg" class = "login-image"></img>
                    </div>
                    <form action="includes/login.php" method="POST">
                        <div class = "form-inner">
                            <div class = "input-box">
                                <label class="form-label">Username</label>
                                <input type = "text" name = "username" id = "username"></input>
                            </div>
                            <div class = "input-box">
                                <label class="form-label">Password</label>
                                <input type = "password" name = "password" id = "password"></input>
                            </div>
                        </div>
                        <div>
                            <button class = "input-button" name="submit" type = "submit">Login</button>
                        </div>
                        <div>
                            <span class = "form-signup-link">Don't have an account? <a href = "userRegistration.php">Create Account</a></span>
                        </div>
                    </form>
                </div>
            </div>

            <?php
            if (isset($_GET['error'])) {
                if ($_GET['error'] == "emptyinput") {
                    echo '<script>alert("Fill in all fields!")</script>';
                } else if ($_GET["error"] == "wrongLogin") {
                    echo '<script>alert("Incorrect Username or Password!")</script>';
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