<?php
include("./pripojeni.php");
include("./funkce.php");

class Uloz extends Funkce{

    function uloz_odpoved($otazka, $i){
        $odpoved = $_POST["odpoved-$i"];
        $spravne = 0;
        if (IsSet($_POST["check-$i"]) and $_POST["check-$i"] == "on"){
            $spravne = 1;
            }
        mysql_query("insert into odpovedi(spravne, odpoved, otazka) values('$spravne', '$odpoved', '$otazka')") or die(mysql_error());

        }

    function show(){
        if ($this->je_prihlasen() == -1){
            die("Musíte být přihlášen");
            return;
        }
        $otazka = $_POST["otazka"];
        $kategorie = $_POST["kat"];
        $reseni = ""; //uzicatele jsou lini a tohle tak budou vyplnovat :-)

        mysql_query("insert into otazky(otazka, kategorie, reseni, kontrola) values('$otazka', '$kategorie', '$reseni', '0')") or die(mysql_error());
        $id = mysql_insert_id() or die(mysql_error());





        $this->uloz_odpoved($id, "1");
        $this->uloz_odpoved($id, "2");
        $this->uloz_odpoved($id, "3");
        $this->uloz_odpoved($id, "4");

        Header("Location: index.php?kategorie=$kategorie");
    }
}

$uloz = new Uloz();
$uloz->show();

?>
