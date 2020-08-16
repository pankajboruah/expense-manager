<?php
session_start();
$db=mysqli_connect("localhost", "root", "", "arbre_expense");
include "functions/user.func.php";
include "functions/expense.func.php";
include "functions/income.func.php";
include "functions/category.func.php";
?>