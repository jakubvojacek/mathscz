<?php
function jmeno_existuje($jmeno){
    $seo = seo_url($jmeno).".html";
    $vypis = mysqli_query(DATABASE::getDb(), "select nick from uzivatele where link = '$seo'");
    if (mysqli_num_rows($vypis) == 0){
        return false;
        }
    return true;
    }
function email_existuje($email){
    $vypis = mysqli_query(DATABASE::getDb(), "select email from uzivatele where email = '$email'");
    if (mysqli_num_rows($vypis) == 0){
        return false;
        }
    return true;
    }   
function je_prihlasen(){  
    if (IsSet($_COOKIE["id"]) and IsSet($_COOKIE["heslo"])){ 
        $id = $_COOKIE["id"];
        $heslo = $_COOKIE["heslo"];
        $vypis = mysqli_query(DATABASE::getDb(), "select * from uzivatele where id = '$id' and heslo = '$heslo'");
        if (mysqli_num_rows($vypis) == 0){
            return 0;
            }
        $v = mysqli_fetch_array($vypis);
        define("id_uzivatele", $id);
        define("jmeno_uzivatele", $v["nick"]);
        define("skupina", $v["typ"]);
        return 1;
        }
    return 0;//uzivatel neni prihlasen
    }
function ukazka_prikladu($r){

    return htmlspecialchars(substr($r, 0, 80), ENT_QUOTES);
    }
function ukaz_zpravu(){
    
    if (!IsSet($_SESSION["zprava"])){
        return;
        }
    if ($_SESSION["zprava"] == 0){
        return;
        }       
    $img = "images/delete.png";
    if ($_SESSION["zprava"][0] == 1){
        $img = "images/info.png";
        }
        
        
    ?><table style='width: 90%; margin: 20px; border: 2px dashed gray;'><tr><td width = '5' style='vertical-align: top;'><img src='<?php echo $img;?>' alt = '' /></td><td style='vertical-align: top;'><?php echo $_SESSION["zprava"][1];?></td></tr></table><?php
    $_SESSION["zprava"] = 0;
    }

function hash_heslo($str, $salt){
	return sha1($salt.sha1($str));
    }
function random_key($len, $readable = false, $hash = false){
	$key = '';
	if ($hash)
		$key = substr(sha1(uniqid(rand(), true)), 0, $len);
	else if ($readable){
		$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

		for ($i = 0; $i < $len; ++$i)
			$key .= substr($chars, (mt_rand() % strlen($chars)), 1);
	   }
	else
		for ($i = 0; $i < $len; ++$i)
			$key .= chr(mt_rand(33, 126));
	return $key;
}
function PremenSmajliky($text){
  $zn = array(":sm1:","<img src='images/smilleys/1.gif' alt=':)'/>",":sm2:","<img src='images/smilleys/2.gif' alt=':('/>",
            ":sm3:","<img src='images/smilleys/3.gif' alt=':('/>",":sm4:","<img src='images/smilleys/4.gif' alt=':('/>"
            ,":sm5:","<img src='images/smilleys/7.gif' alt=':('/>",":sm6:","<img src='images/smilleys/8.gif' alt=':('/>",
            ":sm7:","<img src='images/smilleys/9.gif' alt=':('/>",":sm8:","<img src='images/smilleys/10.gif' alt=':('/>",
            );
  $ln = sizeof($zn)-1;
  for($i=0; $i<$ln; $i+=2){
     $text = str_replace($zn[$i], $zn[$i+1], $text);
   }
  return $text;
  }
function vrat_obrazek($re){
    $id= $re[1];
    $nahled = $re[2];
    $zarovnani = $re[3];
    $vypis=mysqli_query(DATABASE::getDb(), "select * from obrazky where id = '$id'") or die(mysql_error());
    if (mysqli_num_rows($vypis) != 0){
    
        $vypis=mysqli_fetch_array($vypis) or die(mysql_error());
        $src="obrazky/_".$vypis["cesta"];
        $src2="obrazky/".$vypis["cesta"];
        list($sirka, $vyska) =  getimagesize($src2);
        $alt=$vypis["jmeno"];
        if ($zarovnani == "nalevo"){
            $style = "float: left; margin: 5px;";
            }
        elseif ($zarovnani == "napravo"){
            $style = "float: right; margin: 5px;";
            }
        else{
            $style = "";
            }
        if ($nahled != "ano"){
            return "<div style='text-align: center;$style'><span class ='nahled_obrazku'><a rel=\"lightbox[skupina]\" href='$src2'><img class = 'nahled' src='$src2' alt='$alt'/></a></span></div>";
            }
        else{
            return "<div style='text-align:center;$style'><span  class = 'nahled_obrazku'><a rel=\"lightbox[skupina]\" href='$src2'><img class = 'nahled' border = '0' src='$src' alt='$alt'/></a></span></div>";    
            }
        }
    else{
        return "<img src='' width='100' height='100' alt='Obrázek nenalezen'/>";
        }
    }

function vrat_math($re){
    
    $adresa = $re[1];
    //x^2
    $adresa2 = "\gammacorrection{1}\dpi{150}\parstyle\begin{align*}".$adresa."\end{align*}";
    //$adresa2 = $adresa;
    $my_adresa = HTMLSpecialChars($adresa, ENT_QUOTES);
    $vypis = mysqli_query(DATABASE::getDb(), "select * from tex where jmeno = '$my_adresa'");
    if (mysqli_num_rows($vypis) == 0){
        
        
        $arr = explode(" ", $adresa2);
        $ln = sizeof($arr);
        
      
        $text = "";
        for($i=0; $i<$ln; $i+=1){
            $text = $text."%20".urlencode($arr[$i]);
            }
        $adresa2=$text;
        //$blob=file_get_contents("http://www.quantnet.com/cgi-bin/mathtex.cgi?$adresa2");
        $blob=file_get_contents("http://www.matweb.cz/cgi-bin/mathtex.cgi?$adresa2");
        $blob = base64_encode($blob);
        mysqli_query(DATABASE::getDb(), "insert into tex(jmeno, obr) values('$my_adresa', '$blob')") or die(mysql_error());        
        }
    $vypis = mysqli_query(DATABASE::getDb(), "select id from tex where jmeno = '$my_adresa'");
    $vypis = mysqli_fetch_array($vypis);
    $id = $vypis["id"];
    return "<img style ='vertical-align: center; margin:2px;margin-bottom:0px;' src='get_math.php?id=$id' alt='$adresa' />";
    }

function Znacky($text){
    $zn = array("[br]", "<br />", "[code]", "<pre class='kod'>", "[/code]", "</pre>", "[uhel]","<img src='images/uhel.png' alt='úhel'/>","#u#","&quot;","[b]", "<strong>", "[/b]", "</strong>","[i]","<em>","[/i]","</em>","[u]","<u>","[/u]","</u>","[citace]","<blockquote>","[/citace]","</blockquote>", "#radek#", "<br />");
    $ln = sizeof($zn)-1;
    for($i=0; $i<$ln; $i+=2){
        $text = str_replace($zn[$i], $zn[$i+1], $text);
        }        
    $text=preg_replace_callback("|<math>([^<]+)</math>|", "vrat_math", $text);  
    $text=preg_replace_callback("|<obrazek id = \"([^\"]+)\" nahled = \"([^\"]+)\" zarovnani = \"([^\"]+)\" />|", "vrat_obrazek", $text);
    $text=preg_replace_callback("|<cl>([^\<]+)</cl>|", "vrat_clanek", $text);
    $text=preg_replace_callback("|<priklad>([^\<]+)</priklad>|", "vrat_priklad", $text);
    $text=preg_replace_callback("|<skript>([^\<]+)</skript>|", "vrat_skript", $text);
    $text=preg_replace_callback("|<py url=\"([^\"]+)\" title=\"([^\"]+)\" />|", "vrat_py", $text);
    return $text; 
  }

function vrat_py($kod){
    $url=$kod[1];
    $popis=$kod[2];
    return "
<div style='width: 80%; padding: 5px; border: 1px solid#000; margin: auto; font-weight: bold;'>
<img style='float: left;margin-right: 5px;' alt='' src='images/nastroje.png' />
<p>Využijte naší nové služby <a href='nastroje/index.py'>Matematické nástroje</a>!</p>
<p>Můžete tam například najít nástroj, který vám pomůže s <a href='nastroje/index.py?akce=$url'>$popis</a>.</p>
</div>";
    } 

function vrat_clanek($kod){
    $kod=$kod[1];  
    $v=mysqli_query(DATABASE::getDb(), "select link, jmeno, uvod from clanky where id = '$kod'");
    $v=mysqli_fetch_array($v);   
    $title = wordwrap($v["uvod"], 55, "<br />");
    return "<a href='clanky/".$v["link"]."' title='$title' class='tooltip'>".$v["jmeno"]."</a>";
    }

function vrat_priklad($kod){
    $kod=$kod[1]; 
    $v=mysqli_query(DATABASE::getDb(), "select * from priklady where id = '$kod'");
    $v=mysqli_fetch_array($v);
    $r = Znacky($v["otazka"]);    
    $r =$r."<div style='text-align: center;margin-top:10px;'>";
    $r =$r."<input value = 'Zobrazit řešení' type='button' id = 'tlacitko-$kod' onclick= 'rozbal_reseni(\"$kod\")'  style='cursor:pointer;' /><br /><br />";
    $r =$r."</div>";
    $r =$r."<div id='res-$kod'>";
    $r =$r."<div style='background: #a8d1ea; margin: 5px; border:1px solid#3979bb;padding: 8px;'>".Znacky($v["reseni"])."</div>";     
    $r =$r."</div>";
    $r =$r.'<script>
el = document.getElementById("res-'.$kod.'");
el.style.display = "none";</script>';
    return $r;
    }
function vrat_skript($kod){
    $kod=$kod[1];    
    include("./skripty/$kod");
    }

function seo_url ($title){  
     $address = $title;  
     $address = iconv("UTF-8", "UTF-8", "$address"); 
     // nahradi znaky s diakritikou na znaky bez diakritiky  
     
     
     $address = str_replace("ě","e",$address);
     $address = str_replace("š","s",$address);
     $address = str_replace("č","c",$address);
     $address = str_replace("ř","r",$address);
     $address = str_replace("ž","z",$address);
     $address = str_replace("ý","y",$address);
     $address = str_replace("á","a",$address);
     $address = str_replace("í","i",$address);
     $address = str_replace("é","e",$address);
     $address = str_replace("ä","a",$address);
     $address = str_replace("ů","u",$address);
     $address = str_replace("ú","u",$address);
     $address = str_replace("ó","o",$address);
     $address = str_replace("ť","t",$address);
     $address = str_replace("ň","n",$address);
     //
     $address = str_replace("Ě","E",$address);
     $address = str_replace("Š","S",$address);
     $address = str_replace("Č","C",$address);
     $address = str_replace("Ř","R",$address);
     $address = str_replace("Ž","Z",$address);
     $address = str_replace("Ý","Y",$address);
     $address = str_replace("Á","A",$address);
     $address = str_replace("Í","I",$address);
     $address = str_replace("É","E",$address);
     $address = str_replace("Ä","A",$address);
     $address = str_replace("Ů","U",$address);
     $address = str_replace("Ú","U",$address);
     $address = str_replace("Ó","O",$address);
     $address = str_replace("Ť","T",$address);
     $address = str_replace("Ň","N",$address);
    
     
  
     $address = strtolower ($address);   
   
     // prevede vsechna velka pismena na mala  
     
   
     // nahradi pomlckou vsechny znanky, ktera nejsou pismena  
     $re = "/[^[:alpha:][:digit:]]/";  
     $replacement = "-";  
     $address = preg_replace ($re, $replacement, $address);  
   
     // odstrani ze zacatku a z konce retezce pomlcky  
     $address = trim ($address, "-");  
   
     // odstrani z adresy pomlcky, pokud jsou dve a vice vedle sebe  
     $re = "/[-]+/";  
     $replacement = "-";  
     $address = preg_replace ($re, $replacement, $address);  

    return $address;  
   }  
   
function _datum($r){
    $r = explode(' ', $r);
    $cast = explode('-', $r[0]);
    $datum = $cast[2].".".$cast[1].".".$cast[0]." ".$r[1];
    return $datum;
    }
function ukaz_clanek($v){
    ?>
    <article>
    <h1 style = 'margin-top: 5px; margin-bottom: 0px;'><a class='nadpis' href='clanky/<?php echo $v["link"]; ?>'><?php echo $v["jmeno_clanku"]; ?></a></h1>
    <span class="info">Vydáno dne <?php echo _datum($v["datum_clanku"]); ?> v kategorii <a href='mapa-webu/<?php echo $v["link_kategorie"]; ?>'><?php echo $v["jmeno_kategorie"]; ?></a>;
    Autor: <a href='redaktor/<?php echo $v["link_autora"]; ?>'><?php echo $v["jmeno_autora"]; ?></a>;
    Počet přečtení: <?php echo $v["pocet_precteni"]?>;
   
    </span>
    <p class="uvodnitext bez"><?php echo $v["uvod_clanku"]; ?></p><br />
    <?php
    }
    
function ukaz($vypis){
    if (mysqli_num_rows($vypis) == 0){
        ?><p>Vašemu přání neodpovídá ani jeden článek. </p><?php   
        }
    
    while ($v = mysqli_fetch_array($vypis)){    
        ukaz_clanek($v);    
        }


    }
function ukaz_testy($query){
    $vypis = mysqli_query(DATABASE::getDb(), $query);
    ?>
    <div class="post_velky"><div class="header">Poslední testy</div><div class="entry">
    <table><tr><td width = "400" cellpading = "5">
    <?php
    $pocet = 0;
    while ($vysledek = mysqli_fetch_array($vypis)){
        $text = substr($vysledek["jmeno"], 0, 35);
        if (strlen($text) < strlen($vysledek["jmeno"])){
            $text = $text."...";
            }
        ?><a class='tooltip' title='<?php echo $vysledek["jmeno"]; ?>' href='testy/<?php echo $vysledek["link"]; ?>'><?php echo $text; ?></a><br /><?php
        $pocet = $pocet +1 ;
        if ($pocet == 5){
            ?>
            </td><td>
            <?php
            }
        }
    ?></td></tr></table></div><div class='footer'></div></div><?php
    }

function _make_cat_select($kat, $r){
        $q = mysqli_query(DATABASE::getDb(), "select * from kategorie_otazky where nadrazena='$kat'");
        while ($v = mysqli_fetch_array($q)){
            $r = $r." or kategorie='".$v["id"]."'";
            $r = _make_cat_select($v["id"], $r);
            }
        return $r;
        }

function make_cat_select($kat){

        $r = "kategorie = '$kat' ";
        $r = _make_cat_select($kat, $r);
        return $r;
        }


function nahodna_otazka(){
    $q1 = mysqli_query(DATABASE::getDb(), "select count(*) as pocet from otazky where ".make_cat_select(3)) or die(mysql_error());
    $v1 = mysqli_fetch_array($q1);
    $max_pocet = $v1["pocet"];
    $q2 = mysqli_query(DATABASE::getDb(), "select id, otazka from otazky where ".make_cat_select(3)." order by RAND() LIMIT 1") or die(mysql_error());
    $v2 = mysqli_fetch_array($q2);
    $id_otazky = $v2["id"];

    ?>

    <span class='liketext'>Zkuste odpovědět na následující otázku:</span>
        <div style='border: 2px solid gray; padding: 10px; margin-left: 20px; margin-right: 20px;'>
    <form method="post" action="testy/index.php?kat=3&akce=test&otazka=<?php echo rand(0, $max_pocet-2); ?>&do=<?php echo $max_pocet; ?>&razeni=0">
    <input type="hidden" name="otazka" value="<?php echo $id_otazky; ?>" />
    <p><?php echo znacky($v2["otazka"]); ?></p>
        <?php
        $q3 = mysqli_query(DATABASE::getDb(), "select * from odpovedi where otazka='$id_otazky' order by RAND()") or die(mysql_error());
        $i = 1;
        while ($v3 = mysqli_fetch_array($q3)){
            if (Trim($v3["odpoved"]) == ""){
                $i++;
                continue;

                }
            ?><p><input type = 'hidden' name = 'odpoved-<?php echo $i; ?>' value = '<?php echo $v3["id"]; ?>' /><input name='check-<?php echo $i; ?>' type = 'checkbox' /> <?php echo znacky($v3["odpoved"]); ?></p>
            <?php
            $i++;

            }
        ?>
        <div style="text-align: center; ">
            <input class ="formbutton" type="submit" value ="Odpovědět" />

        </div>
    </form>
    </div>
    <?php
}


?>
