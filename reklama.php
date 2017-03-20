<?php
/* 
Jakub Vojáček
*/
include("./funkce/pripojeni.php");
mysqli_query(DATABASE::getDb(), "update reklama set pocet = pocet +1 where id = '1'");
Header("Location: http://digitalnivzpominky.cz/skenovani-diapozitivu.php");
?>
