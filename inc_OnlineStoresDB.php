<?php
/*

Exercise 02.10.01

Author: Abraham Aguilar
Date: 12.10.18

inc_OnlineStoresDB.php

*/

$errorMsgs = array();

$hostName = "localhost";
$userName = "adminer";
$passwd = "hurry-leave-06";
$DBName = "onlinestores2";
$DBConnect = @new mysqli($hostName, $userName, $passwd, $DBName);

if ($DBConnect->connect_error) {
    $errorMsgs[] = "Unable to connect to the database server.  Error code " . $DBConnect->connect_errno . ": " . $DBConnect->connect_error;
}
?>
