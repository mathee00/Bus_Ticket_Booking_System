<?php 
// user registration

function emptyInputSignup($firstname, $lastname, $username, $email, $password) {
	$result;
	if (empty($firstname) || empty($lastname) || empty($username) || empty($email) || empty($password)) {
		$result = true;
	} else {
		$result = false;
	}
	return $result;
}

function invalidUsername($username) {
	$result;
	if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
		$result = true;
	} else {
		$result = false;
	}
	return $result;
}

function usernameLength($username) {
	$result;
	if (strlen($username) < 6) {
		$result = true;
	} else {
		$result =false;
	}
	return $result;
}

function invalidEmail($email) {
	$result;
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$result = true;
	} else {
		$result = false;
	}
	return $result;
}

function passwordLength($password) {
	$result;
	if (strlen($password) < 8 || strlen($password) > 12) {
		$result = true;
	} else {
		$result =false;
	}
	return $result;
}

function passwordMatch($password, $cpassword) {
	$result;
	if ($password !== $cpassword) {
		$result = true;
	} else {
		$result = false;
	}
	return $result;
}

function usernameExists($conn, $username, $email) {
	$sql = "SELECT * FROM user WHERE username = ? OR email = ?;";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("location: ../userRegistration.php?error=stmtfailed");
		exit();
	}

	mysqli_stmt_bind_param($stmt, "ss", $username, $email);
	mysqli_stmt_execute($stmt);

	$resultData = mysqli_stmt_get_result($stmt);

	if ($row = mysqli_fetch_assoc($resultData)) {
		return $row;
	}
	else {
		$result = false;
		return $result;
	}

	mysqli_stmt_close($stmt);
}


function createUser($conn, $firstname, $lastname, $username, $email, $password) {
	$sql = "INSERT INTO user (firstname, lastname, username, email, password) VALUES (?,?,?,?,?);";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("location: ../userRegistration.php?error=stmtfailed");
		exit();
	}

	$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

	mysqli_stmt_bind_param($stmt, "sssss", $firstname, $lastname, $username, $email, $hashedPassword);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	header("location: ../userRegistration.php?error=none");
	exit();
}

// login

function emptyInputLogin($username, $password) {
	$result;
	if (empty($username) || empty($password)) {
		$result = true;
	} else {
		$result = false;
	}
	return $result;
}

function loginUser($conn, $username, $password) {
	$usernameExists = usernameExists($conn, $username, $username);

	if ($usernameExists === false) {
		header("location: ../userLogin.php?error=wrongLogin");
		exit();
	}

	$passwordHashed = $usernameExists["password"];
	$checkpassword = password_verify($password, $passwordHashed);

	if ($checkpassword === false) {
		header("location: ../userLogin.php?error=wrongLogin");
		exit();
	} else if ($checkpassword === true) {
		session_start();
		$_SESSION['userid'] = $usernameExists["id"];
		$_SESSION['username'] = $usernameExists["username"];
		header("location: ../userDashboard.php");
		exit();
	}
}

function check_login($conn)
{
    if(isset($_SESSION['username']))
    {
        $username = $_SESSION['username'];
        $query = "SELECT * FROM user WHERE username = '$username' limit 1";

        $result = mysqli_query($conn,$query);
        if($result && mysqli_num_rows($result) > 0)
        {
            $user_data = mysqli_fetch_assoc($result);
            return $user_data;
        }
    }

    // redirect to login
    header("Location: ../userLogin.php");
    die;
}

// update profile

function emptyInputUpdate($firstname, $lastname, $username, $email) {
	$result;
	if (empty($firstname) || empty($lastname) || empty($username) || empty($email)) {
		$result = true;
	} else {
		$result = false;
	}
	return $result;
}

function updateUser($conn, $firstname, $lastname, $username, $email, $gender, $dob) {
	$loggedInUser = $_SESSION['username'];

    $sql = "UPDATE user SET firstname = '$firstname' , lastname = '$lastname' , username = '$username' , email = '$email' , gender = '$gender' , dob = '$dob' WHERE username = '$loggedInUser'";

    $results = mysqli_query($conn, $sql);
    header('location: ../userDashboard.php');
	exit();
}

//delete

function emptyInputDelete($dusername, $dpassword) {
	$result;
	if (empty($dusername) || empty($dpassword)) {
		$result = true;
	} else {
		$result = false;
	}
	return $result;
}

function deleteUser($conn, $dusername, $dpassword) {
	$usernameExists = usernameExists($conn, $dusername, $dusername);

	if ($usernameExists === false) {
		header("location: ../userProfile.php?error=wronginput");
		exit();
	}

	$passwordHashed = $usernameExists["password"];
	$checkpassword = password_verify($dpassword, $passwordHashed);

	if ($checkpassword === false) {
		header("location: ../userProfile.php?error=wronginput");
		exit();
	} else if ($checkpassword === true) {
		$sql = "INSERT INTO deleted_user
				SELECT * FROM user
				WHERE username = '$dusername'";
		$sql_run = mysqli_query($conn, $sql);

		$query = "DELETE FROM user WHERE username = '$dusername'";
    	$query_run = mysqli_query($conn, $query);
		header("location: ../home.php");
		exit();
	}
}

//book

function book($conn, $sid, $uname, $quantity) {
    $sql = "INSERT INTO booked (schedule_id, name, qty) VALUES (?,?,?);";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("location: ../bookTicket.php?error=stmtfailed");
		exit();
	}

	mysqli_stmt_bind_param($stmt, "isi",$sid, $uname, $quantity);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	header("location: ../myBooking.php?error=none");
	exit();
}

//cancel booking

function cancelbooking($conn, $rno) {

	$cbquery = "DELETE FROM booked WHERE ref_no = '$rno'";
                    $query_run = mysqli_query($conn, $cbquery);
                    header("location: ../myBooking.php");
                    exit();
	
}
?>