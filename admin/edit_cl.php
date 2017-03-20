<?php

include("./kontrola.php");



function vypis_kat_clanek($nadrazena, $odsazeni, $kat){

    $vypis = mysqli_query(DATABASE::getDb(), "select * from kategorie where nadrazena = '$nadrazena' order by id");

    while ($vysledek = mysqli_fetch_array($vypis)){

        $vsuvka = "";

        for ($i=0; $i != $odsazeni*2; $i++){

            $vsuvka = $vsuvka."&nbsp;";

            }

        $vsuvka = $vsuvka."&not;&nbsp;";

        ?>

        <option value='<?php echo $vysledek["id"];?>' <?php if($kat == $vysledek["id"]){ ?>selected='selected'<?php } ?> ><?php echo $vsuvka.$vysledek["jmeno"];?></option>

        <?php

        vypis_kat_clanek($vysledek["id"], $odsazeni + 2, $kat);

        }

    if (mysqli_num_rows($vypis) == 0){

        return 0;

        } 

    return 1;

    }

$id = -1;

$jmeno = "";

$uvod = "";

$text = "";

$autor = id_uzivatele;

$kategorie = -1;

$dokoncen = "ne";

$klicova_slova = "";

$testy = "";

$disabled_jmeno = "";



if (IsSet($_GET["id"])){       

    $id = $_GET["id"];

    $vypis = mysqli_query(DATABASE::getDb(), "select * from clanky where id = '$id'");

    $v = mysqli_fetch_array($vypis);

    if ($v["povolit_editaci_jmena"] != 1){

        $disabled_jmeno = " disabled ";

        }

    $jmeno = $v["jmeno"];

    $uvod = $v["uvod"];

    $text = $v["text"];

    $kategorie = $v["kategorie"];

    $autor = $v["autor"];

    $dokoncen = $v["dokoncen"];

    $klicova_slova = $v["klicova_slova"];

    $testy = $v["testy"];

    }

//$vypis = mysqli_query(DATABASE::getDb(), "select * from kategorie");



?>

<form method = 'post' action = 'uloz_cl.php'>    

<input type = 'hidden' name = 'id' id = 'id' value = '<?php echo $id;?>' />

<input type = 'hidden' name = 'autor' id = 'autor' value = '<?php echo $autor;?>' />

<table width = '95%'>

<?php

if ($id != -1){

    ?>

    <tr><td colspan='2'><a style='cursor: pointer;' onclick = 'uloz_clanek()'><img style='position: relative; top: 7px;' src='images/save_cl.png' alt='' /> Průběžně uložit</a>

    <span id='zprava'></span>

    <?php }?>

</td></tr>



<tr><td>Jméno:</td><td><input <?php echo $disabled_jmeno; ?> class = 'input' type = 'text' name = 'jmeno' id = 'jmeno' value = '<?php echo $jmeno;?>' />

<br />

<?php

if ($disabled_jmeno == ""){

    ?><span style='font-size: 0.9em; color: #B42000'>Jméno článku si pečlivě rozmyslete, později ho nebude možné změnit</span><?php

    }                                                                        

else{

    ?>

    <span style='font-size: 0.9em; color: #B42000'>Jméno článku nelze změnit (v případě, že to je opravdu nutné, zašlete svoji žádost na <em>jakub.vojacek@maths.cz</em></span>

    <input type = 'hidden' name = 'jmeno' id = 'jmeno' value = '<?php echo $jmeno ;?>' />

    <?php

    }



?>

</td></tr>

<tr><td>Úvod:</td><td><input class = 'input' type = 'text' name = 'uvod' id = 'uvod' value = '<?php echo $uvod;?>' /></td></tr>

<tr><td></td><td>

<?php include("tlacitka.php");?>



</td></tr>

<tr><td style='vertical-align: top;'>Text:</td><td><textarea rows='30' cols='100' class='input' name = 'text' id = 'text'><?php echo $text;?></textarea></td></tr>

<tr><td>Kategorie:</td><td><select name = 'kategorie' id = 'kategorie'>

<option value = '-1'>Kořenový adresář</option>

<?php

vypis_kat_clanek(-1, 0, $kategorie);

?>

</select></td></tr>



<tr><td style='vertical-align: top;'>Testy<br /><span style='font-size: 11px;'>(jednotlivé testy oddělte čárkou)</span></td><td><textarea rows='5' cols='100' class='input' name = 'testy' id = 'testy'><?php echo $testy;?></textarea></td></tr>

<tr><td style='vertical-align: top;'>Klíčová slova<br /><span style='font-size: 11px;'>(jednotlivá slova oddělte čárkou)</span></td><td><textarea rows='5' cols='100' class='input' name = 'klicova_slova' id = 'klicova_slova'><?php echo $klicova_slova;?></textarea></td></tr>

<tr><td>Dokončen</td><td><input class = 'auto' <?php if($dokoncen == "ano"){ ?>checked='checked'<?php } ?> type="radio" name="dokoncen" value="ano" /> Ano <input class = 'auto' <?php if($dokoncen == "ne"){ ?>checked='checked'<?php } ?> type="radio" name="dokoncen" value="ne" /> Ne</td></tr>

<tr><td colspan = '2'><input class='formbutton' id='tlacitko' type = 'submit' value = 'Uložit článek' /></td></tr>

</table>

</form>

