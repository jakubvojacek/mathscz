<?php
include("../funkce/pripojeni.php");
include("kontrola.php");
$otazka = $_POST["otazka"];   
$reseni = $_POST["reseni"];
$id = $_POST["id"];
if ($id == -1){
    mysql_query("insert into priklady(otazka, reseni) values('$otazka', '$reseni')") or die(mysql_error());
    }
else{
    mysql_query("update priklady set otazka = '$otazka', reseni = '$reseni' where id = '$id'") or die(mysql_error());
    }

Header("Location: index.php?akce=priklady");
?>
