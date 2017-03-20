<?php
include("../pripojeni.php");
$jmeno = $_POST["jmeno"];
$nadrazena = $_POST["nadrazena"];
mysqli_query(DATABASE::getDb(), "insert into kategorie_otazky(jmeno, nadrazena) values('$jmeno', '$nadrazena')");
Header("Location: index.php?akce=kategorie");
?>
