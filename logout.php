<?php 
session_start();

session_unset();
unset($_SESSION['user_id']);  
$_SESSION = array(); 
	
//unset($_SESSION);	
//unset($session_id);
unset($_SESSION['FBID']);
unset($_SESSION['FULLNAME']);
unset($_SESSION['EMAIL']);
clearstatcache();	
session_destroy();
header('Location: home.php');
exit();
?>