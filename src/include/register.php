<?php

global $dbc;
require 'dbconnect.php';

$email = $_POST["email"];
$password = $_POST["password"];

$sql = "SELECT email FROM users WHERE email=?";
$stmt = mysqli_stmt_init($dbc);
mysqli_stmt_prepare($stmt, $sql) or die("error");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
$resultCheck = mysqli_stmt_num_rows($stmt);
// Überprüfe, ob E-Mail-Adresse bereits registriert
if ($resultCheck > 0) {
    header("Location: ../index.php?error=userTaken");
    exit();
}
// füge User hinzu
$sql = "INSERT INTO users (email, password) VALUES (?, ?)";
$stmt = mysqli_stmt_init($dbc);
mysqli_stmt_prepare($stmt, $sql) or die("error");

$pwd_hash = password_hash($password, PASSWORD_DEFAULT);
mysqli_stmt_bind_param($stmt, "ss", $email, $pwd_hash);
mysqli_stmt_execute($stmt);
header("Location: ../index.php?succ=signup-succ");