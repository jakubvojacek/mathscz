<?php

include("../funkce/pripojeni.php");

include("kontrola.php");

$typ = $_GET["typ"];

$jmeno = $_GET["jmeno"];

$id = $_GET["id"];

$tabulka = "clanky";

if ($typ == "hlavolamy"){

    $tabulka = "hlavolamy";

    }

elseif ($typ == "testy"){

    $tabulka = "testy";

    }

elseif ($typ == "kategorie"){

    $tabulka = "kategorie";

    }

elseif ($typ == "autori"){

    $tabulka = "autori";

    }

if ($id == -1){

    $vypis = mysqli_query(DATABASE::getDb(), "select jmeno from $tabulka where jmeno = '$jmeno'");

    }

else{

    $vypis = mysqli_query(DATABASE::getDb(), "select jmeno from $tabulka where jmeno = '$jmeno' and id != '$id'");

    }

if ($jmeno == ""){

    echo "0||Musíte vybrat nějaké jméno";

    }

elseif (mysqli_num_rows($vypis) == 0){

    echo "1||Jméno je v pořádku.";

    }

else{

    echo "0||Toto jméno se již používá. Vyberte si prosím jiné.";

    }

?>

