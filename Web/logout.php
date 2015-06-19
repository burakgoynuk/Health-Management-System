<?php

    session_start();
    $_SESSION['loggedin']   = false;
	$_SESSION['employeeID'] = '';
	$_SESSION['user_type']  = '';
    header("Location: index.php");

?>