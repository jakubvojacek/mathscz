
<?php
function vypis($a, $_a, $otazka,$r, $pocet){
    if ($a == 1){
        $otazka = str_replace("[$r]", "<input style='width: 37px;' class = 'input-spravne' type = 'text' value = '$_a' name = '$_a'/>", $otazka);
        $pocet = $pocet + 1;
        }
    elseif ($a == 0){
        $otazka = str_replace("[$r]", "<input style='width: 37px;' class = 'input-spatne' type = 'text' value = '$_a' name = '$_a'/>", $otazka);
        $pocet = $pocet + 1;
        }
    return array($pocet, $otazka);
    }
function pridej_vstup($text, $id){
    $text = str_replace("[A]","<input style='width: 37px;' type = 'text' name = '$id"."a' />",$text);
    $text = str_replace("[B]","<input style='width: 37px;' type = 'text' name = '$id"."b' />",$text);
    $text = str_replace("[C]","<input style='width: 37px;' type = 'text' name = '$id"."c' />",$text);
    $text = str_replace("[D]","<input style='width: 37px;' type = 'text' name = '$id"."d' />",$text);
    return $text;
    }
function PremenZpet($text){
    $text = Znacky($text);
    $trans_tbl = Get_HTML_Translation_Table(HTML_SPECIALCHARS);
    $trans_tbl = Array_Flip($trans_tbl);
    $text = StrTr($text, $trans_tbl);
    return $text;
    }
function zkontroluj($vypis, $typ, $id, $dobre, $spatne){
    $bool = 2;
    $r = "";
    if ($vypis[$typ] != ""){
        $r = $vypis[$typ];
        if ($_POST["$id"."$typ"] == $vypis[$typ]){
            $dobre = $dobre + 1;
            $bool = 1;
            }
        else{
            $spatne = $spatne +1;
            $bool = 0;
            
            }
        }
    
    return array($dobre, $spatne, $bool, $r);
    }


if (je_prihlasen == 0 and 0){
    ?>
    <blockquote>Tato sekce je pouze pro přihlášené uživatele. <a href='akce/prihlaseni'>Přihlásit se</a></blockquote>
    <p>Pokud se <a href='akce/registrace'>registrujete</a>, dostanete přístup do databáze různých matematických testů a cvičení, na kterých si budete moci vyzkoušet jaké máte znalosti. </p> 
    <div style='text-align: center; width: 100%;'>
    <a href='images/test_velky.png'><img style='float: left;'  src='images/test_maly.png' alt = '' /></a>
    <strong>Vyzkoušejte, co ve vás je!</strong>
    <a href='images/test-velky2.png'><img style='float: right;' src='images/test-maly2.png' alt = '' /></a>  
    </div>  
    <?php    
    return;
    }



if (IsSet($_GET["test"])){     
    $test = $_GET["test"];
    $vypis=mysql_query("select * from testy where link = '$test'");
    if (mysql_num_rows($vypis) == 0){
        include("404.php");
        return;
        }
    $v = mysql_fetch_array($vypis);
    $id_testu=$v["id"];    
    $reklama = "";   
    $zobrazit_reklamu = 1;     
    $_v=mysql_query("select * from testy where id ='$id_testu'") or die(mysql_error());
    $_v=mysql_fetch_array($_v);
    $pocet_pusteni=$_v["pocet"];
    ?>
    <div style='margin: 20xp;'>
    <?php echo $reklama;?>        
    </div>     
    <p class = 'bez'><em>Tento test byl již <?php echo $v["pocet"]; ?>x spuštěný.
    </em></p>  
    <?php 
    $vypis=mysql_query("select * from otazky_old where test='$id_testu' order by RAND()");
    if (0 != mysql_num_rows($vypis)){
        ?><form method=post action='oprav/<?php echo $v["link"]; ?>'><?php
        $i=1;
        while ($vysledek = mysql_fetch_array($vypis)){
            $typ = $vysledek["typ"];
            $otazka=PremenZpet($vysledek["otazka"]);
            $a=PremenZpet($vysledek["a"]);
            $b=PremenZpet($vysledek["b"]);
            $c=PremenZpet($vysledek["c"]);
            $d=PremenZpet($vysledek["d"]);
            $jmeno_otazky=$vysledek["id"];
            ?><input type = 'hidden' name = 'typ-<?php echo $jmeno_otazky; ?>' value = '<?php echo $typ; ?>' /><br /><?php
            if ($typ == 0){
                ?><table width = '100%' border = '0'>
                <tr><td style = 'vertical-align:top;width:40px;'><strong><?php echo $i; ?>)</strong></td><td><?php echo $otazka; ?></td></tr><tr><td></td><td>
                <br /><table>
                <tr><td style='vertical-align: middle;'><input type='radio' name='<?php echo $jmeno_otazky; ?>' value='a'/></td><td><?php echo $a; ?></td></tr>
                <tr><td style='vertical-align: middle;'><input type='radio' name='<?php echo $jmeno_otazky; ?>' value='b'/></td><td><?php echo $b; ?></td></tr>
                <tr><td style='vertical-align: middle;'><input type='radio' name='<?php echo $jmeno_otazky; ?>' value='c'/></td><td><?php echo $c; ?></td></tr>
                <tr><td style='vertical-align: middle;'><input type='radio' name='<?php echo $jmeno_otazky; ?>' value='d'/></td><td><?php echo $d; ?></td></tr>
                </table>
                </td></tr></table>
                <?php
                $i=$i+1;
                }
            elseif ($typ == 1){
                $otazka = pridej_vstup($otazka, $jmeno_otazky);
                ?><table width = '100%' border = '0'>
                <tr><td style = 'vertical-align:top;'><strong><?php echo $i; ?>)</strong></td><td><?php echo $otazka; ?></td></tr>
                </table>
                <?php
                $i=$i+1;
                }
            }
        ?><br /><br /><input type='submit' value='Opravit'  />
        </form><?php
        }

    }
  
  

  
  
elseif (IsSet($_GET["oprav"])){
    $test=$_GET["oprav"];
    ?><p class = 'bez'>Následuje podrobný rozbor vašeho testu; Správně odpovědi jsou označeny zelenou barvou a špatné červenou.</p><hr /><?php
    $vypis=mysql_query("select * from testy where link = '$test'");
    if (mysql_num_rows($vypis) == 0){
        include("404.php");
        return;
        }
    $v = mysql_fetch_array($vypis);
    $test=$v["id"];
    $dobre=0;
    $spatne=0;
    $typy = array();
    while (list($key, $value) = each($_POST)){
        if (substr($key, 0,3) == "typ"){
            $key = substr($key, 4,10);
            $typy[$key] = $value;
            }
        }
    $pocet = 1;
    $celkovy_pocet = 0;
    ?><ol><?php
    foreach ($typy as $cislo => $typ){
        if ($typ == 0){
            $vypis=mysql_query("select * from otazky_old where id='$cislo'");
            $vysledek=mysql_fetch_array($vypis);
            $otazka = Znacky($vysledek["otazka"]);
            $odpoved=$vysledek["spravne"];
            $stav = "Správná odpověd je: ";
            if (IsSet($_POST[$cislo])){ 
                if ($odpoved == $_POST[$cislo]){
                    $dobre=$dobre+1;
                    $barva = 'green';
                    $stav = "Odpověděl jste správně; ";
                    } 
                else{
                    $spatne=$spatne+1;
                    $barva = 'red';
                    }
                }
            else{
                $spatne=$spatne+1;
                $barva = 'red';
                }
            ?><li style='margin-top: 35px;'><?php echo $otazka; ?><br />
            <span style = 'color: <?php echo $barva; ?>;font-weight:bold;'><?php echo $stav; ?></span>
            <?php echo Znacky($vysledek[$vysledek["spravne"]]); ?>
            </li><?php
            $celkovy_pocet = $celkovy_pocet + 1;
            }
        elseif ($typ == 1){
            $vypis = mysql_fetch_array(mysql_query("select * from otazky_old where id = '$cislo'"));
            $otazka = $vypis["otazka"];
            list($dobre, $spatne, $a, $_a) = zkontroluj($vypis, "a", $cislo, $dobre, $spatne);
            list($dobre, $spatne, $b, $_b) = zkontroluj($vypis, "b", $cislo, $dobre, $spatne);
            list($dobre, $spatne, $c, $_c) = zkontroluj($vypis, "c", $cislo, $dobre, $spatne);
            list($dobre, $spatne, $d, $_d) = zkontroluj($vypis, "d", $cislo, $dobre, $spatne);
            list($celkovy_pocet, $otazka) = vypis($a, $_a, $otazka, "A", $celkovy_pocet);
            list($celkovy_pocet, $otazka) = vypis($b, $_b, $otazka, "B", $celkovy_pocet);
            list($celkovy_pocet, $otazka) = vypis($c, $_c, $otazka, "C", $celkovy_pocet);
            list($celkovy_pocet, $otazka) = vypis($d, $_d, $otazka, "D", $celkovy_pocet);
            $otazka = pridej_vstup($otazka, $cislo);
            $otazka = Znacky($otazka);
            ?><li style='margin-top: 35px;'>

            <?php echo $otazka; ?>
            </li><?php
            }     
        $pocet = $pocet + 1;
        }
    ?></ol><?php
    mysql_query("update testy set pocet=pocet+1 where id = '$test'");
    //
    $uspesnost=ceil(($dobre/$celkovy_pocet)*100);
    if ($uspesnost >= 90){
        $znamka="1";
        $barva="blue";
        }
    elseif ($uspesnost >= 80){
        $znamka="2";
        $barva="green";
        }  
    elseif ($uspesnost >= 65){
        $znamka="3";
        $barva="#ff6600";
        }
    elseif ($uspesnost >= 50){
        $znamka="4";
        $barva="#ca2720";
        }
    else{
        $znamka="5";
        $barva="#e63b3d";
        }   
    ?><br /><br /><p>Měl jste dobře <?php echo $dobre;?> z <?php echo $celkovy_pocet;?> otázek. To znamená úspěšnost <?php echo $uspesnost;?>%</p>
    <?php
    /*mysql_query("insert into vysledky(test, uzivatel, znamka) values('$test', ".id_uzivatele.", '$uspesnost')");
    //$vypis = mysql_query("select * from vysledky where test = '$test'") or die(mysql_error());
    $celkovy_pocet = mysql_num_rows($vypis);
    $prumer = 0;
    while ($vysledek = mysql_fetch_array($vypis)){
        $prumer = $prumer + $vysledek["znamka"];
        }
    $prumer_uspesnost = round($prumer/$celkovy_pocet);
    ?><p>Tento test byl již spuštěn <?php echo $celkovy_pocet; ?> a průměrná úspěšnost je <?php echo $prumer_uspesnost; ?>%</p>
    */
    ?>
    <p>¬ <a href = 'testy/<?php echo $v["link"]; ?>'>Spustit test znovu</a></p>
    <p>¬ <a href = 'akce/zkouseni'>Seznam testů</a></p>
    <?php
    
    
    }

else{
    ?>

    <p>Vyberte si některý z následujících testů a vyzkoušejte, jak jste na tom se znalostmi! </p>
    <p>Statistiku úspěšnosti Vašich testů můžete shlédnout ve <a href='http://forum.maths.cz/profile.php?id=<?php echo id_uzivatele; ?>'>Vašem profilu</a>. </p>
    <ul class='vypis_testu'>
    <?php
    $vypis=mysql_query("select * from testy where vydano = '1' order by id desc");    
    while ($vysledek = mysql_fetch_array($vypis)){
        $id_testu=$vysledek["id"];
        $jmeno_testu=$vysledek["jmeno"];
        $url=$vysledek["link"];
        ?><li>&raquo; <a href ='testy/<?php echo $url; ?>'><?php echo $jmeno_testu; ?></a></li><?php
        }
    ?>
    </ul>
    <?php
    }
?>

