<?php

Header('Content-type: text/html; charset=utf-8');

include("../funkce/pripojeni.php");

include("../funkce/funkce.php");

include("./kontrola.php");

je_prihlasen();

@session_start();                

$jmeno = $_POST["jmeno"];

$seo_url = seo_url($jmeno).".html";

$id = $_POST["id"];

//

$v = mysqli_query(DATABASE::getDb(), "select id from clanky where link = '$seo_url' and id != '$id'") or die(mysql_error());

if (mysqli_num_rows($v) != 0){

    $_SESSION["zprava"] = array(0, "Takové jméno článku v databázi již existuje, vyberte prosím jiné"); 

    $povolit_editaci = 1;

    }

else{

    $povilit_editaci = 0;

    }

//die ("dd".mysqli_num_rows($v)."dd".$id);

//



$uvod = $_POST["uvod"];

$text = $_POST["text"];

$kategorie = $_POST["kategorie"];

$autor = $_POST["autor"];



$dokoncen = $_POST["dokoncen"];

$testy = $_POST["testy"];

$klicova_slova = $_POST["klicova_slova"];

$href="index.php?akce=edit_cl&id=$id";



if (id_uzivatele != $autor and skupina != 1){

    $_SESSION["zprava"] = array(0, "Nemáte právo pro editaci tohoto článku");

    Header("Location: index.php?akce=clanky");    

    return;

    }





if ($id == -1){

    mysqli_query(DATABASE::getDb(), "insert into clanky(povolit_editaci_jmena, link, klicova_slova, testy, jmeno, uvod, text, autor, kategorie, pocet_precteni, dokoncen, datum) values('$povolit_editaci', '$seo_url', '$klicova_slova', '$testy', '$jmeno', '$uvod','$text','$autor','$kategorie','0','$dokoncen', current_timestamp())") or die(mysql_error()); 

    }

else{

mysqli_query(DATABASE::getDb(), "update clanky set povolit_editaci_jmena = '$povolit_editaci', link = '$seo_url', klicova_slova='$klicova_slova', jmeno='$jmeno', uvod='$uvod', text='$text', autor='$autor', kategorie='$kategorie', dokoncen='$dokoncen', testy = '$testy' where id = '$id'") or die(mysql_error());

    }

 

include("./kontrola-tagu.php");

    

Header("Location: index.php?akce=clanky");    



?>

