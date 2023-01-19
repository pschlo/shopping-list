<?php

global $dbc;
require 'dbconnect.php';

$email = $_POST["email"];
$password = $_POST["password"];

$sql = "SELECT * FROM users WHERE email=?";
$stmt = mysqli_stmt_init($dbc);
mysqli_stmt_prepare($stmt, $sql) or die("error");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
if (!($row)) {
    header("Location: ../index.php?error=unknownEmail");
    exit();
}
$pwdCheck = password_verify($password, $row['password']);
if (!($pwdCheck)) {
    header("Location: ../index.php?error=wrongPassword");
    exit();
}
session_start();
$_SESSION['id'] = $row['id'];
$_SESSION['email'] = $row['email'];
header("Location: ../shopping_list.php");
exit();