<?php
    global $dbc;
    require "include/dbconnect.php";

    //$useragent=$_SERVER['HTTP_USER_AGENT'];

    //if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {
    //    header('Location: mobile.php');
    //}

    // Überprüfe, ob eingeloggt
    session_start();
    if (!isset($_SESSION["id"])) {
        header("Location: index.php");
        exit();
    }


    // Kategorien-Tabelle holen
    $cat_rows = [];
    $query = "SELECT * FROM categories ORDER BY name";
    $result = mysqli_query($dbc, $query) or die("error");
    while ($row = mysqli_fetch_assoc($result)) {
        $cat_rows[] = $row;
    }

?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=10.0, minimum-scale=0.2">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Einkaufsliste</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class=content>
        <h1>Einkaufsliste</h1>
        <header>
            <p>Eingeloggt als <?=$_SESSION["email"]?></p>
            <form action="include/logout.php" method="POST">
                <button>Abmelden</button>
            </form>
        </header>
        <table>
            <tr>
                <th>Artikel</th>
                <th>Anzahl</th>
                <th>Kategorie</th>
                <th>Bemerkung</th>
            </tr>
            <form action="include/add_item.php" method="POST">
                <tr class=add-item-row>
                    <td>
                        <input type="text" name="name" placeholder="Artikel" required>
                    </td>
                    <td>
                        <input type="number" name="amount" placeholder="Anzahl" required>
                    </td>
                    <td>
                        <select name="category_id">
<?php
    foreach ($cat_rows as $row) {
?>
                            <option value="<?=$row["id"]?>"><?=$row["name"]?></option>
<?php
    }
?>
                        </select>
                    </td>
                    <td>
                        <input type="text" name="comment" placeholder="Bemerkung">
                    </td>
                    <td>
                        <button class="add"></button>
                    </td>
                </tr>
            </form>
<?php
    // item zeilen aufbauen
    $query = "SELECT items.id, items.name, items.amount, items.comment, items.category_id FROM items WHERE items.user_id=? ORDER BY items.category_id, items.name";
    
    $stmt = mysqli_stmt_init($dbc);
    mysqli_stmt_prepare($stmt, $query) or die("error");
    mysqli_stmt_bind_param($stmt, "i", $_SESSION["id"]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
?>
            <form action="include/change_item.php" method="POST">
                <input type="hidden" name="id" value="<?=$row["id"]?>">
                <tr class="itemrow">
                    <td>
                        <input type="text" name="name" value="<?=$row["name"]?>">
                    </td>
                    <td>
                        <input type="number" name="amount" value="<?=$row["amount"]?>">
                    </td>
                    <td>
                        <select name="category_id">
<?php
        foreach ($cat_rows as $cat_row) {
            if ($cat_row["id"] == $row["category_id"]) {
?>
                            <option value="<?=$cat_row["id"]?>" selected><?=$cat_row["name"]?></option>
<?php
            } else {
?>
                            <option value="<?=$cat_row["id"]?>"><?=$cat_row["name"]?></option>
<?php       }
        }
?>
                        </select>
                    </td>
                    <td>
                        <input type="text" name="comment" value="<?=$row["comment"]?>">
                    </td>
                    <td>
                        <button class="delete" name="button" value="delete"></button>
                    </td>
                    <td>
                        <button class="save" name="button" value="save"></button>
                    </td>
                </tr>
            </form>
<?php
    }
?>
        </table>
    </div>
    <footer id=footer>
    </footer>
</body>
</html>

