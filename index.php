<?php
if (!isset($_COOKIE['firsttime']))
{
    setcookie("firsttime", "no" , time() + (86400 * 30), "/");
	//header('Location: first.php');
	    header('Location: home.php');
    exit();
}
else
{
    header('Location: home.php');
    exit();
}
?>
