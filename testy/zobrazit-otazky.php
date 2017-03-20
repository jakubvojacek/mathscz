<?php
class ZobrazitOtazky extends Funkce{
    function show(){
        $kategorie = $_GET["kat"];
        $q = $this->make_cat_select($kategorie);
        $q = mysqli_query(DATABASE::getDb(), "select * from otazky where kontrola = '1' and $q") or die(mysql_error());
        ?><ol><?php
        while ($v = mysqli_fetch_array($q)){
            $this->zobrazit_reseni_otazky($v);
        

            }
        ?></ol><?php

        }
    }

$zobrazit = new ZobrazitOtazky();
$zobrazit->show();
?>
