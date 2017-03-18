<?php



$s=$_SERVER["SERVER_NAME"];


      $connect=mysql_connect("localhost","maths.cz","Kar4P4JvdwqeeYEC");

      $db=mysql_select_db("maths.cz",$connect) or die('Nepodaøilo se pøipojit k databázi');

      mysql_query("SET NAMES UTF8");

      $base="http://maths.cz/";




if (IsSet($_GET["id"])){

    $id = $_GET["id"];

    

    $vypis = mysql_query("select obr from tex where id = '$id'") or die(mysql_error());

    $vypis = mysql_fetch_array($vypis)or die(mysql_error());

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



