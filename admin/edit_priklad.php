<?php

include("kontrola.php");

$otazka = "";

$reseni = "";

$id = -1;

if (IsSet($_GET["id"])){

    $id = $_GET["id"];

    $vypis = mysqli_query(DATABASE::getDb(), "select * from priklady where id = '$id'");

    $v = mysqli_fetch_array($vypis);

    $otazka = $v["otazka"];

    $reseni = $v["reseni"];

    ?><p><strong>Editujete příklad [<?php echo $id; ?>]: </strong><?php

    echo ukazka_prikladu($otazka);   

    ?></p><?php 

    }

?>

<form id='pridat' method = 'post' action = 'uloz-priklad.php'>

<input type = 'hidden' name = 'id' value = '<?php echo $id; ?>' />

<table>

<tr><td style='vertical-align: top;' >Otázka: </td><td><textarea style='width: 100%;' name='otazka' cols = '100' rows = '10'><?php echo $otazka; ?></textarea></td></tr>

<tr><td style='vertical-align: top;'>Řešení: </td><td><textarea style='width: 100%;' name='reseni' cols = '100' rows = '10'><?php echo $reseni; ?></textarea></td></tr>

<tr><td colspan = '2'><input type = 'submit' value = 'Uložit' /></td></tr>

</table>

</form>



