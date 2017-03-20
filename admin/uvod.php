<?php
include("./kontrola.php");
function pocet_radku($q){
    $v = mysqli_query(DATABASE::getDb(), $q);
    $v = mysqli_fetch_array($v);
    return $v["pocet"];
    }
?>            
<div class = 'tabulka'>
<a href='index.php?akce=edit_cl'><img src='images/document-new.png' alt='' />Nový článek</a>
 &nbsp;  &nbsp; <a href='index.php?akce=clanky&zobraz=moje'><img src='images/document-open.png' alt='' />Přehled Vašich článků</a>
 &nbsp;  &nbsp; <a href='index.php?akce=napoveda'><img src='images/help-browser.png' alt='' />Nápověda</a>
</div>
<?php

?>
<div class = 'tabulka'>  
Statistika: 
Celkem článků: <?php echo pocet_radku("select count(id) as pocet from clanky where autor = '".id_uzivatele."'");?>
; Rozpracovaných článků: <?php echo pocet_radku("select count(id) as pocet from clanky where autor = '".id_uzivatele."' and dokoncen = 'ne'");?>
; Vydaných článků: <?php echo pocet_radku("select count(id) as pocet from clanky where autor = '".id_uzivatele."' and dokoncen = 'ano'");?>
</div>
<div class = 'tabulka'>  
<table>
<tr><td>Poslední články</td><td>Nejnovější komentáře</td></tr>
<tr><td style='width: 50%;'>
<ol class = 'scroll'>
<?php 
$vypis = mysqli_query(DATABASE::getDb(), "select jmeno, id from clanky where autor = '".id_uzivatele."' order by id desc limit 15");

while ($v = mysqli_fetch_array($vypis)){
    ?>
    <li><a href='index.php?akce=edit_cl&id=<?php echo $v["id"];?>'><?php echo $v["jmeno"];?></a></li>    
    <?php
    }
?>
</ol>
</td>
<td> 
<ol class = 'scroll'>
<?php 
$vypis = mysqli_query(DATABASE::getDb(), "select komentare.autor as autor, komentare.id as komentar_id, komentare.predmet as predmet, clanky.link as link, clanky.jmeno as jmeno_clanku, clanky.id as clanek_id from komentare left join clanky on clanky.id = komentare.clanek  order by komentare.id desc limit 15") or die(mysql_error());  //where komentare.id_autora = '".id_uzivatele."'

while ($v = mysqli_fetch_array($vypis)){
    ?>
    <li><a href='../clanky/<?php echo $v["link"];?>#komentar-<?php echo $v["komentar_id"];?>'><?php echo $v["autor"];?>: <?php echo $v["predmet"];?></a> | <?php echo $v["jmeno_clanku"];?></li>    
    <?php  
    }
?>
</ol>
</td></tr>
</table>
</div>
<div id="fb-root"></div>
<script src="http://connect.facebook.net/cs_CZ/all.js"></script>
<script>
  FB.init({
    appId  : '135212003208377',
    status : true, // check login status
    cookie : true, // enable cookies to allow the server to access the session
    xfbml  : true  // parse XFBML
  });
</script>
<div>
<?php

$q = mysqli_query(DATABASE::getDb(), "select link from clanky");

$cookie = $_COOKIE["fbs_135212003208377"];
$cookie = substr($cookie, 2, strlen($cookie)-4);
$q2 = "https://api.facebook.com/method/fql.query?query=select+xid,username,fromid,text,time+from+comment+where+";
$pole = array();
while ($v = mysqli_fetch_array($q)){
    $pole[] = "xid%3D%22http%253A%252F%252Fmaths.cz%252Fclanky%252F".$v["link"].'%22';
    //echo file_get_contents($q2)."<br /><br />";
}


$q2 = $q2.implode("%20or%20", $pole).'+order+by+time&'.$cookie."&format=json";

$vysledek = json_decode(file_get_contents($q2));
$pocet = 0;
foreach($vysledek as $prvek){
    $pocet = $pocet + 1;
    ?><div style="padding: 10px; border: 1px solid#000; margin: 5px;">
        <?php echo date("j. n. Y, G:i", $prvek->time); ?>,  <a href = "<?php echo urldecode($prvek->xid); ?>"><?php echo urldecode($prvek->xid); ?></a>

        <br />
<!--        <p><?php echo $prvek->username; ?>(<fb:name uid="<?php echo $prvek->fromid; ?>"></fb:name>)</p>-->
 
        <p><?php echo $prvek->text; ?>     </p>

    </div>
    <?php

}
/**/?>
Celkový počet komentářů: <strong><?php echo $pocet;?></strong>

</div>