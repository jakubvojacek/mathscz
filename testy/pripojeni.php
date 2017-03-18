<?php
//header('Content-Type:text/html; charset=UTF-8');
function uka_kat($nadrazena, $odsazeni, $select){
    $q = mysql_query("select * from kategorie_otazky where nadrazena = '$nadrazena' order by jmeno");
    if (mysql_num_rows($q) == 0){
        return;
        }
    while ($v = mysql_fetch_array($q)){
        ?><option <?php if ($select == $v["id"]){echo "selected='selected'"; }?> value = '<?php echo $v["id"]; ?>'>
        <?php
        $i = 0;
        while ($i != $odsazeni){
            ?>&nbsp;<?php
            $i++;
            }
        echo "- ".$v["jmeno"];
        ?>
        </option>
        <?php
        uka_kat($v["id"], $odsazeni+5, $select);
        }
    }

function kategorie_select($select){
    ?><select name = 'kat'><?php
    uka_kat(-1, 0, $select);    
    ?></select><?php
    }

$link = mysql_connect('localhost', 'maths.cz', 'Kar4P4JvdwqeeYEC');
mysql_select_db('maths.cz', $link) or die(mysql_error());
/*$q = mysql_query("select * from otazky");
while ($v = mysql_fetch_array($q)){
    $otazka = $v["otazka"];
    $kategorie = $v["kategorie"];
 
    echo "insert into otazky(otazka, kategorie) values('$otazka', '$kategorie');<br />";

    }*/
mysql_query("SET NAMES UTF8");



$q = mysql_query("select * from nastaveni_otazky where id = '1'");
$v = mysql_fetch_array($q);
define("REKLAMA", $v["reklama"]);
define("ZOBRAZIT_REKLAMU", $v["zobrazit_reklamu"]);


/*mysql_query('create table otazky(
    otazka varchar(1000),
    id int not null auto_increment primary key
    );');
    
  
create table odpovedi(
    otazka int,
    odpoved varchar(1000),
    spravne int,
    id int not null auto_increment primary key
    )  
    
create table kategorie(
    jmeno varchar(100),
    nadrazena int,
    
    id int not null auto_increment primary key
    );

create table uzivatele(
    nick varchar(100),
    jmeno varchar(100),
    email varchar(100),
    heslo varchar(100),
    id int not null auto_increment primary key
    )

create table vysledky(
   uzivatel mediumint unsigned,
   otazka mediumint unsigned,
   cas datetime,
   spravne tinyint,
   id mediumint unsigned not null auto_increment primary key
   )

create table pripominky(
 cas datetime,
 predmet varchar(100),
 text varchar(1000),
 id int not null auto_increment primary key
 )

 CREATE TABLE nastaveni_otazky(
reklama VARCHAR( 1000 ) ,
zobrazit_reklamu TINYINT DEFAULT  '0',
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY
)

*/    
    
?>
