<?php

global $dbc;
require "dbconnect.php";

switch ($_POST["button"]) {
    case "delete":
        $sql = "DELETE FROM items WHERE id=?";
        $stmt = mysqli_stmt_init($dbc);
        mysqli_stmt_prepare($stmt, $sql) or die("error");
        mysqli_stmt_bind_param($stmt, "i", $_POST["id"]);
        mysqli_stmt_execute($stmt);
        break;

    case "save":
        $sql = "UPDATE items SET name=?, amount=?, comment=?, category_id=? WHERE id=?";
        $stmt = mysqli_stmt_init($dbc);
        mysqli_stmt_prepare($stmt, $sql) or die("error");
        mysqli_stmt_bind_param($stmt, "sisii", $_POST["name"], $_POST["amount"], $_POST["comment"], $_POST["category_id"], $_POST["id"]);
        mysqli_stmt_execute($stmt);
        break;
}

header("Location: ../shopping_list.php");