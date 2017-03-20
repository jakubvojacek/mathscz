<?php
include("./pripojeni.php");
$id = $_GET["id"];
mysqli_query(DATABASE::getDb(), "insert into chyby(otazka, cas) values('$id', current_timestamp())") or die(mysql_error())

?>
