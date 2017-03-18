<?php
include("./kontrola.php");
?>
<fieldset>
    <legend>[ Nový obrázek ]
    </legend>
    
    <form enctype='multipart/form-data' method = 'post' action = 'nahrat-obrazek.php'>
       <table>
        <tr><td width = '70'>Popis: </td><td><input type='text' name = 'popis' maxlength = '100' /></td></tr>
        <tr><td colspan='2'><input type='file' name = 'soubor' /></td></tr>
        <tr><td colspan='2'><input class='formbutton' type = 'submit' value = 'Nahrát obrázek' /></td></tr>
        </table>
    </form>
    
</fieldset>
<fieldset>
    <legend>[ Obrázky ]
    </legend>
<?php
$vypis = mysql_query("select id from obrazky");
$pocet_obrazku = mysql_num_rows($vypis);
$strana = 1;
if (IsSet($_GET["strana"])){
    $strana = $_GET["strana"];
    }
$pocatek = $strana*5-5;
$vypis = mysql_query("select * from obrazky order by id desc limit $pocatek, 5");
while ($v = mysql_fetch_array($vypis)){
    $jmeno = basename($v["cesta"]);
    $thumb = "../obrazky/_$jmeno";
    ?>    
    <div class = 'ram-obrazek'>    
        <table border = '1'>    
            <tr>
                <td rowspan='2' width='100px;'>
                    <img alt='' src='<?php echo $thumb; ?>' /></td><td><strong>Jméno: </strong>
                    <?php echo $v["jmeno"] ?></td>
            </tr>       
            <tr><td style = 'vertical-align: top;'>
                    <input style = 'width: 100%; ' type='text' value = '<obrazek id = "<?php echo $v["id"]; ?>" nahled = "ne" zarovnani = "nastred" />" />' /></td>
            </tr>    
        </table>    
    </div>    
    <?php
    }
    ?>   
</fieldset>
<div class='na-stred'>
<?php 
$pocet_stran = ceil($pocet_obrazku/5);
$nasledujici = $strana + 1;
$predchozi = $strana - 1;
if ($strana != 1){
        ?>    
    <a href='index.php?akce=obrazky&strana=<?php echo $predchozi;?>'>
        <img src='images/pages_left_out.gif' class='pages_left' onmouseover="this.src='images/pages_left_over.gif'" onmouseout="this.src='images/pages_left_out.gif'" alt='' /></a>    
<?php
    }
    ?>
    <img src='images/pages_center.gif' class='pages_center' alt='' />
<?php 
if ($strana != $pocet_stran and $pocet_stran){
        ?>               
    <a href='index.php?akce=obrazky&strana=<?php echo $nasledujici;?>'>
        <img src='images/pages_right_out.gif' class='pages_right' onmouseover="this.src='images/pages_right_over.gif'" onmouseout="this.src='images/pages_right_out.gif'" alt='' /></a>    
<?php
    }
    ?>
</div>