<?php
include("funkce/pripojeni.php");
include("funkce/funkce.php");
function jmeno_existuje($jmeno){
    $seo = seo_url($jmeno).".html";
    $vypis = mysqli_query(DATABASE::getDb(), "select nick from uzivatele where link = '$seo'");
    if (mysqli_num_rows($vypis) == 0){
        return false;
        }
    return true;
    }
function email_existuje($email){
    $vypis = mysqli_query(DATABASE::getDb(), "select email from uzivatele where email = '$email'");
    if (mysqli_num_rows($vypis) == 0){
        return false;
        }
    return true;
    }   
$email = $_GET["email"];
$jmeno = $_GET["jmeno"];
$heslo = $_GET["heslo"];
$heslo2 = $_GET["heslo2"];


    
    
if (Trim($jmeno) == ""){
    echo "0||Musíte vyplnit jméno";
    }
elseif (jmeno_existuje($jmeno)){
    echo "o||Toto jméno se již používá. ";
    }
elseif (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)){
    echo "0||Email má špatný formát";
    }
elseif (email_existuje($email)){
    echo "0||Tento email je již registrovaný. Použijte jiný";
    }
elseif ($heslo != $heslo2){
    echo "0||Hesla musí být stejná";
    }
elseif (Trim($heslo) == ""){
    echo "0||Musíte vyplnit heslo";
    }


else{
    echo "1||Formulář je správně vyplněn";
    }
?>
