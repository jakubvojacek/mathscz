<?php
function vypis_polozky($dir){
    if (is_dir($dir) != 1){
        echo "<p style = 'text-align: center;'>Zadaný adresář neexistuje</p>";
        return 0;
        }
    $adresar = opendir($dir);
    while ($soubor = readdir($adresar)){
        if ($soubor == "." or $soubor == ".."){
            continue;
            }
        elseif (is_dir("$dir/$soubor")){
            echo "\n<a href='list/$dir/$soubor' class='item dir'>";
			echo "\n<span>$soubor</span>";
			echo "\n</a>";
            }
        }
    $adresar = opendir($dir);
    $pocet = 0;
    while ($soubor = readdir($adresar)){
        if ($soubor == "." or $soubor == ".."){
            continue;
            }
        elseif (is_file("$dir/$soubor") and substr($soubor, 0, 6) != "thumb_"){
            vytvor_thumb("$dir/$soubor");
            ukaz_miniaturu($dir, basename($soubor));              
            $pocet = $pocet + 1;               
            }
        }
    if ($pocet == 0){
        echo "<p style = 'text-align: center;'>V tomto adresáři nejsou žádné fotky</p>";
        }
    return 1;
    }
function ukaz_miniaturu($dir, $real){
    echo "\n<a href='view/$dir/$real' class='item photo'>";
    echo "\n<img src = '$dir/thumb_".$real."' alt = 'Náhled nenalezen' />";
    echo "\n</a>";
    }

function image_shrink_size($file_in, $max_x = 0, $max_y = 0) {
    list($width, $height) = getimagesize($file_in);
    if (!$width || !$height) {
        return array(0, 0);
    }
    if ($max_x && $width > $max_x) {
        $height = round($height * $max_x / $width);
        $width = $max_x;
    }
    if ($max_y && $height > $max_y) {
        $width = round($width * $max_y / $height);
        $height = $max_y;
    }
    return array($width, $height);
}
function vytvor_thumb($file){           
    //die($file);
    $koncovka=strtolower(pathinfo($file, PATHINFO_EXTENSION));
    $jmeno = basename($file);
    $adresar = dirname($file);
    $thumb_name = "$adresar/thumb_$jmeno";
    if (is_file($thumb_name)){//pokud existuje miniatura...
        return;
        }
    list($width, $height) = getimagesize($file);  
    if ($koncovka == "jpg" or $koncovka == "jpeg"){
        @$images_in = imagecreatefromjpeg($file);
        }
    elseif ($koncovka == "png"){
        @$images_in = imagecreatefrompng($file);
        }
    elseif ($koncovka == "gif"){
        @$images_in = imagecreatefromgif($file);
        }
    $maxx = 100;
    list($maxx,$maxy)=image_shrink_size($file,160,120);
    $images_out = imagecreatetruecolor($maxx, $maxy);
    imagecopyresampled($images_out, $images_in, 0, 0, 0, 0, $maxx, $maxy, $width, $height);
    imagejpeg($images_out, $thumb_name);
    }
function ukaz_fotku($fotka){
    if (is_file($fotka) != 1){
        echo "<p style = 'text-align: center;'>Zadaná fotka neexistuje</p>";
        return 0;
        }
    $jmeno = basename($fotka);
    $dir = dirname($fotka);
	echo "<a href='$fotka'>";
	echo "<img id='main_img' src = '$fotka' alt = 'Náhled nenalezen' />";
	echo "</a>";
    $adresar = opendir($dir);
    $pocet = 0;
    $pole = array();
    $i = 0;
    while ($soubor = readdir($adresar)){
        $real = substr($soubor, 6, strlen($soubor));
        
        
        if ($soubor == "." or $soubor == ".."){
            continue;
            }
        //echo "real: ".$real." iunrea".$jmeno." soubor: $soubor<br />";   
        if ($real == $jmeno){
            $dana_fotka = $i;
            }
        elseif (is_file("$dir/$soubor") and substr($soubor, 0, 6) == "thumb_"){
            $pole[$i] = array($soubor, $real);
            $i = $i + 1;
            }
        
        }
    //echo "<div style = 'float: right;'>";
    //print_r($pole);
    //echo "?".$jmeno;
    if ($dana_fotka != 0){
        list($soubor, $real) = $pole[$dana_fotka-1];
        ukaz_miniaturu($dir, $real);
        }    
    if ($dana_fotka != count($pole)){
        list($soubor, $real) = $pole[$dana_fotka];
        ukaz_miniaturu($dir, $real);
        }
    echo "</div>";
    echo '<br style="clear: both;"/>';
    return 1;
    }   

function ukaz_nav($dir, $url, $adresar, $odecist, $ukaz_upload){
    echo "<div class = 'nav'>";
    echo "<a href='$url'>Kořenový adresář</a>";
    $pole = split('/', $dir);
    $r = $adresar;
    for ($i=1; $i <= count($pole)-$odecist; $i++){
        $r = $r."/".$pole[$i];
        echo " » <a href='list/$r'>$pole[$i]</a>";
        }
    if ($ukaz_upload == 1){
        echo "<br />";
        echo "<a href='#upload'>Nahrát vlastní obrázek</a>";
        }
    echo "</div>";
    echo "<div id='container'>";
    echo "<div id=\"main\">";
    }   

function nahraj_obrazek($real, $file, $kat, $url){
    $kam = "$kat/$real";
    if (!file_exists($kam)){
        if (move_uploaded_file($file, $kam)){
            chmod($kam, 0777);
            vytvor_thumb($kam);
            echo "<p style = 'text-align: center;'>Obrázek byl úspěšně nahrán</p>";
            header("Location: $url/view/$kat/$real");
            return 1;
            }
        else{
            echo "<p style = 'text-align: center;'>Při nahrávání obrázku na server došlo k chybě</p>";
            return 0;
            }
        }
    else{
        echo "<p style = 'text-align: center;'>Takový obrázek již v dané kategorii je. Změňte prosím jméno obrázku</p>";
        return 0;
        }
    return 1;
    }

$config = array();
$config["jmeno"] = "Fotky";//Jméno galerie
$config["popis"] = "Galerie...";//Popis galerie
$config["url"] = "http://localhost/spg/";
$config["url"] = "http://www.maths.cz/spg/";//Adresa ke kořenovému adresáři galerie
$config["adresar"] = "fotky";//Adresář s fotkami
$config["upload"] = true;//Povolit či zakázat upload fotek ostatním uživatelům (true & false)

$ukazana_fotka = 1;
$ukazany_adresar = 1;
$nahrana_fotka = 1;

echo '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cz" lang="cz">
<head>';
echo "\n<base href=\"".$config["url"]."\" />";
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
echo "\n<title>".$config["jmeno"]."</title>";
echo '<link rel="stylesheet" href="style.css" type="text/css" media="screen" />';
echo "\n<meta name=\"description\" content=\"".$config["popis"]."\" />\n";
echo '</head><body>';

echo "<div id = 'header'>";
echo "<h1><a href=''>".$config["jmeno"]."</a></h1>";
echo "<p>".$config["popis"]."</p>";
echo "</div>";
if (IsSet($_GET["slozka"])){  
    $slozka = $_GET["slozka"];    
    ukaz_nav($slozka, $config["url"], $config["adresar"], 1, $config["upload"]);
    $ukazany_adresar = vypis_polozky($slozka);
    }
elseif (IsSet($_GET["fotka"])){
    $fotka = $_GET["fotka"];  
    ukaz_nav($fotka, $config["url"], $config["adresar"], 2, $config["upload"]);
    $ukazana_fotka = ukaz_fotku($fotka);
    }
elseif (IsSet($_POST["_kategorie"])){
    $soubor = ($_FILES["soubor"]["tmp_name"]);
    $name = ($_FILES["soubor"]["name"]);
    $kat = $_POST["_kategorie"];
    $nahrana_fotka = nahraj_obrazek($name, $soubor, $kat, $config["url"]);
    }
else{ 
    ukaz_nav($config["adresar"], $config["url"], $config["adresar"], 1, $config["upload"]);
    vypis_polozky($config["adresar"]);
    }
echo "<br style=\"clear: left\" /><br />";
echo "</div>";
echo "</div>";
if ($config["upload"] == true and $ukazana_fotka == 1 and $ukazany_adresar == 1 and $nahrana_fotka == 1){
    echo "<div class = 'nav'>";
    echo "<a id = 'upload' name = 'upload'></a>";
    echo "<h2 style = 'margin-bottom: 0;'>Nahrát obrázek</h2>";
    echo "<p>Podporované formáty: png, gif, jp(e)g</p>";
    echo "<form method=\"post\" enctype=\"multipart/form-data\" action = 'index.php'>";
    if (IsSet($_GET["slozka"])){  
        $kategorie = $_GET["slozka"];
        }
    elseif(IsSet($_GET["fotka"])){
        $pole = split('/', $_GET["fotka"]);
        $r = "";
        for ($i=0; $i <= count($pole)-2; $i++){
            $r = $r."/".$pole[$i];
            }
        $kategorie = $r;
        }
    else{
        $kategorie = $config["adresar"];
        }
    echo "<table border = '0' width = '50%'>";
    echo "<input type = 'hidden' value = '$kategorie' name = '_kategorie' />";
    echo "<tr><td>Soubor: </td><td><input name='soubor' type='file'/></td></tr>";
    echo "<tr><td colspan='2'><input type = 'submit' value = 'Nahrát' /></td></tr>";
    echo "</table>";
    echo "</form>";
    echo "</div>";
    }
else{
    echo "<div style = 'border-top: 1px solid white;'></div>";
    }
echo "<div class = 'paticka'>";
echo "Simple Photo Gallery &copy; 2008 Jakub Vojáček";
echo "</div>";
?>
</body>
</html>
