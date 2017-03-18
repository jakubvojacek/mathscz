<?php
include("./kontrola.php");
function vypis_kat_admin($nadrazena, $odsazeni){
    $vypis = mysql_query("select * from kategorie where nadrazena = '$nadrazena' order by id");
    while ($vysledek = mysql_fetch_array($vypis)){
        $vsuvka = "";
        for ($i=0; $i != $odsazeni*2; $i++){
            $vsuvka = $vsuvka."&nbsp;";
            }
        $vsuvka = $vsuvka."&not;&nbsp;";
        ?>
        <tr><td><?php echo $vsuvka.$vysledek["jmeno"]; ?></td>
        <td><a href='smaz.php?kategorie=<?php echo $vysledek["id"]; ?>'>Smazat</a></td>
        <td><a href='index.php?akce=edit_kategorie&nadrazena=<?php echo $vysledek["id"]; ?>'>Vložit kategorii</td>
        </tr>
        <?php
        vypis_kat_admin($vysledek["id"], $odsazeni + 2);
        }
    if (mysql_num_rows($vypis) == 0){
        return 0;
        } 
    return 1;
    }
?>
<a href='index.php?akce=edit_kategorie'>Přidat kategorii</a>
<fieldset><legend>[ Kategorie ]</legend>
<table>
<?php    
if (vypis_kat_admin(-1, 0) == 0){
    ?> <p>Zatím nejsou vytvořeny žádné kategorie</p> <?php
    }
?>
</table>
</fieldset>


