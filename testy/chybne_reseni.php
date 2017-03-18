<?php
include("./pripojeni.php");
$id = $_GET["id"];
mysql_query("insert into chyby(otazka, cas) values('$id', current_timestamp())") or die(mysql_error())

?>
