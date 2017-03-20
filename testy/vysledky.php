<fieldset><legend>[ Výsledky ]</legend>
<p>Celkový počet otázek: <strong><?php echo $_SESSION["pocet"]; ?></strong></p>
<p>Z toho špatně: <strong><?php echo $_SESSION["spatne"]; ?></strong></p>
<p>Úspěšnost: <strong>
<?php
$spravne = $_SESSION["pocet"]-$_SESSION["spatne"];
if ($_SESSION["pocet"] != 0){
    echo round($spravne/$_SESSION["pocet"]*100, 3);
    }
else{
    echo "0";
    }

?>%</strong></p>

</fieldset>

<fieldset><legend>[ Špatně zodpovězné otázky ]</legend>
<?php
foreach($_SESSION["otazky"] as $otazka){
    $q = mysqli_query(DATABASE::getDb(), "select * from otazky where id = '$otazka'");
    $v = mysqli_fetch_array($q);
    $this->zobrazit_reseni_otazky($v);
    }

?>

</fieldset>