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
?>