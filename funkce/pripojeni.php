
<?php




/*
test, uzivatel, znamka
create table vysledky(
    test mediumint unsigned,
    uzivatel mediumint unsigned,
    znamka smallint unsigned,
    id mediumint unsigned not null auto_increment primary key
);
ALTER TABLE  `komentare` CHANGE  `link`  `id_autora` INT( 11 ) NULL DEFAULT NULL
ALTER TABLE  `clanky` CHANGE  `dokoncen`  `dokoncen` ENUM(  'ano',  'ne' ) NOT NULL DEFAULT  'ne'
ALTER TABLE  `clanky` CHANGE  `datum2`  `datum` DATETIME NOT NULL
ALTER TABLE  `clanky` CHANGE  `pocet`  `pocet_precteni` INT( 11 ) NOT NULL DEFAULT  '0'

create table nastaveni(
    klicova_slova varchar(1000) default '',
    popis_webu varchar(1000) default '',
    nazev_webu varchar(1000) default '',
    url_webu varchar(1000) default '',
    reklama varchar(1000) default '',
    id smallint unsigned not null auto_increment primary key
    );
insert into nastaveni() values();   


*/

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



$v = mysqli_query(DATABASE::getDb(), "select * from nastaveni where id = '1'");
$v = mysqli_fetch_array($v);
define("klicova_slova", $v["klicova_slova"]);
define("popis_webu", $v["popis_webu"]);
define("titulek", $v["nazev_webu"]);
define("url_webu", $v["url_webu"]);
define("reklama", $v["reklama"]);


?>
