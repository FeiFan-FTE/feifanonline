<?php 
session_start();

$expire=time()-3600;
$_SESSION['useremail']="";
setcookie("useremail","",$expire,"/");
setcookie("username", "",$expire,"/");
setcookie("userface", "",$expire,"/");
setcookie("userid", "",$expire,"/");

header('Location: index.php'); 
 ?>