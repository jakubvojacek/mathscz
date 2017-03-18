<?php
include("kontrola.php");
function ukaz_clanky($titulek, $vypis){
    ?><fieldset><legend>[ <?php echo $titulek; ?> ]</legend>
    <table cellpadding='0'>     
    <tr><td colspan='4' style='font-size: 11px;'>Náhled &nbsp; | &nbsp; Editace &nbsp; |  &nbsp; Smazat</td></tr>
    <?php
    while ($v = mysql_fetch_array($vypis)){
        ?>
        <tr><td width = '10px'><a href='../clanky/<?php echo $v["link"];?>'><img src='images/edit-find.png' alt='' /></a></td>
        <?php if (id_uzivatele == $v["autor"] or skupina == 1){
            ?>
            <td width = '5px'><a href='index.php?akce=edit_cl&amp;id=<?php echo $v["id"];?>'><img src='images/edit-find-replace.png' alt='' /></a></td>
            <td width = '5px'><a href='smaz.php?clanek=<?php echo $v["id"];?>'><img src='images/edit-delete.png' alt='' /></a></td>        
            <?php }
        else{?> 
            <td width = '5px'><img src='images/edit-find-replace2.png' alt='' /></td>       
            <td width = '5px'><img src='images/edit-delete2.png' alt='' /></td>        
            <?php }?>
        
        <?php 
        if ($v["upraven"] == 0){
            ?><td><a href='upraven.php?id=<?php echo $v["id"]; ?>'>Opraven</a></td><?php
            }        
        ?>
        
        <td><?php echo $v["jmeno"];?></td>
        </tr>      
        <?php
        }
    ?>
    </table>
    </fieldset>
    <?php
    }


if (!IsSet($_GET["zobraz"])){
    ?>

    <a href='index.php?akce=edit_cl'><img src='images/document-new.png' alt='' />Nový článek</a>
    <br />
    <a href='index.php?akce=clanky&zobraz=moje'><img src='images/document-open.png' alt='' />Vaše články</a>
    <br />
    <a href='index.php?akce=clanky&zobraz=vsechny'><img src='images/document-open.png' alt='' />Všechny články</a> 
    <?php
    }
else{
    $zobraz = $_GET["zobraz"];
    $pole = array("moje" => "Vaše články", "vsechny" => "Všechny články");
    $add = "";
    if ($zobraz == "moje"){
    	$add = "and autor = ".id_uzivatele;
        }
    ?><h1><?php echo $pole[$zobraz]; ?></h1><?php
    $vypis = mysql_query("select upraven, link, autor, jmeno, id from clanky where dokoncen = 'ne' $add order by id desc"); 
    ukaz_clanky("Nevydané články", $vypis);
    $vypis = mysql_query("select upraven, link, autor, jmeno, id from clanky where dokoncen = 'ano' $add order by id desc"); 
    ukaz_clanky("Vydané články", $vypis);
    }
?>
