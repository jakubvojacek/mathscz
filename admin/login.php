<?php
include("../funkce/pripojeni.php");
include("../funkce/funkce.php");
session_start();
$jmeno = $_POST["uzivatelske_jmeno"];
$heslo = md5($_POST["heslo"]);
$v = mysql_query("select * from uzivatele where nick = '$jmeno' and heslo = '$heslo'");
if (mysql_num_rows($v) == 0){
    $_SESSION["zprava"] = array(0, "Chybné přihlašovací údaje");
    Header("Location: index.php");
    return;
    }
$v = mysql_fetch_array($v);

setcookie("id", $v["id"], time()+1209600, '/', '');
setcookie("heslo", $v["heslo"], time()+1209600, '/', '');

Header("Location: index.php");  
?>
