




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cz" lang="cz">                 
    <head>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-4559192509320286",
    enable_page_level_ads: true
  });
</script>
<script type="text/x-mathjax-config">
        MathJax.Hub.Config({
        extensions: ["[Contrib]/mhchem/mhchem.js"],
        tex2jax: {inlineMath: [["`","`"]]},
        showMathMenu: false,
    });
  </script>

  <script type="text/javascript" async
          src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-MML-AM_CHTML">
  </script>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta http-equiv="Content-language" content="cs" /> 
        <meta property="fb:admins" content="1440727879" />                 
        <meta http-equiv="content-type" content="application/xhtml+xml; charset=utf-8" />                            
        <link rel="schema.DC" href="http://purl.org/dc/elements/1.1/" />                          
        <meta name="DC.Title" content="Matematika pro každého" />                          
        <meta name="DC.Creator.personalName" content="Vojáček, Jakub" />                          
        <meta name="DC.Subject" scheme="PHNK" content="matematika" />                          
        <meta name="DC.Subject" scheme="MDT_MRF" content="51" />                          
        <meta name="DC.Subject" scheme="MDT_KON" content="51 - Matematika" />                          
        <meta name="DC.Subject" scheme="DDC_CON" content="510 - Mathematics" />                          
        <meta name="DC.Publisher" content="Jakub Vojáček" />                          
        <meta name="DC.Date" content="2008" />                          
        <meta name="DC.Type" scheme="DCMIType" content="Text" />                          
        <meta name="DC.Type" scheme="PHNK" content="www dokumenty" />                          
        <meta name="DC.Format" scheme="IMT" content="text/html" />                          
        <meta name="DC.Format.medium" content="computerFile" />                          
        <meta name="DC.Identifier" content="http://maths.cz/" />                          
        <meta name="DC.Identifier" scheme="URN" content="URN:NBN:cz-nk20091893" />                          
        <meta name="DC.Language" scheme="RFC3066" content="cze" />                          
        <meta name="DC.Rights" content="cop. maths.cz 2008-2016, content: Jakub Vojáček" />             
        <?php
        include("funkce/pripojeni.php");
        include("funkce/funkce.php");
        define("je_prihlasen", je_prihlasen());
        $title = titulek;
        $keywords = klicova_slova;
        $description = popis_webu;
        
        
        if (IsSet($_GET["akce"])){
            $akce = $_GET["akce"];
            if ($akce == "hlavolamy" or $akce=="hadanky"){
                $title = "Matematické hlavolamy a hádanky";
                $description="Různé hlavolamy, většinou s matematickým zaměřením.";
                if (IsSet($_GET["hlavolam"])){
                    $hlavolam = $_GET["hlavolam"];
                    $vypis=mysqli_query(DATABASE::getDb(), "select * from hlavolamy where link ='$hlavolam'");
                    if (mysqli_num_rows($vypis) != 0){
                        $vypis=mysqli_fetch_array($vypis);
                        $title="Hlavolam » ".$vypis["jmeno"];
                        $keywords="hlavolamy, hlavolam, hádanka, matematický hlavolam, ".$vypis["jmeno"].", ".$keywords;
                        }
                    }
                }
            elseif ($akce == "zkouseni"){
                $title="Matematické testy a cvičení";
                $description="Matematické testy a cvičení, vyzkoušejte si jak na tom jste!";
                if (IsSet($_GET["test"])){
                $id=$_GET["test"];
                $vypis=mysqli_query(DATABASE::getDb(), "select * from testy where link ='$id'");
                if (mysqli_num_rows($vypis) != 0){
                    $vypis=mysqli_fetch_array($vypis);
                    $title="Testy » ".$vypis["jmeno"];
                    }
                }
            }
            
            elseif ($akce == "kontakt"){
                $title="Matematika pro každého » Kontakt";
                $description="Kontakt na admina serveru Matematika pro každého";
                $keywords="jakub vojáček, ".$keywords;
                }
            
            elseif ($akce == "redakce"){
                $title="Matematika pro každého » Redakce";
                $description="Autoři matematického portálu Matematika pro každého";
                $keywords="autoři portálu, autoři,".$keywords;
                }
                
            elseif ($akce == "o-portalu"){$title="Matematika pro každého » O portálu";}
            elseif ($akce == "podporte-nas"){$title="Matematika pro každého » Podpořte nás";}
            elseif ($akce == "ukaz_clanek" and IsSet($_GET["id"])){            
                $vypis=mysqli_query(DATABASE::getDb(), "select jmeno, klicova_slova, uvod from clanky where link ='".$_GET["id"]."'");
                if (mysqli_num_rows($vypis) != 0){
                    $vypis=mysqli_fetch_array($vypis);
                    $title = $vypis["jmeno"];
                    $keywords = $vypis["klicova_slova"].", ".$keywords;
                    $description = $vypis["uvod"];
                    }
                }
            }
      
        elseif (IsSet($_GET["kategorie"])){
            $vypis=mysqli_query(DATABASE::getDb(), "select jmeno from kategorie where link ='".$_GET["kategorie"]."'");
            if (mysqli_num_rows($vypis) != 0){
                $vypis=mysqli_fetch_array($vypis);
                $title="Matematika pro každého » ".$vypis["jmeno"];
                $keywords=$vypis["jmeno"].", ".$keywords;            
                }
            }
        

        /*
        
      <base href="http://localhost/mathscz/" /> 
        */
        ?>
        <base href="https://maths.cz" />

        <title>                                      
            <?php echo $title;?>                            
        </title>                               
        <meta name="keywords" content="<?php echo $keywords;?>"/>                               
        <meta name="description" content="<?php echo $description;?>" />                               
        <meta name="DC.Description.abstract" content="<?php echo $description;?>" />                                                         
        <meta name="robots" content="all,follow" />       
<script type="text/javascript" src="js/jquery_004.js"></script>          
<script type="text/javascript" src="js/jquery.js"></script>          
<script src="js/vloz.js" type="text/javascript"></script>          
<script type="text/javascript" src="https://www.google.cz/coop/cse/brand?form=searchbox_004541203645099874140%3Afg23xotx3ds&lang=cs"></script>                                                                  
        <meta name="author" content="Jakub Vojáček" />                               
        <link href="favicon.ico" rel="shortcut icon" />                               
        <link rel="stylesheet" href="styles/body_style.css" type="text/css"/>                               
        <link rel="alternate" type="application/rss+xml" title="Matematika pro každého - Články - RSS 2.0" href="http://maths.cz/rss.php" />
          
          <script type="text/javascript" src="https://apis.google.com/js/plusone.js">
  {lang: 'cs'}
</script>

          
          <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-3274697-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
    </head>         
    <body>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/cs_CZ/sdk.js#xfbml=1&version=v2.8&appId=135212003208377";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

 
<div id="container">                     
    <div id="header">
    <a href="index.php"><img src="images/logo.gif" class="logo" alt="Matematika pro každého" /></a>                         
    <div id="navigation">                               
    <img src="images/nav_leftside.gif" class="navsideleft" alt="" />    
    <form action="index.php" method = "get">                              
        <span class="searchtext">vyhledávání:                                                                              
        <input type="hidden" name="akce" value = "vyhledavani" />                                
        <input placeholder="Napiště co hledáte" type="text" name="q" size="28" class="searchbox" />                                
        <input type="submit" value="Hledat" class="searchsubmit" />                          
                                                 
        </span>   
    </form>                           
    <span class="navbuttons">                        
    <a href="index.php">hlavní strana</a>&nbsp;&nbsp;&nbsp;                        
        <a href="akce/o-portalu">o portálu</a>&nbsp;&nbsp;&nbsp;                        
        <a href="/testy">testy</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="akce/hlavolamy">hlavolamy</a>&nbsp;&nbsp;&nbsp;&nbsp;          
   
    </span>                               
    <img src="images/nav_rightside.gif" class="navsideright" alt="" />                         
    
    </div>
    
</div>

<div id = "header2" style = "text-align: center; background-color: #a8d1ea; ">
<a href="index.php"><img src="images/logo.gif" alt="Matematika pro každého" /></a>
<br style = "clear: both;" />
<ul style = "width: 100%; display: block; margin: 0; padding: 0;">
        <li style = "width: 100%; display: block; border: 1px solid black; "><a style = "width: 100%; display: block;" href="index.php">hlavní strana</a></li>                        
        <li style = "width: 100%; display: block; border: 1px solid black; "><a style = "width: 100%; display: block;" href="/testy">testy</a></li>
        <li style = "width: 100%; display: block; border: 1px solid black; "><a style = "width: 100%; display: block;" href="akce/hlavolamy">hlavolamy</a></li>
        <li><form action="index.php" method = "get">                              
        <input type="hidden" name="akce" value = "vyhledavani" />                                
        <input style = "background: white;" placeholder="Napiště co hledáte" type="text" name="q"  />                                
        <input type="submit" value="Hledat" style = "background: grey;" />                          
                                                 
        </span>   
    </form></li>
</ul>
<br />
</div>
    
<?php 
if (IsSet($_GET["akce"]) or IsSet($_GET["stranka"])){
    $zobrazit_reklamu = 1;
    if (IsSet($_GET["akce"])){
        $stranka=$_GET["akce"].".php";
        }
    elseif(IsSet($_GET["stranka"])){
        $stranka=$_GET["stranka"].".php";
        }
    $stranka=str_replace("-","_",$stranka);
    $obr="navtype_mat_bez.gif";
    if ($stranka == "hlavolamy.php"){$stranka="hadanky.php";}
    if ($stranka == "hadanky.php"){$obr="navtype_hlavolamy.gif";}
    elseif ($stranka == "o_portalu.php"){$obr="navtype_about.gif";}
    elseif ($stranka == "zkouseni.php"){$obr="navtype_testy.gif";}
    ?>     
    <img class = "lista" src='images/<?php echo $obr;?>' alt='<?php echo $obr;?>' /><br />    
    <div id='page'> 
    <div id='zarovnani'>   
    <?php   
    if (file_exists($stranka)){
        include($stranka);
        }
    else{
        include("404.php");
        }
    ?>
    </div>
    </div>    
    <?php             
    }
else{
    $zobrazit_reklamu = 1;
    ?>    
    <img id = 'hlavni_header' src='images/navtype_main.gif' class='' alt='' /><br />    
    <div id='page'>    
    <div id='zarovnani'>    
    <?php
    $vypis = mysqli_query(DATABASE::getDb(), "select clanky.jmeno as jmeno_clanku,
                                 clanky.pocet_precteni as pocet_precteni, 
                                 clanky.uvod as uvod_clanku, 
                                 clanky.id as id_clanku,
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
                                 WHERE clanky.dokoncen = 'ano'
                                 group by clanky.datum 
                                 order by rand() desc limit 2
                                 ") or die(mysql_error());
    ukaz($vypis);
    ?>    
    <div style = 'padding-left: 20px;'>    
    <table width = '100%'>         
    <?php include("navigace.php"); ?>        
    <tr>
    <td colspan='2'>    
    <?php
    nahodna_otazka();
//ukaz_testy("select * from testy order by id desc limit 10");
    ?>    
    </td>
    </tr>      
    </table>    
    </div>
                    
                     
                                                  
    <?php
    $vypis = mysqli_query(DATABASE::getDb(), "select clanky.jmeno as jmeno_clanku, 
                                clanky.pocet_precteni as pocet_precteni,
                                 clanky.uvod as uvod_clanku, 
                                 clanky.id as id_clanku,
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
                                 WHERE clanky.dokoncen = 'ano'
                                 group by clanky.datum                                  
                                 order by rand() desc limit 2, 8
                                 ") or die(mysql_error());
    ukaz($vypis);
    ?>   
    <br />
                     
    </div>
    </div>    
    <?php
    }
    
if ($zobrazit_reklamu == 1){
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

    }
    ?>                  
    <img class = "lista" src="images/dotted_line.gif" class="dotline" alt="" /><br />                   
    <div id="footer">                         
    <span class="footext">          Kopírovat obsah stránek, čí s ním jinak manipulovat bez svolení jeho autora, je zakázáno.<br /> 
    </span>        <br />       ISSN: 1803-7615 &copy; maths.cz 2008-2017 &copy; content:                  
    <a href='http://maths.cz/redaktor/jakub-vojacek.html'>Jakub Vojáček</a>       <br />
    
    
    
    </div>             
    </div>      
  
    
    
    </body>
</html>
                                           
