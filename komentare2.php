<?php

function ukaz_komentar($v){

    ?><div id='kombody' style=''><div id='komheading'><?php
    
    if (je_prihlasen and skupina != 3){
     
        ?><a href='smaz_komentar.php?komentar=<?php echo $v["id"]; ?>'>Smazat</a><br /><?php
        }

    ?><strong>Předmět: </strong><?php echo $v["predmet"]; ?><br />
    <?php
    if ($v["id_autora"] == -1 or $v["id_autora"] == 0){
        ?><strong>Vložil:</strong> <?php echo $v["autor"]; ?> <br /><span class='kominfo'>vloženo dne <?php echo $v["datum"]; ?> (GMT+1)</span><?php
        }
    else{
        ?><strong>Vložil:</strong> <a href='http://forum.maths.cz/profile.php?id=<?php echo $v["id_autora"]; ?>'><?php echo $v["autor"]; ?></a> <br /><span class='kominfo'>vloženo dne <?php echo $v["datum"]; ?> (GMT+1)</span><?php
        }
    ?>
 
   
    </div><div id="komentar">
    <?php echo WordWrap(PremenSmajliky(Znacky($v["text"])),100, "\n", 1); ?>
    </div>   
    </div> 
    <a id='komentar-<?php echo $v["id"]; ?>'></a>
    <?php
  
  }  



?>

<?php
$autor = "";
$predmet = "";
$text = "";
@session_start();
if (IsSet($_SESSION["komentare"]) and $_SESSION["komentare"] != ""){ 
    ?>
    <table style='width: 90%; margin: 20px; border: 2px dashed gray;'><tr><td width = '5' style='vertical-align: top;'><img src='images/delete.png' alt = '' /></td><td style='vertical-align: top;'>
    <ul><?php
    foreach($_SESSION["komentare"][0] as $chyba){
        ?><li><?php echo $chyba; ?></li><?php        
        } 
    ?><ul></td></tr></table><?php 
    $autor = $_SESSION["komentare"][1];
    $predmet = $_SESSION["komentare"][2];
    $text = $_SESSION["komentare"][3];
    $_SESSION["komentare"] = "";  
    }

?>


<script type="text/javascript">
 var RecaptchaOptions = {
    theme : 'clean'
 };
 </script>
<form action = 'uloz_komentar.php' method = 'post'>
       
<table width='100%'>
<?php

if (je_prihlasen == 0){
    ?>
    <tr><td width = '70'><span class='kompopisek'>Jméno: </span></td><td><input class='komnick' type = 'text' name = 'autor' value = '<?php echo $autor; ?>' /></td></tr>
    <input type = 'hidden' name = 'id_autora' value = '-1' />
    <?php
    }
else{
    ?>
    <input type = 'hidden' name = 'id_autora' value = '<?php echo id_uzivatele;?>' />
    <input type = 'hidden' name = 'autor' value = '<?php echo jmeno_uzivatele;?>' />
    <?php
    }
?>
<input type='hidden' name='clanek' value = '<?php echo $id_clanku;?>' />
<tr><td width = '70'><span class='kompopisek'>Předmět: </span></td><td><input value = '<?php echo $predmet; ?>' maxlength = '30' type = 'text' name = 'predmet' class='komnick' /></td></tr>   
<tr><td></td><td>

<a style='cursor:pointer; ' onclick="insertAroundSelection('text', '[b]', '[/b]')"><img src='admin/images/k_tucne.gif' alt='=O' /></a>
<a style='cursor:pointer; ' onclick="insertAroundSelection('text', '[i]', '[/i]')"><img src='admin/images/k_kurziva.gif' alt='=O' /></a>
<a style='cursor:pointer; ' onclick="insertAroundSelection('text', '[u]', '[/u]')"><img src='admin/images/k_pod.gif' alt='=O' /></a>


</td></tr>
<tr><td style = 'vertical-align: top;'><span class='kompopisek'>Text: </span></td><td><textarea class='komtext' cols='5'  rows = '8' id = 'text' name='text'><?php echo $text;?></textarea></td></tr>
<tr><td></td><td>
<a style='cursor:pointer; ' onclick="insertAtCursor('text', ':sm1:')"><img src='images/smilleys/1.gif' alt=':)' /></a>
<a style='cursor:pointer; ' onclick="insertAtCursor('text', ':sm2:')"><img src='images/smilleys/2.gif' alt='O:)' /></a>
<a style='cursor:pointer; ' onclick="insertAtCursor('text', ':sm3:')"><img src='images/smilleys/3.gif' alt=';)' /></a>
<a style='cursor:pointer; ' onclick="insertAtCursor('text', ':sm4:')"><img src='images/smilleys/4.gif' alt=':D' /></a>
<a style='cursor:pointer; ' onclick="insertAtCursor('text', ':sm5:')"><img src='images/smilleys/5.gif' alt=':|' /></a>
<a style='cursor:pointer; ' onclick="insertAtCursor('text', ':sm6:')"><img src='images/smilleys/6.gif' alt=':>' /></a>
<a style='cursor:pointer; ' onclick="insertAtCursor('text', ':sm7:')"><img src='images/smilleys/7.gif' alt='>:O' /></a>
<a style='cursor:pointer; ' onclick="insertAtCursor('text', ':sm8:')"><img src='images/smilleys/8.gif' alt='=P' /></a>
<a style='cursor:pointer; ' onclick="insertAtCursor('text', ':sm9:')"><img src='images/smilleys/9.gif' alt='=O' /></a>



</td></tr>  
<?php
if (je_prihlasen == 0){
    ?>
    <tr><td style = 'vertical-align: top;'><span class='kompopisek'>Opište kód z obrázku: </span></td><td style = 'vertical-align: top;'>
    <?php
          require_once('recaptchalib.php');
          $publickey = "6LdTvrsSAAAAAOthHHR7_bPOlXNqgU1bHWrUydzz"; // you got this from the signup page
          echo recaptcha_get_html($publickey);
    ?> 
    
    </td></tr>    
    <tr><td></td><td><span class='kompopisek'>Nebaví Vás vyplňovat kontrolní kódy? <a href='akce/prihlaseni'>Přihlašte se!</a></span></td></tr>
    <?php
    }
    ?>
<tr><td colspan = '2'><input class='komsubmit' type = 'submit' value = 'Komentovat' /></td></tr>
</table>
</form>
<?php

$vypis=mysqli_query(DATABASE::getDb(), "select * from komentare where clanek='$id_clanku' order by id");

if (mysqli_num_rows($vypis) != 0){
    while ($vysledek = mysqli_fetch_array($vypis)){
        ukaz_komentar($vysledek);        
        }
    }
  
?>
