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

    <link rel="stylesheet" href="css/userDashboard.css">
    <link rel="shortcut icon" type="image/png" href="images/logob.png">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body>

    <!----------navigation bar---------->
    <div class="header">
        <div class="navbar">
            <img src="images/logow.png" class="logo">
            <nav>
                <ul>
                    <li><a class="active" href="#">Home</a></li>
                    <li><a href="bookTicket.php">Book Ticket</a></li>
                    <li><a href="myBooking.php">My Bookings</a></li>
                    <li><a href="userProfile.php">My Profile</a></li>
                    <li><a href="./includes/logout.php">Log Out</a></li>
                </ul>
            </nav>
        </div>

        <!----------search field---------->
        <div class="search-box">
            <div class="search-bar">
                <form method="POST">
                    <h1>Search Available Buses for Your Journey</h1>
                    <div class="from-input">
                        <label>From: </label>
                        <input type="text" placeholder="Start Point" name="spoint" id="spoint" required>
                    </div>
                    <div class="to-input">
                        <label>To: </label>
                        <input type="text" placeholder="End Point" name="epoint" id="epoint">
                    </div>
                    <button type="submit" name="search"><span></span>SEARCH BUSES</button>
                </form>
            </div>
        </div>   
    </div>

    <!----------search result---------->
    <div class="card-booking">
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
                    if (isset($_POST['search'])) {
                        $search = mysqli_real_escape_string($conn, $_POST['spoint']);
                        $sql = "SELECT *
                                FROM ((schedule_list
                                INNER JOIN bus ON schedule_list.bus_id = bus.id)
                                INNER JOIN location ON schedule_list.from_location = location.id)
                                WHERE schedule_list.from_location LIKE '%$search%'";
                        $result = mysqli_query($conn, $sql);
                        $queryResult = mysqli_num_rows($result);

                            if ($queryResult > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
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
                                <input type="number" id="quantity" name="quantity" min="1" max="30" required></input>
                                                        
                        </td>
                        <td>
                            <button name="book">Book</button>
                            </form>
                        </td>
                    </tr>
                </tbody>
                <?php 
                                }
                            } else {
                                echo "There are no results matching your search!";
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