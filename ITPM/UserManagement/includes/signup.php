<?php

if (isset($_POST['submit'])) {
    
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];

    require_once 'config.php';
    require_once 'function.php';

    if (emptyInputSignup($firstname, $lastname, $username, $email, $password) !== false) {
        header("location: ../userRegistration.php?error=emptyinput");
        exit();
    }
    if (invalidUsername($username) !== false) {
        header("location: ../userRegistration.php?error=invalidusername");
        exit();
    }
    if (usernameLength($username) !== false) {
        header("location: ../userRegistration.php?error=usernamelength");
        exit();
    }
    if (invalidEmail($email) !== false) {
        header("location: ../userRegistration.php?error=invalidemail");
        exit();
    }
    if (passwordLength($password) !== false) {
        header("location: ../userRegistration.php?error=passwordlength");
        exit();
    }
    if (passwordMatch($password, $cpassword) !== false) {
        header("location: ../userRegistration.php?error=passwordmismatch");
        exit();
    }
    if (usernameExists($conn, $username, $email) !== false) {
        header("location: ../userRegistration.php?error=usernameexists");
        exit();
    }

    createUser($conn, $firstname, $lastname, $username, $email, $password);

} else {
    header("location: signup.php");
}

?>