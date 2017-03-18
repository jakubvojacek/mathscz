<?php
include("../funkce.php");
class Nahled extends Funkce{
    function show(){
        ?><p><a href="<?php echo $_SERVER["HTTP_REFERER"]; ?>">Zpět na předchozí stránku</a>
             <a href="index.php?akce=editace-otazky&id=<?php echo $_GET["id"]; ?>">Editovat otázku</a>
             </p>
        <?php
        $id = $_GET["id"];
        $q = mysql_query("select * from otazky where id = '$id'");
        $v = mysql_fetch_array($q);
        $this->zobrazit_reseni_otazky($v);
        ?>
             <p><strong>Řešení: </strong><?php echo $this->znacky($v["reseni"]); ?></p>
        <?php
        }

    }

$show = new Nahled();
$show->show();
?>
