<?php

$ref = $_SERVER["HTTP_REFERER"];

include("funkce/pripojeni.php");

include("funkce/funkce.php");

if (!je_prihlasen()){

    Header("Location: $ref");

    return;

    }

if (skupina == 3){

    Header("Location: $ref");

    return;

    }



if (IsSet($_GET["komentar"])){

    $komentar = $_GET["komentar"];

    mysqli_query(DATABASE::getDb(), "delete from komentare where id = '$komentar' limit 1");

    Header("Location: $ref");

  }



?>

