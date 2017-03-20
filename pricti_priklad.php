<?php

include("./funkce/pripojeni.php");

$id = $_GET["id"];

mysqli_query(DATABASE::getDb(), "update priklady set pocet_precteni = pocet_precteni +1 where id = '$id'") or die(mysql_error());



?>

