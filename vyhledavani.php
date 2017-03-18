<?php
$hledej = "";
if (IsSet($_GET["q"])){
    $hledej=$_GET["q"];
    }
?>
<h2>Hledaný výraz: "<?php echo $hledej; ?>":</h2>
<p>Hledání probíhá pouze v článcích. Prohledávaný je pouze nadpis, perex a text článku.</p>
<fieldset><legend>[ Nové hledání ]</legend>
<form action = 'index.php' method = 'get'>
<input type = 'hidden' name = 'akce' value = 'vyhledavani' />
<table width = '100%'>
<tr><td width = '125px'>Hledaný výraz: </td><td><input type = 'text' name = 'q' value = '<?php echo $hledej; ?>' style='width:100%;' /></td></tr>
<tr><td colspan = '2'><input type = 'submit' value = 'Hledat' /></td></tr>

</table>
</form>
</fieldset>

<?php
$vypis = "
        SELECT   clanky.jmeno as jmeno_clanku, 
                 clanky.uvod as uvod_clanku, 
                 clanky.id as id_clanku,    
                 clanky.text as text_clanku,
                 clanky.datum as datum_clanku, 
                 clanky.link as link,
                 clanky.klicova_slova as klicova_slova,
                 count(komentare.id) as pocet_komentaru,
                 uzivatele.nick as jmeno_autora,
                 uzivatele.link as link_autora,
                 kategorie.jmeno as jmeno_kategorie,
                 kategorie.link as link_kategorie
                 from clanky 
                 LEFT JOIN komentare ON clanky.id = komentare.clanek
                 LEFT JOIN uzivatele ON clanky.autor = uzivatele.id
                 LEFT JOIN kategorie ON clanky.kategorie = kategorie.id
        
        
          WHERE dokoncen = 'ano'
          group by clanky.datum 
        AND (MATCH(klicova_slova) AGAINST ('$hledej' IN BOOLEAN MODE) 
        OR MATCH(clanky.jmeno) AGAINST ('$hledej' IN BOOLEAN MODE) 
        OR MATCH(clanky.uvod) AGAINST ('$hledej' IN BOOLEAN MODE) 
        OR MATCH(clanky.text) AGAINST ('$hledej' IN BOOLEAN MODE)) 
        ORDER BY 20*MATCH(klicova_slova) AGAINST ('$hledej' IN BOOLEAN MODE) + 10*MATCH(jmeno_clanku) AGAINST ('$hledej' IN BOOLEAN MODE) 
        + 5*MATCH(uvod_clanku) AGAINST ('$hledej' IN BOOLEAN MODE)+ MATCH(text_clanku) AGAINST ('$hledej' IN BOOLEAN MODE) 
        DESC
      ";
      
$vypis = "
        SELECT 
            clanky.jmeno as jmeno_clanku,
            clanky.pocet_precteni as pocet_precteni,  
            clanky.uvod as uvod_clanku, 
            clanky.id as id_clanku,    
            clanky.text as text_clanku,
            clanky.datum as datum_clanku, 
            clanky.link as link,
            clanky.klicova_slova as klicova_slova,
            uzivatele.nick as jmeno_autora,
            uzivatele.link as link_autora,
            kategorie.jmeno as jmeno_kategorie,
            kategorie.link as link_kategorie
    
            FROM clanky 
            LEFT JOIN uzivatele ON clanky.autor = uzivatele.id
            LEFT JOIN kategorie ON clanky.kategorie = kategorie.id
            
            WHERE dokoncen = 'ano'
       
         
        AND (MATCH(klicova_slova) AGAINST ('$hledej' IN BOOLEAN MODE) 
        OR MATCH(clanky.jmeno) AGAINST ('$hledej' IN BOOLEAN MODE) 
        OR MATCH(clanky.uvod) AGAINST ('$hledej' IN BOOLEAN MODE) 
        OR MATCH(clanky.text) AGAINST ('$hledej' IN BOOLEAN MODE)) 
        ORDER BY 20*MATCH(clanky.klicova_slova) AGAINST ('$hledej' IN BOOLEAN MODE) + 10*MATCH(clanky.jmeno) AGAINST ('$hledej' IN BOOLEAN MODE) 
        + 5*MATCH(clanky.uvod) AGAINST ('$hledej' IN BOOLEAN MODE)+ MATCH(clanky.text) AGAINST ('$hledej' IN BOOLEAN MODE) 
        DESC
      ";
$vypis = mysql_query($vypis) or die(mysql_error());
if (mysql_num_rows($vypis) == 0){
    ?><p>Omlouváme se, ale na váš předmět vyhledávání - <strong><?php echo $hledej; ?></strong> - nebyla nalezena žádná odpovídající stránka.</p><?php
    }
else{   
    ?><p>Nalezeno <?php echo mysql_num_rows($vypis); ?> záznamů</p><?php
    }
while($vysledek = mysql_fetch_array($vypis)){
    $v = mysql_fetch_array(mysql_query("select count(*) as pocet from komentare where clanek = '".$vysledek["id_clanku"]."'"));
    $vysledek["pocet_komentaru"] = $v["pocet"];
    ukaz_clanek($vysledek);
    }
    
?>
