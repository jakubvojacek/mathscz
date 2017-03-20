<?php
class Test extends Funkce{
    
    function show(){
        $otazka = $_GET["otazka"];
        $do = $_GET["do"];
        $kat = $_GET["kat"];
        
        $this->ukaz_otazku();
        if (IsSet($_POST["otazka"])){
            $this->oprav();
            }
        else{
           
            $_SESSION["otazky"] = array();
            $_SESSION["pocet"] = 0;
            $_SESSION["spatne"] = 0;
            }
        if ($otazka == $do+1){
            include("vysledky.php");
            return;
            }
        }
    
    function ukaz_otazku(){
        $otazka = $_GET["otazka"];
        $do = $_GET["do"];
        $kat = $_GET["kat"];
        $razeni = $_GET["razeni"];
        $q = $this->make_cat_select($kat);
        $radit_podle = "id";
        if ($razeni == 1){
            $radit_podle="spatne DESC";
            }
        elseif($razeni == 2){
            $radit_podle="celkem-spatne, celkem";
            }
        $q = mysqli_query(DATABASE::getDb(), "select * from otazky where kontrola = '1' and $q order by $radit_podle limit $otazka, 1");
        $v = mysqli_fetch_array($q);
        ?>

        <div style="padding-bottom: 13px; "><?php $this->strom_kategorii($v["kategorie"]); ?></div>
       
        <p><span class="otazka"><?php echo $this->znacky($v["otazka"]); ?></span></p>
        <form method ="post" action="index.php?akce=test&razeni=<?php echo $razeni; ?>&otazka=<?php echo $otazka+1; ?>&kat=<?php echo $kat; ?>&do=<?php echo $do; ?>">
            <?php $this->otazka_detail($v); ?>
        </form>
        <?php
        }
    }

$test = new Test();
$test->show();
?>
