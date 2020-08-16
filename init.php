<?php

// Start headers and sessions
//ob_start();
session_start();

// MySQL Connection
$db=mysqli_connect("localhost", "root", "", "arbre_expense");

// Include func files
include "functions/user.func.php";
include "functions/expense.func.php";
include "functions/income.func.php";
include "functions/category.func.php";
include "functions/mail.func.php";

if (empty($_SESSION['token'])) {
    if (function_exists('mcrypt_create_iv')) {
        $_SESSION['token'] = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
    }   else {
        $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
    }
}
$token = $_SESSION['token'];
?>