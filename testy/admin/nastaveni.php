<?php
$q = mysqli_query(DATABASE::getDb(), "select * from nastaveni_otazky where id = '1'") or die(mysql_error());
$v = mysqli_fetch_array($q);
?>

<form method="post" action="uloz-nastaveni.php">
<table width="100%">
    <tr>
        <td width="10">Reklama: </td><td><textarea name="reklama" cols="2" rows="4" style="width: 100%;"><?php echo $v["reklama"]; ?></textarea></td>
    </tr>
    <tr>
        <td>Zobrazit reklamu: </td><td>
            <input <?php if ($v["zobrazit_reklamu"] == 1){echo "checked='checked'"; }?> type="radio" name="zobrazit_reklamu" value="1" /> Ano
            <input <?php if ($v["zobrazit_reklamu"] == 0){echo "checked='checked'"; }?> type="radio" name="zobrazit_reklamu" value="0" /> Ne
        </td>
    </tr>
    <tr>
        <td colspan="2"><input type="submit" value="Uložit" /></td>
    </tr>
</table>
</form>