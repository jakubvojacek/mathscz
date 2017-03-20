<?php
Header('Content-type: text/html; charset=utf-8');
include("../funkce/pripojeni.php");
include("../funkce/funkce.php");
include("./kontrola.php");
je_prihlasen();
@session_start();
/*if (skupina != 1){
    $_SESSION["zprava"] = array(0, "Pro tuto akci nemáte práva");
    Header("Location: index.php");    
    return;
    } */

$jmeno = $_POST["jmeno"];
$nadrazena = $_POST["nadrazena"];
/*
if (skupina != 0){
    echo '<p>Do této kategorie nemáte přístup</p>';
    return;    
    }
*/ 
mysqli_query(DATABASE::getDb(), "insert into kategorie(jmeno, nadrazena) values('$jmeno', '$nadrazena')");
Header("Location: index.php?akce=kategorie");
?>
