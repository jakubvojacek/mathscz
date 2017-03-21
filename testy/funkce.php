<?php
include("facebook.php");
include_once 'geshi.php';

function vrat_math($re){

    $adresa = $re[1];
    $adresa2 = $adresa;
    $my_adresa = HTMLSpecialChars($adresa, ENT_QUOTES);
    $vypis = mysqli_query(DATABASE::getDb(), "select * from tex where jmeno = '$my_adresa'");
    if (mysqli_num_rows($vypis) == 0){


        $arr = split(" ", $adresa2);
        $ln = sizeof($arr);


        $text = "";
        for($i=0; $i<$ln; $i+=1){
            $text = $text."%20".urlencode($arr[$i]);
            }
        $adresa2=$text;
        $blob=file_get_contents("http://www.matweb.cz/cgi-bin/mimetex.cgi?$adresa2");
        //$blob=file_get_contents("http://www.quantnet.com/cgi-bin/mathtex.cgi?$adresa2");
        $blob = base64_encode($blob);
        mysqli_query(DATABASE::getDb(), "insert into tex(jmeno, obr) values('$my_adresa', '$blob')") or die(mysql_error());
        }
    $vypis = mysqli_query(DATABASE::getDb(), "select id from tex where jmeno = '$my_adresa'");
    $vypis = mysqli_fetch_array($vypis);
    $id = $vypis["id"];
    return "<img style ='vertical-align: center; margin:2px;margin-bottom:0px;' src='get_math.php?id=$id' alt='$adresa' />";
    }

function vrat_code($param){
    $lang = $param[2];
    $code = $param[3];
    //return "ddd";
    //return $param[0];
    //print_r($param);
    //die("kod: ".$code);
    $geshi = new GeSHi($code, $lang);
    $geshi->enable_line_numbers(GESHI_NORMAL_LINE_NUMBERS);
    $geshi->set_header_type(GESHI_HEADER_PRE_TABLE);
    return $geshi->parse_code();
   
}
function geshi_replace($uu) {
    return geshi($uu[2], $uu[1]);
}


abstract class Funkce{
    function znacky($text){
        $text=preg_replace_callback("|<math>([^<]+)</math>|", "vrat_math", $text);

        
        $text=preg_replace_callback('#\<code(.*?=([^\>]+))?\>(.+?)\<\/code\>#s', "vrat_code", $text);
        //preg_replace_callback('#\[syntax=(.*?)\](.*?)\[/syntax\]#si' , 'geshi_replace', $text);
        /*$text =  preg_replace_callback('/<pre.*?><code.*?>(.*?[<pre.*?><code.*?>.*<\/code><\/pre>]*)<\/code><\/pre>/ism', "geshi", $text);
         * $text = preg_replace_callback('|<code(?=[^\r\n]*?>.*?</code>)|', "vrat_code", $text);
         */
        return $text;
        }
    function ohodnot($cislo){
        $abeceda = array("1" => "A", "2"=>"B", "3"=>"C", "4"=>"D");
        $id = $_POST["odpoved-$cislo"];
        $odpoved = 0;
        $barva_tlacitko = "";
        $barva_odpoved = "";
        if (IsSet($_POST["check-$cislo"]) and $_POST["check-$cislo"] == "on"){
            $barva_tlacitko = "background-color: #88F12E;";
            $odpoved = 1;
            }

        $q = mysqli_query(DATABASE::getDb(), "select spravne, odpoved from odpovedi where id = '$id'") or die(mysql_error());
        $v = mysqli_fetch_array($q);
        if (Trim($v["odpoved"]) == ""){
            return 1;

            }
        $vratit = 1;
        if ($odpoved == 1 && $v["spravne"] == 1){
            $barva_odpoved = "background-color: #88F12E;";
            $vratit = 1;
        }
        elseif ($odpoved == 0 && $v["spravne"] == 1){
            $barva_odpoved = "background-color: #88F12E;";
            $vratit = 0;
        }

        elseif ($odpoved != $v["spravne"]){
            $barva_odpoved = "background-color: #FFA5A4;";
            $vratit = 0;
        }


        ?>
        <tr><td style="font-size: 1.5em; padding: 15px; vertical-align: middle; width: 10px; <?php echo $barva_tlacitko; ?>">
        <?php echo $abeceda[$cislo]; ?>
        </td><td style ="<?php echo $barva_odpoved; ?>">
        <?php
        echo $this->znacky($v["odpoved"]);
        ?>
        </td></tr><?php
        return $vratit;


        }
    function oprav(){
        $this->reklama();
        ?><p style="margin-top: 35px; font-size: 2em; font-weight: bold; width: 100%; border-bottom: 1px solid#000; ">Oprava</p><?php
        $otazka = $_POST["otazka"];
        $q = mysqli_query(DATABASE::getDb(), "select otazka, reseni from otazky where id = '$otazka'");
        $v = mysqli_fetch_array($q);
        ?><p><span class="otazka"><?php echo $this->znacky($v["otazka"]); ?></span></p>
        <table style="margin-bottom: 10px; ">
        <?php
        $odpoved1 = $this->ohodnot(1);
        $odpoved2 = $this->ohodnot(2);
        $odpoved3 = $this->ohodnot(3);
        $odpoved4 = $this->ohodnot(4);
        ?>
        </table>

        <div style="text-align: center; margin-top: 20px; ">
            <input class ="formbutton" value ="Nahlásit chybné řešení" type ="button" onclick ='spatne_reseni(<?php echo $otazka; ?>)' />
            <?php if ($v["reseni"] != ""){
                ?><input class ="formbutton" value ="Ukázat postup" id ="tlacitko" type ="button" onclick ='$("#reseni").show("slow"); $("#tlacitko").hide("slow");' /><?php
                }
            ?>

        </div>
        <fieldset style="display: none; margin: 20px; padding: 10px; border: 1px solid#000; " id = 'reseni'><legend>[ Řešení ]</legend><?php echo $this->znacky($v["reseni"]); ?></fieldset>


        <br /><br />
        <?php
        $bylo_spravne = 1;
        $bylo_spatne = 0;
        if (!$odpoved1 || !$odpoved2 || !$odpoved3 || !$odpoved4){
            $bylo_spravne = 0;
            $bylo_spatne = 1;
            $spatne = $_SESSION["otazky"];
            $spatne[] = $otazka;
            $_SESSION["otazky"] = $spatne;
            $_SESSION["spatne"] = $_SESSION["spatne"] + 1;
            mysqli_query(DATABASE::getDb(), "update otazky set spatne = spatne + 1 where id = '$otazka'") or die(mysql_error());
            }
        $_SESSION["pocet"] = $_SESSION["pocet"] + 1;
        mysqli_query(DATABASE::getDb(), "update otazky set celkem = celkem + 1 where id = '$otazka'") or die(mysql_error());
        $id_uzivatele  = $this->je_prihlasen();
        if ($id_uzivatele == -1){//kvuli unsigned intu u uzivatele v tabuůce
            $id_uzivatele = 0;
            }
        $this->update_vysledky($id_uzivatele, $otazka, $bylo_spravne, $bylo_spatne);

        }

    function update_vysledky($uzivatel, $otazka, $spravne, $spatne){
        /*
         * chyba = 1 -> spatna odpoved
         */
        mysqli_query(DATABASE::getDb(), "insert into vysledky(spravne, spatne, uzivatel, otazka, cas) values('$spravne', '$spatne', '$uzivatel', '$otazka', current_timestamp())");
        }

    function je_prihlasen(){
        $facebook = new Facebook(array(
  'appId'  => '135212003208377',
  'secret' => 'f66a770d0c1a83a2d13bc6582f135733',
  'cookie' => true,
));

        $session = $facebook->getSession();

        $me = null;
        // Session based API call.
        if ($session) {
          try {
            $uid = $facebook->getUser();
            $me = $facebook->api('/me');
          } catch (FacebookApiException $e) {
            error_log($e);
          }
        }

        // login or logout url will be needed depending on current user state.
        if ($me) {

          return $uid;
        }
        return -1;



        }
    function nick_uzivatele($id){
        $q = mysqli_query(DATABASE::getDb(), "select * from uzivatele where id = '$id'");
        if (mysqli_num_rows($q) == 0){
            return "Neznámý uživatel";
            }
        $v = mysqli_fetch_array($q);
        return $v["nick"];
        }

    function _make_cat_select($kat, $r){
        $q = mysqli_query(DATABASE::getDb(), "select * from kategorie_otazky where nadrazena='$kat'");
        while ($v = mysqli_fetch_array($q)){
            $r = $r." or kategorie='".$v["id"]."'";
            $r = $this->_make_cat_select($v["id"], $r);
            }
        return $r;
        }

    function zobrazit_odpoved($v){
        if (Trim($v["odpoved"]) == ""){return; }
        $znacka = "";

        if ($v["spravne"] == 1){

            $znacka = " checked = 'checked'";
            }
        ?><tr><td style="vertical-align: middle; width: 10px; "><?php
        if ($v["spravne"] == $odpoved){

            echo "<input type='checkbox' $znacka /></td><td> ".$this->znacky($v["odpoved"])."</td></tr> ";
            return 1;
            }
        else{
            echo "<input type='checkbox' $znacka /></td><td> ".$this->znacky($v["odpoved"])."</td></tr> ";
            return 0;
            }
        }

    function zobrazit_reseni_otazky($v){
        ?>
        <li><span class="otazka"><?php echo $this->znacky($v["otazka"]); ?></span>



            <table>
            <?php
            $q = mysqli_query(DATABASE::getDb(), "select spravne, odpoved from odpovedi where otazka = '".$v["id"]."'") or die(mysql_error());
            while ($v = mysqli_fetch_array($q)){
                $this->zobrazit_odpoved($v);

                }
            ?></table><?php
        ?></li><?php
        }

    function make_cat_select($kat){

        $r = "kategorie = '$kat' ";
        $r = $this->_make_cat_select($kat, $r);
        return $r;
        }

    
    function reklama(){
        if (ZOBRAZIT_REKLAMU == 1){
            echo REKLAMA;
            }
        }
    function strom_kategorii($id){
        if (!is_numeric($id))
            {
            return;
            }
        $q = mysqli_query(DATABASE::getDb(), "select * from kategorie_otazky where id = '$id'") or die(mysql_error());
        $v = mysqli_fetch_array($q);
        if ($v["nadrazena"] != -1){

            $this->strom_kategorii($v["nadrazena"]);
            echo " » ";
        }
        else{
            ?><a href="index.php">Hlavní strana</a> » <?php
        }
        ?><a href="index.php?kategorie=<?php echo $id; ?>"><?php echo $v["jmeno"]; ?></a><?php
    }
    function otazka_detail($v){
        $q = mysqli_query(DATABASE::getDb(), "select * from odpovedi where otazka='".$v["id"]."' order by RAND()") or die(mysql_error());
        if (mysqli_num_rows($q) == 0){
            return;
        }
        ?>
        <input type="hidden" name="otazka" value="<?php echo $v["id"];?>" />
        <table style="margin-bottom: 10px; ">
        <?php

        $i = 1;
        while ($v = mysqli_fetch_array($q)){
            if (Trim($v["odpoved"]) == ""){
                $i++;
                continue;

                }
            ?><tr><td style="vertical-align: middle; width: 10px; "><input id = "odpoved-<?php echo $i; ?>" type = 'hidden' name = 'odpoved-<?php echo $i; ?>' value = '<?php echo $v["id"]; ?>' /><input name='check-<?php echo $i; ?>' type = 'checkbox' /></td>
                <td><label for="odpoved-<?php echo $i; ?>">
            <?php echo $this->znacky($v["odpoved"]); ?></label></td></tr>
            <?php
            $i++;

            }
        ?>
        </table>
        <div style="text-align: center; ">
            <input class ="formbutton" type="submit" value ="Další otázka" />
            <a class ="formbutton" href="index.php?akce=vysledky">Ukončit test</a>
        </div>
        <iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fmaths.cz%2Ftesty%2Findex.php%3Fkategorie%3D<?php echo $_GET["kat"];?>&amp;layout=standard&amp;show_faces=true&amp;width=450&amp;action=like&amp;colorscheme=light&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:80px; margin-top: 30px;" allowTransparency="true"></iframe>

        <?php
        }
    }
?>
