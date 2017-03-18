<?php
include("../pripojeni.php");

class Smaz{
    function smaz_otazku($id){
        mysql_query("delete from vysledky where otazka='$id'") or die(mysql_error());
        mysql_query("delete from odpovedi where otazka='$id'") or die(mysql_error());
        mysql_query("delete from otazky where id = '$id'") or die(mysql_error());
        Header("Location: index.php?akce=otazky");
        }
    function smaz_chybu($otazka){
        mysql_query("delete from chyby where otazka='$otazka'");
        Header("Location: index.php?akce=chyby");
    }
    function smaz(){
        if (IsSet($_GET["otazka"])){
            $this->smaz_otazku($_GET["otazka"]);
            }
        elseif (IsSet($_GET["chyba"])){
            $this->smaz_chybu($_GET["chyba"]);
            }
        }

    }
if (!IsSet($_GET["potvrzeni"])){
    $uri = $_SERVER["QUERY_STRING"]."&potvrzeni=1";
    ?><p>Chcete daný záznam opravdu smazat? </p>
    <span style="float: left;"><a href="<?php echo $_SERVER["HTTP_REFERER"]; ?>">Ne</a></span>
    <span style="float: right;"><a href="smazat.php?<?php echo $uri; ?>">Ano</a></span>
    <?php
    }
else{

    $smaz = new Smaz();
    $smaz->smaz();
    }

?>
