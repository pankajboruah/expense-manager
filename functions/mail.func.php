<?php
function make($filename, $data){
    extract($data);
    ob_start();
    include "$filename";
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

function otp() {
//    $result = '';
    return $result = mt_rand(100000, 999999);
//    return $result;
}
?>