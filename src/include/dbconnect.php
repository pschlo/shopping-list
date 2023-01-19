<?php

$db_user = 'shopping_list';
$db_password = 'password123';
$db_host = 'localhost';
$db_name = 'shopping_list';

$dbc = @mysqli_connect($db_host, $db_user, $db_password, $db_name);
mysqli_set_charset($dbc,"utf8");

if (!$dbc) {
    die('Could not connect to MySQL: '.mysqli_connect_error());
}