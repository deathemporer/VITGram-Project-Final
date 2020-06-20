<?php
function logout(){
    //session_start();
    session_destroy();
    setcookie("useremail", "", time()-3600);
    setcookie("userpass", "", time()-3600);
    header("location:index.php");
}
?>