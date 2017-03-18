<?php
header('Content-Type:text/html; charset=utf-8');
include("./pripojeni.php");
$jmeno = $_POST["jmeno"];
$heslo = md5($_POST["heslo"]);
//echo $jmeno." ".$heslo. " ".$jmeno == "Jakub Vojáček";
//echo "select * from uzivatele where nick = '$jmeno' and heslo = '$heslo'";
$q = mysql_query("select * from uzivatele where nick = '$jmeno' and heslo = '$heslo'");
if (mysql_num_rows($q) == 0){
    //spatna kombinace;

    session_start();
    $_SESSION["info"]=array(0,"Špatná kombinace uživatelského jména a hesla");
    Header("Location: index.php?akce=prihlasit");
    }
else{
    $v = mysql_fetch_array($q);
    setcookie("id", $v["id"], time()+24*3600, "/");
    setcookie("heslo", $heslo, time()+24*3600, "/");
    Header("Location: index.php");
    }


?>

