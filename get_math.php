<?php


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

$s=$_SERVER["SERVER_NAME"];



      $db=mysql_select_db("maths.cz",$connect) or die('Nepodaøilo se pøipojit k databázi');

      mysqli_query(DATABASE::getDb(), "SET NAMES UTF8");

      $base="http://maths.cz/";




if (IsSet($_GET["id"])){

    $id = $_GET["id"];

    

    $vypis = mysqli_query(DATABASE::getDb(), "select obr from tex where id = '$id'") or die(mysql_error());

    $vypis = mysqli_fetch_array($vypis)or die(mysql_error());

    $img = $vypis["obr"];

    

    //$img= file_get_contents("http://www.matweb.cz/cgi-bin/mimetex.cgi?x=0");



    //$img = base64_encode($img);



    

    $img = base64_decode($img);

    header('Content-type: image/gif');

    header('Content-Lenght: '. strlen($img));

    echo $img;

    flush();

    }

exit();

?>



