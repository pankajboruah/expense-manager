<?php
session_start();
session_destroy();
setcookie("uid", "0", time()-60*60);
header("location: index.php");
?>