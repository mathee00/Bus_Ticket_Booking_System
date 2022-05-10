<?php
session_start();

    include("./includes/config.php");
    include("./includes/function.php");

    $user_data = check_login($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Bus Ticket</title>

    <link rel="stylesheet" href="css/userProfile.css">
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
                    <li><a href="userDashboard.php">Home</a></li>
                    <li><a href="bookTicket.php">Book Ticket</a></li>
                    <li><a href="myBooking.php">My Bookings</a></li>
                    <li><a class="active" href="#">My Profile</a></li>
                    <li><a href="./includes/logout.php">Log Out</a></li>
                </ul>
            </nav>
        </div>
        <hr>
    
        <!----------user profile---------->
        <section>

        <!----------profile update form---------->
        <div class="cards">
                <div class = "container">
                    <div>
                        <h2>Update My Profile</h2>
                    </div>
                    <div>
                        <img src="./images/update.svg" class = "register-image"></img>
                    </div>
                    <form action="./includes/update.php" method="POST">
                        <?php
                            $currentUser = $_SESSION['username'];
                            $sql = "SELECT * FROM user WHERE username = '$currentUser'";

                            $gotResults = mysqli_query($conn, $sql);

                            if ($gotResults) {
                                if (mysqli_num_rows($gotResults) > 0) {
                                    while ($row = mysqli_fetch_array($gotResults)) {
                                        ?>

                                        <div class = "form-inner">
                                            <div class = "input-box">
                                                <label class = "form-label">First Name</label>
                                                <input type = "text" name = "firstname" id = "firstname" value="<?php echo $row['firstname']; ?>"></input>
                                            </div>
                                            <div class = "input-box">
                                                <label class = "form-label">Last Name</label>
                                                <input type = "text" name = "lastname" id = "lastname" value="<?php echo $row['lastname']; ?>"></input>
                                            </div>
                                            <div class = "input-box">
                                                <label class = "form-label">Username</label>
                                                <input type = "text" name = "username" id = "username" value="<?php echo $row['username']; ?>"></input>
                                            </div>
                                            <div class = "input-box">
                                                <label class = "form-label">Email Address</label>
                                                <input type = "email" name = "email" id = "email" value="<?php echo $row['email']; ?>"></input>
                                            </div>
                                            <div class = "input-box">
                                                <label class = "form-label">Gender</label>
                                                <select class="gender" name="gender" id="gender">
                                                  <option value="Male">Male</option>
                                                  <option value="Female">Female</option>
                                                  <option value="Other">Other</option>
                                                </select>
                                            </div>
                                            <div class = "input-box">
                                                <label class = "form-label">Date of Birth</label>
                                                <input type = "date" name = "dob" id = "dob" value="<?php echo $row['dob']; ?>"></input>
                                            </div>
                                            
                                        </div>
                                        <div>
                                            <button class = "input-button" name="submit" type = "submit">Update</button>
                                        </div>

                                        <?php
                                    }
                                }
                            }
                        ?>
                         
                    </form>
                </div>

                <!----------profile delete form---------->
                <div class = "container-delete">
                    <div>
                        <h2>Delete My Profile</h2>
                    </div>
                    <div>
                        <img src="./images/delete.svg" class = "delete-image"></img>
                    </div>
                    <form action="./includes/delete.php" method="POST">
                        <div class = "delete-form-inner">
                            <div class = "delete-input-box">
                                <label class = "delete-form-label">Username</label>
                                <input type = "text" name = "dusername" id = "username"></input>
                            </div>
                            <div class = "delete-input-box">
                                <label class = "delete-form-label">Password</label>
                                <input type = "password" name = "dpassword" id = "dpassword"></input>
                            </div>
                            <div>
                                <button class = "delete-button" name="delete" type = "submit">Delete</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

            <?php
            if (isset($_GET['error'])) {
                if ($_GET['error'] == "emptyinput") {
                    echo '<script>alert("Fill in all fields!")</script>';
                } else if ($_GET["error"] == "invalidusername") {
                    echo '<script>alert("Choose a proper username!")</script>';
                } else if ($_GET["error"] == "usernamelength") {
                    echo '<script>alert("Username must be at least 6 characters!")</script>';
                } else if ($_GET["error"] == "invalidemail") {
                    echo '<script>alert("Choose a proper email!")</script>';
                } else if ($_GET["error"] == "emptydinput") {
                    echo '<script>alert("Fill in all fields!")</script>';
                } else if ($_GET["error"] == "wronginput") {
                    echo '<script>alert("Wrong username or password!")</script>';
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