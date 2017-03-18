<?php


$zobrazit_reklamu = 0;
function vypis_nastaveni_uctu($id){
    ?><span style='text-decoration: underline;'>Nastavení vašeho účtu</span>:
    <table><form method = 'post' action = ''><?php
    $vypis = mysql_query("select * from pun_users where id = $id") or die(mysql_error());
    $v = mysql_fetch_array($vypis);
    $jmeno = $v["jmeno"];
    $heslo = $v["heslo"];
    $vek = $v["vek"];
    $email = $v["email"];
    $web = $v["web"];
    $icq = $v["icq"];
    $popis = $v["popis"];
    $povolani = $v["povolani"];
    ?>
    <table>
    <form method = 'post'>
    <tr><td>Uživatelské jméno: </td><td><?php echo $v["username"]; ?></td></tr>
    <tr><td>E-mail: </td><td><input type='text' name='email' value='<?php echo $v["email"]; ?>' /></td></tr>
    <tr><td>Jméno: </td><td><input type='text' name='realname' value='<?php echo $v["realname"]; ?>' /></td></tr>
    <tr><td>Bydliště: </td><td><input type='text' name='location' value='<?php echo $v["location"]; ?>' /></td></tr>
    <tr><td>Web: </td><td><input type='text' name='url' value='<?php echo $v["url"]; ?>' /></td></tr>
    <tr><td>Jabber: </td><td><input type='text' name='jabber' value='<?php echo $v["jabber"]; ?>' /></td></tr>
    <tr><td>ICQ: </td><td><input type='text' name='icq' value='<?php echo $v["icq"]; ?>' /></td></tr>
    <tr><td>MSN Messenger: </td><td><input type='text' name='msn' value='<?php echo $v["msn"]; ?>' /></td></tr>
    <tr><td>AOL IM: </td><td><input type='text' name='aim' value='<?php echo $v["aim"]; ?>' /></td></tr>
    <tr><td>Yahoo! Messenger: </td><td><input type='text' name='yahoo' value='<?php echo $v["yahoo"]; ?>' /></td></tr>
   
   
    
    <?php
    echo "</form>";
    echo "</table>";
    echo "<p><sup>*</sup>Položky označené hvězdičkou jsou povinné. </p>";
    echo "<p><sup>**</sup>Pokud nechcete měnit heslo, nechte toto pole prázdné.</p>";

    echo "</form></table>";
    }
function vypis_testy($uzivatel){
    $vypis = mysql_query("select * from vysledky where uzivatel = '$uzivatel' order by znamka desc");
    $pocet = mysql_num_rows($vypis);
    if ($pocet == 0){
        ?><p>Zatím jste nezkoušel vyplnit žádné testy. </p>
        <p>Můžete to <a href='akce/zkouseni'>vyzkoušet</a>!</p>
        <?php
        return;
        }
    ?><p>Vyzkoušejte další <a href='akce/zkouseni'>testy</a>!</p>";
    <table class = 'tabulka' style = 'width: 100%;' width = '100%'>
    <tr style='font-weight: bold;'><td>Test</td><td>Úspěšnost (%)</td></tr>
    <?php
    while ($vysledek = mysql_fetch_array($vypis)){
        $vypis2 = mysql_query("select jmeno, link from testy where id = '".$vysledek["test"]."'");
        $vysledek2 = mysql_fetch_array($vypis2);
        echo "<tr><td><a href='testy/".$vysledek2["link"]."'>".$vysledek2["jmeno"]."</a></td><td>".$vysledek["znamka"]."</td></tr>";
        }
    
    ?></table><?php
    
    }

function vypis_komentare($uzivatel){
    $vypis = mysql_query("select predmet, clanek, id, datum from komentare where link = '$uzivatel' order by id desc");
    if (mysql_num_rows($vypis) == 0){
        ?><p>Zatím jste žádné komentáře nepřidal.</p><?php
        return;
        }
    ?><table class = 'tabulka' style = 'width: 100%;' width = '100%'><?php
    echo "<tr style='font-weight: bold;'><td>Předmět komentáře</td><td>Článek</td><td>Datum</td></tr>";
    while ($vysledek = mysql_fetch_array($vypis)){
        $vypis2 = mysql_query("select jmeno, link from clanky where id = '".$vysledek["clanek"]."'");
        $vysledek2 = mysql_fetch_array($vypis2);
        echo "<tr><td><a href='clanky/".$vysledek2["link"]."#komentar-".$vysledek["id"]."'>".$vysledek["predmet"]."</a></td>";
        echo "<td><a href='clanky/".$vysledek2["link"]."'>".$vysledek2["jmeno"]."</a></td>";
        ?><td><?php echo $vysledek["datum"]; ?></td></tr><?php
        }
    ?></table><?php
    }

function vypis_rss(){
    echo "<p>Tento portál můžete sledovat i pomocí RSS (<a href='http://cs.wikipedia.org/wiki/Rss'>co je RSS?</a>)</p>";
    echo '<img src="images/feed.png" alr="" /> <a href="rss.php">RSS nových článků</a>
    <br />
    <img src="images/feed.png" alr="" /> <a href="rss_komentare.php">RSS nových komentářů</a>
    <br />
    <img src="images/feed.png" alr="" /> <a href="rss_testy.php">RSS nových testů</a>
    <br />
    ';
    }
function odhlas(){
    setcookie("id_uzivatel", "", time()-600, '/');
    setcookie("heslo_uzivatel", "", time()-600, '/');
    @session_start();
    $_SESSION["zprava"] = "Odhlášení bylo úspěšné";
    Header("Location: akce/prihlasit");
    }

/*
create table vysledky(
uzivatel int,
test int,
znamka int,
datum datetime, 
id int not null auto_increment,
primary key(id));
)
*/





    //header("Connection: close");
   
function layout(){
    if (je_prihlasen == 0){
        ?><p>Pro editaci osobního nastavení se musíte nejprve <a href='akce/prihlaseni'>přihlásit</a></p><?php
        return;
        }
    $sekce = 1;
    if ($_GET["sekce"] != "" or $_GET["sekce"] != 0){
        $ar=array("testy" => 2, "komentare" => 3, "rss" => 4, "odhlasit" => 5);
        $sekce = $ar[substr($_GET["sekce"], 1)];
        }
    echo '<table>
    <tr><td style="vertical-align: top; padding-right: 20px; border-right: 3px solid#2e7fa6">
    <img src="images/wrench.png" alr="" /> <a href="nastaveni">Nastavení účtu</a>
    <br />
    <img src="images/testy.png" alr="" /> <a href="nastaveni/testy">Testy</a>
    <br />
    <img src="images/comments.png" alr="" /> <a href="nastaveni/komentare">Vaše komentáře</a>
    <br />
    <img src="images/feed.png" alr="" /> <a href="nastaveni/rss">RSS</a>
    <br />
    <img src="images/cancel.png" alr="" /> <a href="odhlasit.php">Odhlásit se</a>
    </td>
    <td style="vertical-align: top; padding-left: 15px;">';
    if ($sekce == 1){vypis_nastaveni_uctu(id_uzivatele);}
    elseif ($sekce == 2){vypis_testy(id_uzivatele);}
    elseif ($sekce == 3){vypis_komentare(id_uzivatele);}
    elseif ($sekce == 4){vypis_rss();}
    elseif ($sekce == 5){odhlas();}
    
    echo '</td></tr>
    </table>
    <br /><br />';
    }
layout();
?>
