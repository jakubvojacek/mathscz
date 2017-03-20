<?php
include("../pripojeni.php");
if (IsSet($_GET["id"])){
    $id = $_GET["id"];

    $vypis = mysqli_query(DATABASE::getDb(), "select obr from tex where id = '$id'") or die(mysql_error());
    $vypis = mysqli_fetch_array($vypis)or die(mysql_error());
    $img = $vypis["obr"];
    $img = base64_decode($img);
    header('Content-type: image/gif');
    header('Content-Lenght: '. strlen($img));
    echo $img;
    flush();
    }
exit();

?>
