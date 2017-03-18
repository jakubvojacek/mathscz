<?php
include("../pripojeni.php");
$reklama = $_POST["reklama"];
$zobrazit_reklamu = $_POST["zobrazit_reklamu"];
mysql_query("update nastaveni_otazky set reklama='$reklama', zobrazit_reklamu='$zobrazit_reklamu' where id = '1'") or die(mysql_error());

Header("Location: index.php?akce=nastaveni");
?>
