<?php
include("funkce/pripojeni.php");
include("funkce/funkce.php");
@session_start();
$jmeno = $_POST["uzivatelske_jmeno"];
$heslo = md5($_POST["heslo"]);
$q = mysqli_query(DATABASE::getDb(), "select * from uzivatele where nick = '$jmeno' and heslo = '$heslo'");
if (mysqli_num_rows($q) == 0){
    $_SESSION["prihlaseni"] = "Chybné přihlašovací údaje";
    Header("Location: akce/prihlaseni");
    return;
    }
$v = mysqli_fetch_array($q);
setcookie("id", $v["id"], time()+1209600, '/', '');
setcookie("heslo", $v["heslo"], time()+1209600, '/', '');
Header("Location: index.php");


?>
