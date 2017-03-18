<?php
Header('Content-type: text/html; charset=utf-8');


include("./funkce/pripojeni.php");

?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
<channel>

    <title><?php echo titulek;?></title>
    <link><?php echo url_webu;?></link>
    
	<description><?php echo popis_webu;?></description>
    <language>cs</language>
    <copyright><?php echo copyright;?></copyright>
<?php 

$vysledek = mysql_query("select *, clanky.link as link_clanku, uzivatele.nick as jmeno_autora from clanky left join uzivatele on uzivatele.id=clanky.autor where dokoncen = 'ano' ORDER BY clanky.datum DESC LIMIT 10") or die(mysql_error());


while ($v = mysql_fetch_array($vysledek) ){
    ?>
    <item>
        <title><?php echo $v["jmeno"];?></title>
        <link><?php echo url_webu."clanky/".$v["link_clanku"]; ?></link>
        <description><?php echo $v["uvod"];?></description>
        <guid isPermaLink="true"><?php echo url_webu."clanky/".$v["link_clanku"]; ?></guid>
        <author><?php echo $v["jmeno_autora"];?></author>
    </item>
    <?php
    }
?>
</channel>
</rss>
