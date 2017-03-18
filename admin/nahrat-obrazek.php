<?php
Header('Content-type: text/html; charset=utf-8');
include("../funkce/pripojeni.php");
include("../funkce/funkce.php");
include("./kontrola.php");
define("je_prihlasen", je_prihlasen());
function uprav_delku($r, $d){
    $delka = strlen($r);
    if ($delka < $d){
        $rozdil = $d - $delka;
        $vsuvka = "";
        for ($i=0; $i != $rozdil; $i++){
            $vsuvka = $vsuvka."0";
            }
        $r = $vsuvka.$r;
        }
    return $r;
    }
function nahraj_obrazek($real, $file, $popis){

    $id = mysql_fetch_array(mysql_query("SHOW TABLE STATUS LIKE 'obrazky'"));
    $id = $id["Auto_increment"] + 1;

    $jmeno = Date("Ymd").$id.$real;
    $kam = "obrazky/$jmeno";

    if (move_uploaded_file($file, "../".$kam)){

        chmod("../".$kam, 0777);

        list($sirka, $vyska) = vytvor_thumb("../".$kam);

        echo "<p style = 'text-align: center;'>Obrázek byl úspěšně nahrán</p>";
        mysql_query("insert into obrazky(cesta, jmeno, autor) values('$jmeno', '$popis', '".id_autora."')") or die(mysql_error());
        echo "<a href='index.php?akce=obrazky'>Zpět do administrace</a>";
        }
    else{
        echo "<p style = 'text-align: center;'>Při nahrávání obrázku na server došlo k chybě</p>";
        }
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
    $koncovka=strtolower(pathinfo($file, PATHINFO_EXTENSION));
    $jmeno = basename($file);
    $adresar = dirname($file);
    $thumb_name = "$adresar/_$jmeno";

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
    @$images_out = imagecreatetruecolor($maxx, $maxy);
    @imagecopyresampled($images_out, $images_in, 0, 0, 0, 0, $maxx, $maxy, $width, $height);
    @imagejpeg($images_out, $thumb_name);
    list($width, $height) = getimagesize($file);
    return array($width, $height);
    }

$soubor = $_FILES["soubor"]["tmp_name"];
$name = $_FILES["soubor"]["name"];
$popis = $_POST["popis"];
$koncovka = strtolower(pathinfo($name, PATHINFO_EXTENSION));
$pole = array("jpg"=>"jpg", "jpeg"=>"jpeg", "png"=>"png", "gif"=>"gif");
if (je_prihlasen == 0){
    ?><p>Nejste přihlášen!</p><?php
    }
elseif (skupina == 3){
    ?><p>Nemáte právo pro nahrávání obrázků!</p><?php
    }
elseif (array_key_exists($koncovka, $pole)){
    nahraj_obrazek($name, $soubor, $popis);
    }
else{
    ?>
    <p style='text-align: center;'>Tento druh obrázku není podporován. Podporované druhy jsou pouze png, jp(e)g a gif.</p>
    <a href='index.php?akce=obrazky' style = 'text-align: center;'>Zpět do administrace</a>
    <?php
    }
?>
