<?php
Header('Content-type: text/html; charset=utf-8');
include("../funkce/pripojeni.php");
include("../funkce/funkce.php");
include("./kontrola.php");
je_prihlasen();
@session_start();
if (skupina != 0){
    $_SESSION["zprava"] = array(0, "Pro tuto akci nemáte práva");
    Header("Location: index.php");    
    return;
    }


$nazev_webu = $_POST["nazev_webu"];
$klicova_slova = $_POST["klicova_slova"];
$url_webu = $_POST["url_webu"];
$popis_webu = $_POST["popis_webu"];  
$reklama = $_POST["reklama"];    
mysql_query("update nastaveni set reklama='$reklama', popis_webu='$popis_webu', url_webu='$url_webu',  nazev_webu='$nazev_webu', klicova_slova='$klicova_slova' where id = '1'") or die(mysql_error());
Header("Location: index.php?akce=nastaveni");
?>
