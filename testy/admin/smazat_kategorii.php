<?php
function vypis_kat($kat, $id){
    $q = mysql_query("select * from kategorie_otazky where nadrazena='$id'");
    while ($v = mysql_fetch_array($q)){
        if ($v["id"] == $kat){continue; }
        ?><option value="<?php echo $v["id"]; ?>"><?php echo $v["jmeno"]; ?></option><?php
        vypis_kat($kat, $v["id"]);

        }

    }


if (!IsSet($_GET["kat_to"])){
    ?>
    <p>Chystáte se smazat kategorii. </p>
    <form action="index.php" method="get">
    <input type="hidden" name="akce" value="smazat_kategorii" />
    <input type="hidden" name =" id" value="<?php echo $_GET["id"]; ?>" />
    <p>Přesunout otázky do kategorie (nemažte kategorie, které mají ještě nějaké další podkategorie!! :):
    <select name="kat_to">
        <?php
        vypis_kat($_GET["id"], -1);
        ?>
    </select>
    </p>
    
    <input type="submit" value="Vymazat" />
    </form>
    <?php
    }
else{
    $kat = $_GET["id"];
    $to = $_GET["kat_to"];
    mysql_query("update otazky set kategorie = '$to' where kategorie='$kat'") or die(mysql_error());

    mysql_query("delete from kategorie_otazky where id = '$kat'") or die(mysql_error());
    
    }

?>
