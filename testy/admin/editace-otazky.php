<?php
if (IsSet($_GET["id"])){
    $id = $_GET["id"];
    $q = mysqli_query(DATABASE::getDb(), "select * from otazky where id = '$id'");
    $v = mysqli_fetch_array($q);
    $kategorie = $v["kategorie"];
    $otazka = $v["otazka"];
    $reseni = $v["reseni"];
    $q = mysqli_query(DATABASE::getDb(), "select * from odpovedi where otazka = '$id'");
    $i = 0;
    $odpovedi = array();
    while ($v = mysqli_fetch_array($q)){
        $odpovedi[] = array($v["id"], $v["spravne"], $v["odpoved"]);
        $i = $i + 1;
        }
    }
else{
    $id = 0;
    $otazka = "";
    $reseni = "";
    $kategorie = -1;
    $odpovedi = array();
    $i = 0;
    while ($i != 4){
        $odpovedi[] = array("0", 0, "");
        $i++;
        }
    }
?>

<form method = 'post' action = 'uloz-otazku.php'>
<input type = 'hidden' name = 'id_otazky' value = '<?php echo $id; ?>' />
<table width="100%">
<tr><td colspan="2"><textarea style="width: 100%;" name="otazka" cols="20" rows="3"><?php echo $otazka; ?></textarea></td></tr>
<?php
$i = 0;
while ($i != 4){
    ?>
    <tr><td width="20" style="vertical-align: middle;">
    <input type = 'hidden' name = 'id-<?php echo $i; ?>' value = '<?php echo $odpovedi[$i][0]; ?>' />
    <input name = 'check-<?php echo $i; ?>' type = 'checkbox' <?php if ($odpovedi[$i][1] == 1){echo 'checked = "checked"';}?> />
    </td><td><textarea style="width: 100%;" cols="20" rows="3" name = 'odpoved-<?php echo $i; ?>'><?php echo $odpovedi[$i][2]; ?></textarea></td></tr><?php
    $i++;
    }
?>
<tr><td width="40" style="vertical-align: top;">Řešení: </td><td>
        <textarea name="reseni" style="width: 100%;" cols="20" rows="8"><?php echo $reseni; ?></textarea>
        <p style="font-size: 0.8em;">Toto není povinné - vyplňujte pouze u zajímacých a těžkých otázek a máte-li čas :-)</p>
    </td></tr>
<tr><td colspan="2">Kategorie: <?php kategorie_select($kategorie); ?></td></tr>
<tr><td colspan="2"><input type = 'submit' value = 'Uložit' /></td></tr>
</table>
</form>
