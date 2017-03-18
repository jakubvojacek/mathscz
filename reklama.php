<?php
/* 
Jakub Vojáček
*/
include("./funkce/pripojeni.php");
mysql_query("update reklama set pocet = pocet +1 where id = '1'");
Header("Location: http://digitalnivzpominky.cz/skenovani-diapozitivu.php");
?>
