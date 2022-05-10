<?php
session_start();

    
    if (isset($_POST['book'])) {
        $sid = $_POST['sid'];
        $uname = $_POST['uname'];
        $quantity = $_POST['quantity'];

        require_once 'config.php';
        require_once 'function.php';

        book($conn, $sid, $uname, $quantity);
    }
?>