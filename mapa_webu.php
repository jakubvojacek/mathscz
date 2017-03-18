<?php
$pismena = array('A','Á','B','C','Č','D','Ď','E','É','Ě','F','G','H','I','J','K','L','M','N','O','Ó','P','Q','R','Ř','S','Š','T','U','Ů','Ú','V','W','X','Y','Z','Ž');


function get_cat($kat){
    $vypis = mysql_query("select * from kategorie where link = '$kat'");
    $vypis = mysql_fetch_array($vypis);
    $kat = $vypis["id"];
    return array($kat, $vypis["nadrazena"]);
    }
if (IsSet($_GET["kategorie"])){
    $kategorie = $_GET["kategorie"];
    list($kategorie, $nadrazena) = get_cat($kategorie);
    }
else{
    $kategorie = -1;
    $nadrazena = -1;
    }
if ($nadrazena != -1){
    $vypis = mysql_fetch_array(mysql_query("select * from kategorie where id = '$nadrazena'"));  
    ?><p class = 'maly bez'>Nadřazená kategorie: <a href='mapa-webu/<?php echo $vypis["link"]; ?>'><?php echo $vypis["jmeno"]; ?></a></p><?php
    }
else{
    ?><p class = 'maly bez'>Nadřazená kategorie: Tato kategorie nemá žádnou nadřazenou kategorii.</p><?php
    }
$kopie_kategorie = $kategorie;
$vypis = mysql_query("select * from kategorie where nadrazena = '$kategorie'");
$pocet_pod = mysql_num_rows($vypis);
$k = ceil($pocet_pod / 3);

?><h3 style = 'border-bottom:1px solid#000;'>Podkategorie</h3><?php
if ($pocet_pod != 0){
    ?><p class = 'maly bez'>Celkem <?php echo $pocet_pod; ?> podkategorií.</p><?php
    $kategorie = array();
    while ($vysledek = mysql_fetch_array($vypis)){
        $kategorie[] = $vysledek["jmeno"];
        }
    ?><table border = '0' width = '100%'><tr><td style = 'vertical-align:top;'><?php
    $pocet = 0;
    foreach ($pismena as $cislo => $pismeno){
        $napsat = array();
        foreach ($kategorie as $cislo2 => $kat){
            $prvni_pismeno = substr($kat,0,1);
            if ($prvni_pismeno == $pismeno){
                $napsat[] = $kat;
                }
            }
        if (count($napsat) != 0){
            echo "<h3>$pismeno</h3>";
            foreach ($napsat as $c => $kat){
                ?><a href='mapa-webu/<?php echo seo_url($kat);?>.html'><?php echo $kat; ?></a><br /><?php
                }   
            $pocet = $pocet + 1;
            if ($pocet == $k){
                ?></td><td style = 'vertical-align:top;'><?php
                $pocet = 0;
                }
            }         
            }
        
        
    ?></td></tr></table><?php
    
    }
else{
    ?><p class = 'maly bez'>Tato kategorie nemá žádné podkategorie</p><?php
    }
function vrat_podrazene($id, $pole_kategorii){    
    $vypis = mysql_query("select * from kategorie where nadrazena = '$id'");
    while($vysledek = mysql_fetch_array($vypis)){
        $pole_kategorii = $pole_kategorii." or kategorie = '".$vysledek["id"]."'";
        $pole_kategorii = vrat_podrazene($vysledek["id"], $pole_kategorii);
        }
    return $pole_kategorii;
    }
$pole_kategorii = vrat_podrazene($kopie_kategorie, "");

$vypis = mysql_query("select * from clanky where dokoncen = 'ano' and (kategorie = '$kopie_kategorie' $pole_kategorii)") or die(mysql_error());
$pocet_pod = mysql_num_rows($vypis);
$zobrazit_reklamu = 1;
if ($kategorie == "10"){
    $zobrazit_reklamu = 0;
    ?><div style="margin: 20px;"><a href="http://www.lekcepokeru.com/online-poker-uvod">Hrát poker</a> může každý. Doporučujeme začít s <a href="http://www.lekcepokeru.com/poker-hry/no-limit-texas-holdem-online-poker-pravidla">texas hold em zdarma</a>. <a href="http://www.lekcepokeru.com/jak-hrat-online-poker-na-internetu">Hra online poker</a> je skvělá a netu jsou i <a href="http://www.lekcepokeru.com/poker-recenze/expekt-poker">poker freerolly</a>.</div><?php
    }





?><h3 style = 'border-bottom:1px solid#000;'>Články</h3><?php
if ($pocet_pod != 0){
    
    ?><p class = 'maly bez'>Celkem <?php echo $pocet_pod; ?> článků.</p><?php
    $kategorie = array();
    while ($vysledek = mysql_fetch_array($vypis)){
        $kategorie[] = array($vysledek["jmeno"], $vysledek["uvod"]);
        }
    foreach ($pismena as $cislo => $pismeno){
        $napsat = array();
        foreach ($kategorie as $cislo2 => $kat){
            $prvni_pismeno = substr($kat[0],0,1);
            if ($prvni_pismeno == $pismeno){
                $napsat[] = $kat;
                }
            }
        if (count($napsat) != 0){
            ?><h3><?php echo $pismeno; ?></h3><?php
            ?><ul><?php
            foreach ($napsat as $c => $kat){
                $title = wordwrap($kat[1], 55, '<br />');
                
                ?><li><a href='clanky/<?php echo seo_url($kat[0]); ?>.html' title='<?php echo $title; ?>' class='tooltip'><?php echo $kat[0]; ?></a></li><?php
                }   
            }    
            
            ?></ul><?php    
        }
    }
else{;
    ?><p class = 'maly bez'>V této kategorii se nenachází žádné články.</p><?php
    }
?><br /><br /><?php

?>
