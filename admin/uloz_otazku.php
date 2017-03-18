<?php
Header('Content-type: text/html; charset=utf-8');
include("../funkce/pripojeni.php");
include("kontrola.php");
$a = $_POST["a_"];
$b = $_POST["b_"];
$c = $_POST["c_"];
$d = $_POST["d_"];
$otazka = $_POST["otazka_"];
$typ = $_POST["typ_"];
$spravne = $_POST["spravne_"];
$id = $_POST["id_"];
$test = $_POST["test_"];
if ($id == -1){
    mysql_query("insert into otazky(a,b,c,d,spravne,otazka,test, typ) values('$a', '$b', '$c', '$d', '$spravne', '$otazka', '$test','$typ')") or die(mysql_error());
    }
else{
    mysql_query("update otazky set a='$a', b='$b', c='$c', d='$d', otazka='$otazka', spravne='$spravne', test='$test', typ='$typ' where id = '$id'") or die(mysql_error());
    }
Header("Location: index.php?akce=testy&test=$test");
?>

