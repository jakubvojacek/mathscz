<?php 
$zobrazit_reklamu = 1;


function vypis_test($test){
    $vypis = mysqli_fetch_array(mysqli_query(DATABASE::getDb(), "select * from testy where id = '$test'"));
    ?><p>Přejít na test <a href='testy/<?php echo $vypis["link"]; ?>'><?php echo $vypis["jmeno"]; ?></a><?php
    }

if (IsSet($_GET["id"])){
    $id=$_GET["id"];
    $vypis = mysqli_query(DATABASE::getDb(), "select clanky.jmeno as jmeno_clanku,
                                clanky.pocet_precteni as pocet_precteni, 
                                 clanky.uvod as uvod_clanku, 
                                 clanky.text as text_clanku, 
                                 clanky.id as id_clanku,
                                 clanky.testy as testy,
                                 clanky.kategorie as kategorie_clanku,
                                 clanky.klicova_slova as klicova_slova,
                                 clanky.datum as datum_clanku, 
                                 clanky.link as link,
                                 count(komentare.id) as pocet_komentaru,
                                 uzivatele.nick as jmeno_autora,
                                 uzivatele.link as link_autora,
                                 kategorie.jmeno as jmeno_kategorie,
                                 kategorie.link as link_kategorie
                                 from clanky 
                                 LEFT JOIN komentare ON clanky.id = komentare.clanek
                                 LEFT JOIN uzivatele ON clanky.autor = uzivatele.id
                                 LEFT JOIN kategorie ON clanky.kategorie = kategorie.id
                                 WHERE clanky.link = '$id'
                                 group by clanky.datum
                                 ") or die(mysql_error());

   
    
    if (mysqli_num_rows($vypis) == 0){
        include("404.php");
        return;
        }  
    
    $pole=mysqli_fetch_array($vypis);    
    $id_clanku = $pole["id_clanku"];  
        mysqli_query(DATABASE::getDb(), "update clanky set pocet_precteni = pocet_precteni + 1 where id = '$id_clanku'");
    ukaz_clanek($pole);
    ?>
    <div style = 'width: 100%; min-height: 100px; '>
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- responzive reklama -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-4559192509320286"
     data-ad-slot="9167077653"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>
    <?php
  
    $testy = $pole["testy"];
    if ($testy != ""){
        $testy = explode(",", $testy);
        if (count($testy) != 0){
            ?><fieldset style ='border: 2px solid#464646;'>
            <legend style = 'font-weight:bold;color:#464646;'>[ K tomuto článku jsou přiřazeny některé testy ]</legend><?php
            foreach ($testy as $cislo => $test){
                vypis_test($test);
                }
            ?></fieldset>
            <br /><?php
            }
        }
                        
                
    
    ?>
 
    


             <iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fmaths.cz<?php echo urlencode($_SERVER["REQUEST_URI"]);?>&amp;layout=standard&amp;show_faces=true&amp;width=450&amp;action=like&amp;colorscheme=light&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:80px; margin-top: 30px;" allowTransparency="true"></iframe>
             <div style = "text-align: left; ">
            <g:plusone size="medium"></g:plusone>
                                               </div>
            <div class='textcl'><?php echo Znacky($pole["text_clanku"]); ?></div>

    <br style="clear: both;" />
    
    <br style="clear: both;" />

    <?php
    nahodna_otazka();

    ?>

       <br /><br />

    <img src="images/spacer.gif" class="spacer" alt="" />
    <br /><br />  
    <span class='authorname'><a href='redaktor/<?php echo $pole["link_autora"]; ?>'><?php echo $pole["jmeno_autora"]; ?></a></span>
    <br />
    <br />
    </article>
    <?php
    ?>
    <br /><br />
    <span class="comment" id="komentare" name="komentare">Komentáře:</span><br /><br />
    <?php
    include("komentare.php");     
    }
else{
    include("404.php");
    }   
?>
