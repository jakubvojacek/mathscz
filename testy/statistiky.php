<?php



class Statistiky extends Funkce{
    function show(){
        $q = mysql_query("select sum(spatne) as spatne, sum(spravne) as spravne from vysledky");
        $v = mysql_fetch_array($q);
        $this->ukaz_pomer_spravne_spatne($v); //a graf
     
        ?>
            <ul style="list-style: none; margin-left: 5px;">
               
                <li><strong>Zodpovězených otázek: </strong><?php echo $this->celkem_odpovedi(); ?></li>
                <li><strong>Správných odpovědí: </strong><?php echo $this->celkem_dobre(); ?></li>
                <li><strong>Špatných odpovědí: </strong><?php echo $this->celkem_spatne(); ?></li>
            </ul>

        <?php
        $this->zobraz_q("Nejúspěšnější řešitelé", "Procentuální úspěšnost", "SELECT distinct uzivatel, sum(spravne)/(sum(spravne)+sum(spatne))*100 as vystup FROM  `vysledky` WHERE uzivatel !=0 group by uzivatel ORDER BY vystup DESC LIMIT 3");      
        $this->zobraz_q("Uživatelé s nejvyšším počtem správných odpovědí", "Počet správných odpovědí", "SELECT DISTINCT uzivatel, SUM( spravne ) AS vystup FROM  `vysledky` WHERE uzivatel !=0 group by uzivatel ORDER BY vystup DESC LIMIT 3");
        $this->zobraz_q("Uživatelé s nejvyšším počtem špatných odpovědí", "Počet špatných odpovědí", "SELECT DISTINCT uzivatel, SUM( spatne ) AS vystup FROM  `vysledky` WHERE uzivatel !=0 group by uzivatel ORDER BY vystup DESC LIMIT 3");

        }
    function zobraz_q($title, $table, $query){
        ?><div style="width: 350px;"><fieldset>
                <legend>[ <?php echo $title; ?> ] </legend><?php
        $q = mysql_query($query);
        ?><table class="tablesorter" width="340">
        <thead>
        <tr><td>Uživatelské jméno</td><td><?php echo $table; ?></td></tr></thead>
        <tbody><?php
        while ($v = mysql_fetch_array($q)){
            ?><tr><td  style="vertical-align: middle; "><img src="http://graph.facebook.com/<?php echo $v["uzivatel"]; ?>/picture" alt="fotka" /> <fb:name uid="<?php echo $v["uzivatel"]; ?>"></fb:name></td><td style="vertical-align: middle; "><?php echo $v["vystup"]; ?></td></tr><?php
            
            }
        ?></tbody></table>
        </fieldset></div>
        <?php

        }
    function celkem_spatne(){
        $q = mysql_query("select sum(spatne) as spatne from otazky");
        $v = mysql_fetch_array($q);
        return $v["spatne"];
        }
    function celkem_dobre(){
        $q = mysql_query("select sum(celkem)-sum(spatne) as dobre from otazky");
        $v = mysql_fetch_array($q);
        return $v["dobre"];
        }
    function celkem_odpovedi(){
        $q = mysql_query("select sum(celkem) as celkem from otazky");
        $v = mysql_fetch_array($q);
        return $v["celkem"];
        }
  
    function ukaz_pomer_spravne_spatne($v){

        if ($v["spatne"] + $v["spravne"] == 0){
            return;
            }
        $chart = "http://chart.apis.google.com/chart?chco=46a3fc&cht=p3&chs=250x100&chd=t:".round($v["spatne"]/($v["spatne"] + $v["spravne"])*100).",".round($v["spravne"]/($v["spatne"] + $v["spravne"])*100)."&chl=Špatně|Správně";
        ?><div style=" display: inline; float: right; width: 500px; text-align: right; ">
            <fieldset><legend>[ Poměr špatných / správných odpovědí ]</legend><img src="<?php echo $chart; ?>" /></fieldset>
            <fieldset><legend>[ Denní statistiky odpovědí ]</legend> <?php include("graf.php"); ?></fieldset>
        </div>
       
        <?php

        }

    }

$stat = new Statistiky();
$stat->show();

?>
