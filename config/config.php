<?php
$db="DMP";
$db_password="vistart3";
$db_user="root";
$db_host="172.31.20.191"; 


$con = new mysqli($db_host, $db_user, $db_password, $db);
if ($con->connect_error) {
    die('Connect Error (' . $con->connect_errno . ') '
            . $con->connect_error);
}

?>

