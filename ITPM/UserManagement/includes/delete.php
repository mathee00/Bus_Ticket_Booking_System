<?php
session_start();

    
    if (isset($_POST['delete'])) {
        $dusername = $_POST['dusername'];
        $dpassword = $_POST['dpassword'];

        require_once 'config.php';
        require_once 'function.php';

        if (emptyInputDelete($dusername, $dpassword) !== false) {
            header("location: ../userProfile.php?error=emptydinput");
            exit();
        }

        deleteUser($conn, $dusername, $dpassword);
    } else {
        header("location: delete.php");
    }

    
?>