<?php
//header('Content-Type:text/html; charset=UTF-8');
function uka_kat($nadrazena, $odsazeni, $select){
    $q = mysqli_query(DATABASE::getDb(), "select * from kategorie_otazky where nadrazena = '$nadrazena' order by jmeno");
    if (mysqli_num_rows($q) == 0){
        return;
        }
    while ($v = mysqli_fetch_array($q)){
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

define("DB_HOST",'localhost');
define("DB_USERNAME",'maths.cz');
define("DB_PSW",'Kar4P4JvdwqeeYEC');
define("DB_NAME", 'maths.cz');
define("domain", '.maths.cz');

class DATABASE
{
    public static function getDb()
    {
        $connection = mysqli_connect(DB_HOST, DB_USERNAME, DB_PSW);
        $db = mysqli_select_db($connection, DB_NAME);
        mysqli_query($connection, "SET NAMES UTF8");
        return $connection;
    }
}


/*$q = mysqli_query(DATABASE::getDb(), "select * from otazky");
while ($v = mysqli_fetch_array($q)){
    $otazka = $v["otazka"];
    $kategorie = $v["kategorie"];
 
    echo "insert into otazky(otazka, kategorie) values('$otazka', '$kategorie');<br />";

    }*/
mysqli_query(DATABASE::getDb(), "SET NAMES UTF8");



$q = mysqli_query(DATABASE::getDb(), "select * from nastaveni_otazky where id = '1'");
$v = mysqli_fetch_array($q);
define("REKLAMA", $v["reklama"]);
define("ZOBRAZIT_REKLAMU", $v["zobrazit_reklamu"]);


/*mysqli_query(DATABASE::getDb(), 'create table otazky(
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
