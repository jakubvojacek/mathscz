<?php

Header('Content-type: text/html; charset=utf-8');

include("../funkce/pripojeni.php");

include("kontrola.php");

@session_start();

function zjednodus_adresu($r){

    $r = split('/', $r);

    $r = $r[count($r) - 1];

    return $r;

    }

function pocet_radku($r){

    $v = mysqli_query(DATABASE::getDb(), $r) or die(mysql_error());

    $v = mysqli_fetch_array($v);

    return $v["pocet"];

    }

function smaz(){

    if ($_GET["priklad"]){

        $id = $_GET["priklad"];

        mysqli_query(DATABASE::getDb(), "delete from priklady where id = '$id'");

        Header("Location: index.php?akce=priklady");

        }

    elseif (IsSet($_GET["kategorie"])){

        

        $kategorie = $_GET["kategorie"];



        //

        if (pocet_radku("select count(*) as pocet from kategorie where nadrazena = '$kategorie'") > 0){

            $_SESSION["zprava"] = array(0, "Kategorie nebyla smazána<br />Nejprve musíte smazat podkategorie dané kategorie. ");

            Header("Location: index.php?akce=kategorie");

            return;

            } 

        if (pocet_radku("select count(*) as pocet from clanky where kategorie = '$kategorie'") > 0){

            $_SESSION["zprava"] = array(0, "Kategorie nebyla smazána<br />Nejprve musíte smazat články, které jsou zařazeny do dané kategorie. ");

            Header("Location: index.php?akce=kategorie");

            return;

            }

                

        //

        mysqli_query(DATABASE::getDb(), "delete from kategorie where id = '$kategorie'");

        Header("Location: index.php?akce=kategorie");

        } 

    }

if (!IsSet($_GET["confirmation"])){

    $adresa_ano = $_SERVER['REQUEST_URI']."&confirmation=ano";

    $adresa_ano = zjednodus_adresu($adresa_ano);

    $adresa_ne = zjednodus_adresu($_SERVER["HTTP_REFERER"]);

    echo "<p>Opravdu chcete smazat daný záznam?</p>";

    echo "<a href='$adresa_ano' style = 'float:left;margin-left: 400px;'>Ano</a> <a href='$adresa_ne' style = 'float: right;margin-right: 400px;'>Ne</a>";

    }

else{

    smaz();

    }

?>

