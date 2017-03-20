<?php
include("./kontrola.php");   
@session_start();
$v = mysqli_query(DATABASE::getDb(), "select * from nastaveni where id = '1'");
$v = mysqli_fetch_array($v);
if (skupina != 0){
    ?><p>Do této kategorie nemáte přístup</p><?php
    return;    
    }
?>

<form method = 'post' action = 'uloz_nastaveni.php'>
<table>
<tr><td>Titulek</td><td><input class = 'input' name = 'nazev_webu' type='text' value = '<?php echo $v["nazev_webu"];?>' /></td></tr>
<tr><td>URL webu:</td><td><input class = 'input' name = 'url_webu' type='text' value = '<?php echo $v["url_webu"];?>' maxlength = '100' /></td></tr>
<tr><td>Popis webu:</td><td><input class = 'input' name = 'popis_webu' type='text' value = '<?php echo $v["popis_webu"];?>' maxlength = '200' /></td></tr>
<tr><td style='vertical-align: top;'>Klíčová slova<br /><span style='font-size: 11px;'>(oddělte čárkou)</span></td><td><textarea rows='5' cols='80' class = 'input' name ='klicova_slova'><?php echo $v["klicova_slova"];?></textarea></td></tr>
<tr><td style='vertical-align: top;'>Reklamní kód</td><td><textarea rows='5' cols='80' class = 'input' name ='reklama'><?php echo $v["reklama"];?></textarea></td></tr>
<tr><td colspan='2'><input class='formbutton' type='submit' value = 'Uložit' /></td></tr>
</table>  
</form>