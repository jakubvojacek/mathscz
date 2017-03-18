<table width="500" border="1">
    <tr><td>Otázka</td><td>Počet hlášení</td><td>Akce</td></tr>
<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$q = mysql_query("select count(*) as pocet, otazka from chyby group by otazka order by pocet desc");
while ($v = mysql_fetch_array($q)){
    ?>
    <tr>
        <td><a href="index.php?akce=nahled&id=<?php echo $v["otazka"]; ?>">Náhled [<?php echo $v["otazka"]; ?>]</a></td><td><?php echo $v["pocet"]; ?></td>
        <td><a href="smazat.php?chyba=<?php echo $v["otazka"]; ?>">Smazat hlášení</a></td>
    </tr>
    <?php
}

?>
</table>