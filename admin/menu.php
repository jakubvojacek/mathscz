                                            
 
<?php
$menu = array(array("", "Hlavní strana", 0),
            array("clanky", "Články", 0),
            array("priklady", "Příklady", 0),
            array("obrazky", "Obrázky", 0),
            array("testy", "Testy", 0),
            array("hlavolamy", "Hlavolamy", 0),
            array("kategorie", "Kategorie", 1),
            array("nastaveni", "Nastavení", 1),
            
            );
if ($je_prihlasen == 1 and skupina != 3){
    $akce = "";
    if (IsSet($_GET["akce"])){
        $akce = $_GET["akce"];
        }
    for($i = 0; $i < count($menu); $i++){
        if ($menu[$i][2] == 1 and skupina != 0){
            continue;
            }    
        ?><li <?php if ($menu[$i][0] == $akce){echo "class = 'current' ";}?> ><a href="index.php?akce=<?php echo $menu[$i][0]; ?>"><span><?php echo $menu[$i][1]; ?></span></a></li><?php
        }    
    }
?>
<li><a href="odhlas.php"><span>Odhlásit</span></a></li>