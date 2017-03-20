<p><a href='index.php?akce=pridat-kategorii&nadrazena=-1'>Přidat kategorii</a></p>
<table>
<?php 
function vypis_kategorie($nadrazena, $odsazeni){
    $q = mysqli_query(DATABASE::getDb(), "select * from kategorie_otazky where nadrazena = '$nadrazena'");
    if (mysqli_num_rows($q) == 0){
        return;
        }
    while ($v = mysqli_fetch_array($q)){
        ?><tr><td>
        <?php
        $i = 0;
        while ($i != $odsazeni){
            ?>&nbsp;<?php
            $i++;
            }
        echo "- ".$v["jmeno"];
        ?>
        </td><td><a href='index.php?akce=pridat-kategorii&nadrazena=<?php echo $v["id"]; ?>'>Vložit podkategorii</a>
        / <a href="index.php?akce=smazat_kategorii&id=<?php echo $v["id"]; ?>">Smazat</a>
        </td></tr><?php
        vypis_kategorie($v["id"], $odsazeni+5);
        }
    }

vypis_kategorie(-1, 0);

?>
</table>


