<?php
include("../funkce/pripojeni.php");
include("../funkce/funkce.php");
include("kontrola.php");
$jmeno = $_POST["jmeno_"];
$seo = seo_url($jmeno);
mysql_query("insert into testy(jmeno, link) values('$jmeno' ,'$seo')") or die(mysql_error());
Header("Location: index.php?akce=testy&test=".mysql_insert_id());
?>
