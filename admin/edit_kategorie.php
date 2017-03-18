<?php
include("./kontrola.php");
$nadrazena = -1;
$kat = "Kořen kategorií";
if (IsSet($_GET["nadrazena"])){
    $nadrazena = $_GET["nadrazena"];
    $vypis = mysql_query("select jmeno from kategorie where id = '$nadrazena'");
    $v = mysql_fetch_array($vypis);
    $kat = $v["jmeno"]; 
    }

?>
<fieldset><legend>[ Vkládate novou kategorii do kategorie '<?php echo $kat; ?>' ]</legend>
<form method = 'post' action = 'uloz_kat.php'>
<input type = 'hidden' name = 'nadrazena' value = '<?php echo $nadrazena; ?>' />
<table>
<tr><td>Jméno: </td><td><input type = 'text' name = 'jmeno' /></td></tr>
<tr><td colspan = '2'><input class='formbutton' type = 'submit' value = 'Uložit kategorii' /></td></tr>
</table>
</form>
</fieldset>
