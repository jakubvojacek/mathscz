<?php
include("./funkce/pripojeni.php");
include("./funkce/funkce.php");

$heslo = md5($_POST["heslo_"]);
$jmeno = $_POST["jmeno_"];
$email = $_POST["email_"];
$link = seo_url($jmeno).".html";
$cas = time();
$ip = $_SERVER["REMOTE_ADDR"];
mysql_query("insert into uzivatele(jmeno, heslo, email, typ, link) values('$jmeno', '$heslo', '$email', '2', '$link')") or die(mysql_error());
@session_start();
$_SESSION["prihlaseni"] = "Registrace proběhla úspěšně, nyní se můžete přihlásit. ";

Header("Location: akce/prihlaseni");
?>

