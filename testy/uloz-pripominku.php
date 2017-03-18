<?php
include("./pripojeni.php");
$text = $_POST["text"];
$predmet = $_POST["predmet"];
$jmeno = $_POST["jmeno"];
require_once('recaptchalib.php');
$privatekey = "6LdTvrsSAAAAAIcNoQ4uo0pGE9GVbKNCxRdG1yqN";
$resp = recaptcha_check_answer ($privatekey,
                            $_SERVER["REMOTE_ADDR"],
                            $_POST["recaptcha_challenge_field"],
                            $_POST["recaptcha_response_field"]);
if (!$resp->is_valid) {
    $chyby[] = "Špatně jste opsali kód. ";
    Header("Location: index.php?akce=vzkazy-pripominky&chyba=1");
    }
else{

    mysql_query("insert into pripominky(jmeno, predmet, text, cas) values('$jmeno', '$predmet', '$text', current_timestamp())");
    Header("Location: index.php?akce=vzkazy-pripominky");
}
?>
