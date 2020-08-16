<?php
include "init.php";
if(isset($_POST['submit'])){
    if(user_exists($_POST['email'])){
        $_SESSION['email']=$_POST['email'];
        header("location:forgot_pwd_req.php");
    }
    else{
        die("This email id is not registered with us");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/styles.css">
    <title>Forgot Password</title>
</head>
<body>
   <div>
        <form action="" method="post" id="forgot_pwd">
        <div>
            <label for="email">Email</label>
            <input type="text" name="email" id="email">
        </div>
        <div>
            <button type="submit" name="submit" id="submit">Get OTP</button>
        </div>
        </form>
<!--   <div id="snackbar1">Sent Successfully</div>-->
<!--   <div id="snackbar2">Sending Failed</div>-->
   </div>
<!--   <script type="text/javascript" src="js/jquery.js"></script>-->
<!--   <script type="text/javascript" src="js/forgot_pwd.js"></script>-->
</body>
</html>