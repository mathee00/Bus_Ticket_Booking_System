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

    <link rel="stylesheet" href="css/bookTicket.css">
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
                    <li><a class="active" href="#">Book Ticket</a></li>
                    <li><a href="myBooking.php">My Bookings</a></li>
                    <li><a href="userProfile.php">My Profile</a></li>
                    <li><a href="./includes/logout.php">Log Out</a></li>
                </ul>
            </nav>
        </div>
        <hr>

        <!----------schedule view---------->
        <div class="card-booking">
            <div class="card-header">
                <div>
                    <h2>Available Buses</h2>
                </div>
            </div>
            <div class="card-body">            
                <table class ="content-table">
                    <thead>
                        <tr>
                            <th>Bus Number</th>
                            <th>Bus Type</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Departure Time</th>
                            <th>Arrival Time</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <?php
                        $sql = "SELECT *
                                FROM schedule_list
                                INNER JOIN bus ON schedule_list.bus_id = bus.id
                                WHERE schedule_list.status = 1";

                        $gotResults = mysqli_query($conn, $sql);

                        if ($gotResults) {
                            if (mysqli_num_rows($gotResults) > 0) {
                                while ($row = mysqli_fetch_array($gotResults)) {
                                    $from_location = $conn->query("SELECT id,Concat(city) as location FROM location where id = ".$row['from_location'])->fetch_array()['location'];
	                                $to_location = $conn->query("SELECT id,Concat(city) as location FROM location where id = ".$row['to_location'])->fetch_array()['location'];
                                    ?>
                                    <tbody>
                                        <tr>
                                            <td><?php echo $row['bus_number']; ?></td>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo $row['from_location'] = $from_location; ?></td>
                                            <td><?php echo $row['to_location'] = $to_location; ?></td>
                                            <td><?php echo $row['departure_time']; ?></td>
                                            <td><?php echo $row['eta']; ?></td>
                                            <td>LKR <?php echo $row['price']; ?></td>
                                            <td>
                                                <form action="./includes/booking.php" method="POST">
                                                <input type="hidden" name="sid" value="<?php echo $row['id']; ?>"></input>
                                                <input type="hidden" name="uname" value="<?php echo $_SESSION['username']; ?>"></input>
                                                <input type="number" id="quantity" name="quantity" min="1" max="30"></input>
                                                
                                            </td>
                                            <td>
                                                <button name="book">Book</button>
                                                </form>
                                            </td>
                                        </tr>
                                    </tbody>
                    <?php
                                }
                            }
                        } 
                    ?>
                </table>                                      
            </div>
        </div>

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