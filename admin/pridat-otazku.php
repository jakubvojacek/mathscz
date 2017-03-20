<?php
include("kontrola.php");
echo "<form action = 'uloz_otazku.php' method = 'post'>";

echo "<table>";

if (IsSet($_GET["id"])){
    $id = $_GET["id"];
    echo "<input type = 'hidden' name = 'id_'  value = '$id' />";
    $vypis = mysqli_query(DATABASE::getDb(), "select * from otazky_old where id = '$id'");
    $vypis = mysqli_fetch_array($vypis);
    echo "<input type = 'hidden' name = 'test_' value = '".$vypis["test"]."' />";
    $otazka = $vypis["otazka"];
    $a = $vypis["a"];
    $b = $vypis["b"];
    $c = $vypis["c"];
    $d = $vypis["d"];
    $spravne = $vypis["spravne"];
    $typ = $vypis["typ"];
    }
else{
    $test = $_GET["test"];
    echo "<input type = 'hidden' name = 'test_' value = '$test' />";
    echo "<input type = 'hidden' name = 'id_'  value = '-1' />";
    $otazka = "";
    $a = "";
    $b = "";
    $c = "";
    $d = "";
    $spravne = "";
    $typ = 0;
    }
echo "<tr><td>Otázka</td><td width = '100%;'><textarea name = 'otazka_' cols='4' rows='4' style='width:100%;'>$otazka</textarea></td></tr>";
echo "<tr><td>A: </td><td><input type = 'text' name = 'a_' value = '$a' style='width:100%;' /></td></tr>";
echo "<tr><td>B: </td><td><input type = 'text' name = 'b_' value = '$b' style='width:100%;' /></td></tr>";
echo "<tr><td>C: </td><td><input type = 'text' name = 'c_' value = '$c' style='width:100%;' /></td></tr>";
echo "<tr><td>D: </td><td><input type = 'text' name = 'd_' value = '$d' style='width:100%;' /></td></tr>";
echo "<tr><td>Správně: </td><td><input type = 'text' name = 'spravne_' value = '$spravne' /></td></tr>";
$ch1 = " checked = 'checked'";
$ch2 = "";
if ($typ == 1){
    $ch1 = "";
    $ch2 = "checked = 'checked'";
    }
echo "<tr><td>Typ otázky:</td><td><input type = 'radio' name = 'typ_' value = '0' $ch1; />Standardní";
echo " <input type = 'radio' name = 'typ_' value = '1' $ch2 />ABCD </td></tr>";
echo "<tr><td colspan = '2'><input type = 'submit' value = 'Uložit' /></td></tr>";
echo "</table>";
echo "</form>";
?>
