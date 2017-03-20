<?php



class Profil extends Funkce{
    function show(){
        if (($this->id_uzivatele = $this->je_prihlasen()) == -1){
            ?><p>Musíte se přihlásit</p><?php
            return;
            }
        //$this->id_uzivatele = $this->je_prihlasen();
        
        $q = mysqli_query(DATABASE::getDb(), "select sum(spatne) as spatne, sum(spravne) as spravne from vysledky where uzivatel='$this->id_uzivatele'");
        $v = mysqli_fetch_array($q);
        $this->ukaz_pomer_spravne_spatne($v);
        ?>
            <ul style="list-style: none; margin-left: 5px;">
                <li><strong>Uživatelské jméno: </strong><?php echo $this->uzivatelske_jmeno(); ?></li>
                <li><strong>Email: </strong><?php echo $this->email(); ?></li>
                <li><strong>Zodpovězených otázek: </strong><?php echo $v["spravne"]+$v["spatne"]; ?></li>
                <li><strong>Správných odpovědí: </strong><?php echo $v["spravne"]; ?></li>
                <li><strong>Špatných odpovědí: </strong><?php echo $v["spatne"]; ?></li>
            </ul>
        <?php
        }
    function uzivatelske_jmeno(){
        $q = mysqli_query(DATABASE::getDb(), "select nick from uzivatele where id='$this->id_uzivatele'");
        $v = mysqli_fetch_array($q);
        return $v["nick"];
        }
    function email(){
        $q = mysqli_query(DATABASE::getDb(), "select email from uzivatele where id='$this->id_uzivatele'");
        $v = mysqli_fetch_array($q);
        return $v["email"];
        }

    function ukaz_pomer_spravne_spatne($v){
       
        if ($v["spatne"] + $v["spravne"] == 0){
            return;
            }
        $chart = "http://chart.apis.google.com/chart?chco=46a3fc&cht=p3&chs=250x100&chd=t:".round($v["spatne"]/($v["spatne"] + $v["spravne"])*100).",".round($v["spravne"]/($v["spatne"] + $v["spravne"])*100)."&chl=Špatně|Správně";
        ?><div style=" display: inline; float: right; width:270px;"><fieldset><legend>[ Poměr špatných / správných odpovědí ]</legend><img src="<?php echo $chart; ?>" /></fieldset></div><?php

        }

    }

$profil = new Profil();
$profil->show();

?>
