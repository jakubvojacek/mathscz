
<?php
class NahodnyTest extends Funkce{

    function show(){
    
      

        $kat = $_GET["kat"];
        if (!IsSet($_POST["otazka"])){
            $_SESSION["otazky"] = array();
            $_SESSION["pocet"] = 0;
            $_SESSION["spatne"] = 0;
            
            
            }
        
            
        $this->ukaz_otazku();
        if (IsSet($_POST["otazka"])){
            $this->oprav();
            }
        }
    function get_rand($kat){
        $q = $this->make_cat_select($kat);
        $q = mysql_query("select * from otazky where kontrola = '1' and $q order by RAND() limit 1");
        $v = mysql_fetch_array($q);
        return $v["id"];
        }
    function ukaz_otazku(){
        $kat = $_GET["kat"];
        if (!IsSet($_GET["otazka"])){
            $otazka = $this->get_rand($kat);
            }
        else{
            $otazka = $_GET["otazka"];
            }
        
        
        $q = mysql_query("select * from otazky where id = '$otazka'");
        $v = mysql_fetch_array($q);

        ?>
        <div style="padding-bottom: 13px; "><?php $this->strom_kategorii($v["kategorie"]); ?></div>
        <p><span class="otazka"><?php echo $this->znacky($v["otazka"]); ?></span></p>
        <form method ="post" action="index.php?akce=nahodny-test&otazka=<?php echo $this->get_rand($kat); ?>&kat=<?php echo $kat; ?>">
            <?php $this->otazka_detail($v); ?>
        </form>
        <?php
        }
    
    }

$test = new NahodnyTest();
$test->show();
?>
