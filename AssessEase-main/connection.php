<?php

$hostName = "localhost";
$dbUser = "root";
$dbPassword = "15a5m249ph";
$dbName = "accounts";

$con = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);

if (!$con) {
	die("something went wrong;");
}
