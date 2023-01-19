<?php

    session_start();
    if (isset($_SESSION["id"])) {
        header("Location: shopping_list.php");
        exit();
    }

?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=10.0, minimum-scale=0.2">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Einkaufsliste</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body class=content>
    <header>
        <h1>Willkommen bei Einkaufsliste!</h1>
        <h2>Deine eigene Einkaufsliste. Immer parat.</h2>
    </header>
<?php
    // Hinweisnachrichten anzeigen
    if (isset($_GET["error"])) {
?>
    <p class=error-msg>
<?php
        switch ($_GET["error"]) {
            case "userTaken":
?>
        Diese E-Mail-Adresse ist bereits registriert
<?php
                break;
            case "unknownEmail":
?>
        Diese E-Mail-Adresse ist nicht registriert
<?php
                break;
            case "wrongPassword":
?>
        Falsches Passwort!
<?php
                break;
        }
?>
    </p>
<?php
    }
    if (isset($_GET["succ"])) {
?>
    <p class=succ-msg>
<?php
        switch ($_GET["succ"]) {
            case "logout-succ":
?>
        Erfolgreich ausgeloggt!
<?php
                break;
            case "signup-succ":
?>
        Erfolgreich registriert!
<?php
                break;
        }
?>
    </p>
<?php
    }
?>
    <form class="login-form" method="POST">
        <input type="email" name="email" placeholder=E-Mail-Adresse required>
        <input type="password" name="password" placeholder=Passwort required>
        <button type="submit" formaction="include/login.php">Anmelden</button>
        <button type="submit" formaction="include/register.php">Registrieren</button>
    </form>
</body>
</html>