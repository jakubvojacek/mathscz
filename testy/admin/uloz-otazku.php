<?php

function uloz_odpoved($otazka, $i, $nova){
    $id = $_POST["id-$i"];
    $odpoved = $_POST["odpoved-$i"];
    $spravne = 0;
    if (IsSet($_POST["check-$i"]) and $_POST["check-$i"] == "on"){
        $spravne = 1;
        }
    if ($nova == 1){
        
        mysql_query("insert into odpovedi(spravne, odpoved, otazka) values('$spravne', '$odpoved', '$otazka')") or die(mysql_error());
        return;
        }
    mysql_query("update odpovedi set spravne='$spravne', odpoved='$odpoved', otazka='$otazka' where id = '$id'") or die(mysql_error());
    }

include("../pripojeni.php");
$id = $_POST["id_otazky"];

$otazka = $_POST["otazka"];
$kategorie = $_POST["kat"];
$reseni = $_POST["reseni"];
$nova = 0;
if ($id == 0){
    mysql_query("insert into otazky(otazka, kategorie, reseni, kontrola) values('$otazka', '$kategorie', '$reseni', '1')") or die(mysql_error());
    $id = mysql_insert_id() or die(mysql_error());
    $nova = 1;
    }
else{
    mysql_query("update otazky set otazka = '$otazka', kategorie = '$kategorie', reseni = '$reseni' where id = '$id'") or die(mysql_error());
    }



uloz_odpoved($id, "0", $nova);
uloz_odpoved($id, "1", $nova);
uloz_odpoved($id, "2", $nova);
uloz_odpoved($id, "3", $nova);

Header("Location: index.php?akce=otazky");


?>
