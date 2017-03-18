<?php
include("./pripojeni.php");
session_start();
$jmeno = $_POST["jmeno"];
$heslo1 = md5($_POST["heslo1"]);
$heslo2 = md5($_POST["heslo2"]);
$email = $_POST["email"];
$q = mysql_query("select * from uzivatele where nick = '$jmeno'");
if (mysql_num_rows($q) != 0){
    $_SESSION["info"] = array(0, "Toto uživatelské jméno již někdo používá. Vyberte si prosím jiné.");
    Header("Location: ".$_SERVER["HTTP_REFERER"]);
    }
elseif ($heslo1 != $heslo2){
    $_SESSION["info"] = array(0, "Zadaná hesla nejsou stejná. ");
    Header("Location: ".$_SERVER["HTTP_REFERER"]);
    }
elseif (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)){
    $_SESSION["info"] = array(0, "Zadaný email není email. ");
    Header("Location: ".$_SERVER["HTTP_REFERER"]);
    }
else{
    mysql_query("insert into uzivatele(nick, heslo, typ, email) values('$jmeno', '$heslo1', '3', '$email')") or die(mysql_error());
    $_SESSION["info"] = array(1, "Registrace byla úspěšná, nyní se můžete přihlásit");
    Header("Location: index.php");
    }





?>
