<?php
include("../funkce/pripojeni.php");
$id = $_GET["id"];
mysql_query("update clanky set upraven = '1' where id = '$id'") or die(mysql_error());
Header("Location: ".$_SERVER["HTTP_REFERER"]);
?>
