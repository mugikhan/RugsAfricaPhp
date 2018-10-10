<?php
    session_start();

    if(isset($_SESSION['customer'])){
        unset($_SESSION['customer']);
    }
    header("Location: index.php");

?>