<?php

Header('Content-type: text/html; charset=utf-8');

include("./funkce/pripojeni.php");

 

?>



<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">

<channel>



    <title>Komentáře :: <?php echo titulek;?></title>

    <link><?php echo url_webu;?></link>

    

	<description><?php echo popis_webu;?></description>

    <language>cs</language>

    <copyright><?php echo copyright;?></copyright>

<?php 



$vysledek = mysqli_query(DATABASE::getDb(), "select *, komentare.autor as autor_komentare, komentare.text as text_komentare, clanky.link as link_clanku from komentare left join clanky on clanky.id=komentare.clanek ORDER BY komentare.id DESC LIMIT 10") or die(mysql_error());





while ($v = mysqli_fetch_array($vysledek) ){    

    //$v2 = mysqli_query(DATABASE::getDb(), "select id from clanky where id = '.$v["clanek"].'");

  

    ?>

    <item>

        <title><?php echo $v["predmet"];?></title>

        <link><?php echo url_webu."clanky/".$v["link_clanku"]."#komentar-".$v["id"];?></link>

        <guid isPermaLink="true"><?php echo url_webu."clanky/".$v["link_clanku"]."#komentar-".$v["id"];?></guid>

        <description><?php echo $v["text_komentare"];?></description>

        <author><?php echo $v["autor_komentare"];?></author>

    </item>

    <?php

    }

?>

</channel>

</rss>

