<?php
include "init.php";
if(isset($_POST['submit'])){
    if($_POST['otp']==$_SESSION['otp']){
        $new_pwd=$_POST['new_pwd'];
        $confirm_pwd=$_POST['confirm_pwd'];
        if ($new_pwd==$confirm_pwd) {
            reset_pwd($_SESSION['email'], $new_pwd);
        }
        else{
//            echo '<script type="text/javascript">alert("Passwords donot match");</script>';;
            die("passwords donot match");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>RESET PASSWORD</title>
</head>
<body>
    <div>
        <form action="" method="post">
            <div>
                <label for="new_pwd">New Password</label>
                <input type="password" name="new_pwd" required>
            </div>
            <div>
                <label for="confirm_pwd">Confirm Password</label>
                <input type="password" name="confirm_pwd" required>
            </div>
            <div>
                <label for="otp">Enter OTP</label>
                <input type="text" name="otp" required>
            </div>
            <div>
                <button type="submit" name="submit">Reset Password</button>
            </div>
        </form>
    </div>
</body>
</html>