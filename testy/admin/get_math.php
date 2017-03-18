<?php
include("../pripojeni.php");
if (IsSet($_GET["id"])){
    $id = $_GET["id"];

    $vypis = mysql_query("select obr from tex where id = '$id'") or die(mysql_error());
    $vypis = mysql_fetch_array($vypis)or die(mysql_error());
    $img = $vypis["obr"];
    $img = base64_decode($img);
    header('Content-type: image/gif');
    header('Content-Lenght: '. strlen($img));
    echo $img;
    flush();
    }
exit();

?>
