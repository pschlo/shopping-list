<?php
global $dbc;
require "dbconnect.php";

session_start();

$name = $_POST["name"];
$amount = $_POST["amount"];
$comment = $_POST["comment"];
$category_id = $_POST["category_id"];

$sql = "INSERT INTO items (name, amount, comment, category_id, user_id) VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_stmt_init($dbc);
mysqli_stmt_prepare($stmt, $sql) or die("error");
mysqli_stmt_bind_param($stmt, "sisii", $name, $amount, $comment, $category_id, $_SESSION["id"]);
mysqli_stmt_execute($stmt);

header("Location: ../shopping_list.php");