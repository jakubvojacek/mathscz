<?php
include("kontrola.php");

?>
<p><a href='index.php?akce=edit_priklad'>Přidat nový příklad</a></p>
<fieldset><legend> [ Příklady ]</legend>
<table>
<?php
$vypis = mysql_query("select * from priklady order by id desc");
while ($v = mysql_fetch_array($vypis)){
    ?><tr><td><?php echo ukazka_prikladu($v["otazka"]);?></td><td><a href = 'index.php?akce=edit_priklad&id=<?php echo $v["id"];?>#pridat'>Editovat</a></td><td><a href = 'smaz.php?priklad=<?php echo $v["id"];?>'>Smazat</a></td></tr><?php
    }
?>
</table>
</fieldset>

<?php
