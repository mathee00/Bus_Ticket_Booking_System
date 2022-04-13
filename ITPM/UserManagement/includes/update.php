<?php
session_start();

    if (isset($_POST['submit'])) {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $gender = $_POST['gender'];
        $dob = $_POST['dob'];

        require_once 'config.php';
        require_once 'function.php';

        if (emptyInputUpdate($firstname, $lastname, $username, $email) !== false) {
            header("location: ../userProfile.php?error=emptyinput");
            exit();
        }
        if (invalidUsername($username) !== false) {
            header("location: ../userProfile.php?error=invalidusername");
            exit();
        }
        if (usernameLength($username) !== false) {
            header("location: ../userProfile.php?error=usernamelength");
            exit();
        }
        if (invalidEmail($email) !== false) {
            header("location: ../userProfile.php?error=invalidemail");
            exit();
        }

        updateUser($conn, $firstname, $lastname, $username, $email, $gender, $dob);
    }

    
?>