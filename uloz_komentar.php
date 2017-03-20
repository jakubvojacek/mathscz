<?php

include("funkce/pripojeni.php");

include("funkce/funkce.php");

define("je_prihlasen", je_prihlasen());

@session_start();

function PremenKomentar($text) {

    $text = Trim($text); 

    $text = HTMLSpecialChars($text, ENT_QUOTES);

    $text = Str_Replace("\r\n"," <br /> ", $text);

    $text = Str_Replace("\n"," <br /> ", $text);

    return Trim($text);

    }











$ref = $_SERVER["HTTP_REFERER"]; 

$id_clanku = $_POST["clanek"];

$autor = PremenKomentar($_POST["autor"]);

$id_autora = PremenKomentar($_POST["id_autora"]);

$text = PremenKomentar($_POST["text"]);

$predmet = PremenKomentar($_POST["predmet"]);

$datum=Date("d. n. Y H:i");

$ip=$_SERVER["REMOTE_ADDR"];



$chyby = array();

if ($autor == ""){

    $chyby[] = "Musíte vyplnit jméno";

    }

if ($predmet == ""){

    $chyby[] = "Musíte vyplnit předmět";

    }

if ($text == ""){

    $chyby[] = "Musíte vyplnit obsah komentáře";

    }



if (je_prihlasen == 0){

    require_once('recaptchalib.php');

    $privatekey = "6LdTvrsSAAAAAIcNoQ4uo0pGE9GVbKNCxRdG1yqN";

    $resp = recaptcha_check_answer ($privatekey,

                                $_SERVER["REMOTE_ADDR"],

                                $_POST["recaptcha_challenge_field"],

                                $_POST["recaptcha_response_field"]);

    if (!$resp->is_valid) {

        $chyby[] = "Kód byl špatně opsán, zkuste to prosím znovu. "; 

        }

    }

   

  

if (count($chyby) > 0){

    $_SESSION["komentare"] = array($chyby, $_POST["autor"], $_POST["predmet"], $_POST["text"]);

    Header("Location: $ref#komentare");

    return;

    }

  

   

mysqli_query(DATABASE::getDb(), "insert into komentare(autor, predmet, text, clanek, datum, id_autora, ip) values('$autor','$predmet','$text','$id_clanku','$datum', '$id_autora', '$ip')") or die(mysql_error());  

    

  



$k = mysql_insert_id();



Header("Location: $ref#komentar-$k");





?>

