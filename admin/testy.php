<?php
include("kontrola.php");
function vypis_testy($query, $text, $popis){
    $vypis = mysqli_query(DATABASE::getDb(), $query);
    if (mysqli_num_rows($vypis) == 0){
        return;
        }
    ?><fieldset><legend>[ <?php echo $text;?> ]</legend><table><?php
    while ($vysledek = mysqli_fetch_array($vypis)){
        ?><tr><td width='50'><a href='index.php?akce=testy&test=<?php echo $vysledek["id"]; ?>'><img src='images/edit-find-replace.png' alt='' class ='edit' /></a><?php
        if ($vysledek["vydano"] == 1){
            ?><a href='vydat_test.php?id=<?php echo $vysledek["id"]; ?>&amp;vydat=0'><img class = 'edit' src='images/stahnout.png' alt='' /></a><?php
            }
        else{
            ?><a href='vydat_test.php?id=<?php echo $vysledek["id"]; ?>&amp;vydat=1'><img class = 'edit' src='images/vydat.png' alt='' /></a><?php
            }
        ?></td><td><?php
        echo $vysledek["jmeno"]
        ?></td></tr><?php
        }
    ?></table></fieldset><?php
    }
if (IsSet($_GET["test"])){
    $test = $_GET["test"];
    $vypis = mysqli_query(DATABASE::getDb(), "select * from otazky_old where test = '$test' order by id desc");
    ?><a href='index.php?akce=pridat-otazku&test=<?php echo $test; ?>'><img src='images/document-new.png' alt='' />Přidat otázku</a><?php
    ?><table><?php
    while ($vysledek = mysqli_fetch_array($vypis)){
        ?><tr><td><a href='index.php?akce=pridat-otazku&id=<?php echo $vysledek["id"]; ?>'><img src='images/edit-find-replace.png' alt='' class ='edit' /></a><?php
        ?><a href='smaz.php?akce=otazka&id=<?php echo $vysledek["id"]; ?>'><img src='images/edit-delete.png' alt='' class ='edit' /></a></td><td><?php
        echo  htmlspecialchars($vysledek["otazka"]);
        ?></td></tr><?php
        }
    ?></table><?php
    }
else{
    ?><p><a href='index.php?akce=pridat-test'><img src='images/document-new.png' alt='' />Přidat test</a></p><?php
    vypis_testy("select * from testy where vydano = '0' order by id desc", "Nevydané testy", "vydat");
    vypis_testy("select * from testy where vydano = '1' order by id desc", "Vydané testy", "stáhnout");
    }
?>
               