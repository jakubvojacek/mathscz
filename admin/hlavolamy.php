<?php
include("kontrola.php");
function vypis_hlavolamy($query, $text, $popis){
    $vypis = mysql_query($query);
    if (mysql_num_rows($vypis) == 0){
        return;
        }
    echo "<fieldset><legend>[ $text ]</legend>";
    echo "editovat | smazat | $popis<br />";
    while ($vysledek = mysql_fetch_array($vypis)){
        echo "<a href='index.php?akce=edithlavolam&id=".$vysledek["id"]."'><img class = 'edit' src='images/edit-find-replace.png' alt='' /></a>";
        echo "<a href='smaz.php?akce=hlavolam&id=".$vysledek["id"]."'><img class = 'edit' src='images/edit-delete.png' alt='' /></a>";   
        if ($vysledek["zobrazit"] == 0){
            echo "<a href='vydat_hlavolam.php?id=".$vysledek["id"]."&vydat=1'><img class = 'edit' src='images/vydat.png' alt='' /></a>"; 
            }
        else{
            echo "<a href='vydat_hlavolam.php?id=".$vysledek["id"]."&vydat=0'><img class = 'edit' src='images/stahnout.png' alt='' /></a>"; 
            }
        echo $vysledek["jmeno"]."<br />";    
        }
    
    echo "</fieldset>";
    }
echo "<a href='index.php?akce=edithlavolam'>Přidat hlavolam</a>";
vypis_hlavolamy("select * from hlavolamy where zobrazit = '0' order by id desc", "Nevydané hlavolamy", "vydat");
vypis_hlavolamy("select * from hlavolamy where zobrazit = '1' order by id desc", "Vydané hlavolamy", "stáhnout");
?>
