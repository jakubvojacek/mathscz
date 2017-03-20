
<?php

function zobraz_autora($id){
    $vypis=mysqli_query(DATABASE::getDb(), "select 
                            uzivatele.jmeno as jmeno,
                            uzivatele.nick as username,
                            uzivatele.email as email,
                            uzivatele.id as id_autora,
                            uzivatele.typ as skupina,
                            count(komentare.id) as pocet_komentaru
                             
                            from uzivatele
                           
                            LEFT JOIN komentare ON uzivatele.id = komentare.id_autora
                            where uzivatele.link = '$id'
                            group by uzivatele.link
                            
                            ") or die(mysql_error());   
    $v = mysqli_fetch_array($vypis); 
    $v2=mysqli_fetch_array(mysqli_query(DATABASE::getDb(), "select count(*) as pocet from clanky where autor = '".$v["id_autora"]."' and dokoncen = 'ano'"));
    $v["pocet_clanku"] = $v2["pocet"];
    $id_autora = $v["id_autora"];
    ?>
    <table>
    <tr><td width = '175px'><strong>Uživatelské jméno: </strong></td><td><?php echo $v["username"]; ?></td></tr>
    <tr><td width = '175px'><strong>Jméno: </strong></td><td><?php echo $v["jmeno"]; ?></td></tr>
    <tr><td><strong>E-mail: </strong></td><td><?php echo $v["email"]; ?></td></tr>
    <tr><td style='width: 150px;'><strong>Počet článků: </strong></td><td><?php echo $v["pocet_clanku"]; ?></td></tr>
        
    <tr><td><strong>Počet komentářů: </strong></td><td><?php echo $v["pocet_komentaru"]; ?></td></tr>
    </table>
    <h2>Nejčtenější články autora:</h2>
    <?php
    $vypis=mysqli_query(DATABASE::getDb(), "select * from clanky where autor = '$id_autora' and dokoncen = 'ano' order by pocet_precteni desc limit 5") or die(mysql_error());
    ?><ol><?php
    while($vysledek = mysqli_fetch_array($vypis)){
        ?><li><a href='clanky/<?php echo $vysledek["link"]; ?>'><?php echo $vysledek["jmeno"]; ?></a>
         | <?php echo $vysledek["pocet_precteni"]; ?></li>
        <?php
        }
    
    ?></ol><?php
    ?><h2>Všechny články autora (<?php echo $v["pocet_clanku"]; ?>):</h2><?php
    $vypis=mysqli_query(DATABASE::getDb(), "select * from clanky where autor = '$id_autora' and dokoncen = 'ano' order by id desc") or die(mysql_error());
    ?><ul><?php
    while($vysledek = mysqli_fetch_array($vypis)){
        ?><li><a href='clanky/<?php echo $vysledek["link"]; ?>'><?php echo $vysledek["jmeno"]; ?></a>
         | <?php echo $vysledek["pocet_precteni"]; ?></li>
        <?php
        }
    ?></ul><?php
    
    
    }

function zobraz_vsechny(){
    $vypis=mysqli_query(DATABASE::getDb(), "select * from uzivatele where typ = '0' or typ = '1' order by nick") or die(mysql_error());
    ?>
    <img src="images/redakce.gif" class="redakce" alt="" /><br />
    <div id="borderarround">
    <br />
    <table class="membertable" cellpadding="0" cellspacing="0">
    <?php    
    while ($vysledek=mysqli_fetch_array($vypis)){ 
        $jmeno=$vysledek["nick"];
        $popis=$vysledek["popis"];
        //$icq=$vysledek["icq"];
        $email=str_replace("@","(zav)",$vysledek["email"]);
        $id=$vysledek["id"];
        $pozice=$vysledek["typ"];
        if ($email == ""){
            $email="---";
            }
        $casti = explode(" ", $jmeno); 
        ?>
        <tr>
        <td width='150'><?php echo $casti[0]; ?></td>
        <?php
        if (IsSet($casti[1])){
            ?><td width='150'><?php echo $casti[1]; ?></td><?php
            }
        else{
            ?><td width='150'>---</td><?php
            }
        ?><td width='150'><?php echo $email; ?></td>
        <td width='150'>&laquo; <a href='redaktor/<?php echo $vysledek["link"]; ?>'>více informací</a> &raquo;</td>
        </tr>
        <?php          
        }
    ?>
    </table>
    <br />
    </div>
    <?php  
    }
if (IsSet($_GET["autor"])){
    zobraz_autora($_GET["autor"]);
    }
else{
    zobraz_vsechny();
    }

?>

