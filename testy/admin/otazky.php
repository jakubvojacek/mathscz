<?php
include("../funkce.php");
class Otazky extends Funkce{
    function show(){
        ?>
        <a href='index.php?akce=editace-otazky'>Přidat otázku</a>

        <fieldset><legend>[ Filtrovat ]</legend>
        <form method = 'get' action = 'index.php'>
        <input type = 'hidden' name = 'akce' value = 'otazky' />
        <p>Kategorie: <?php kategorie_select(-1); ?></p>
        <p><input type = 'submit' value = 'Filtrovat' /></p>
        </form>
        </fieldset>


        <table>
        <?php
        if (IsSet($_GET["kat"])){
            $q = " where ".$this->make_cat_select($_GET["kat"]);
            }
        $q = mysql_query("select * from otazky $q order by id desc") or die(mysql_error());
        if (mysql_num_rows($q) == 0){
            return;
            }
        while ($v = mysql_fetch_array($q)){
            ?><tr><td><?php echo $v["otazka"]; ?></td><?php
            ?><td><a href='index.php?akce=editace-otazky&id=<?php echo $v["id"]; ?>'>Editovat</a> / 
                <a href="smazat.php?otazka=<?php echo $v["id"]; ?>">Smazat</a>
                /
                <a href='index.php?akce=nahled&id=<?php echo $v["id"]; ?>'>Náhled</a>
            </td></tr><?php


            }
        ?>
        </table>
        <?php
        }
    }


$otazky = new Otazky();
$otazky->show();
?>

