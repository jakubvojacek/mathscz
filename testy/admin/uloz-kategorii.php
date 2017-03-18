<?php
include("../pripojeni.php");
$jmeno = $_POST["jmeno"];
$nadrazena = $_POST["nadrazena"];
mysql_query("insert into kategorie_otazky(jmeno, nadrazena) values('$jmeno', '$nadrazena')");
Header("Location: index.php?akce=kategorie");
?>
