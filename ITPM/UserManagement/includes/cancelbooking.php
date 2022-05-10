<?php
session_start();

    
    if (isset($_POST['cbooking'])) {
        $rno = $_POST['rno'];

        require_once 'config.php';
        require_once 'function.php';

        cancelbooking($conn, $rno);
    }
?>