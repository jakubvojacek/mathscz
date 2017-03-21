<?php
session_start();
include("./pripojeni.php");
include("./funkce.php");

?>

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
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="content-type" content="text/xhtml; charset=utf-8" />
  <meta name="description" content="Testy z matematiky, logiky, programování a práva." />
  <meta name="author" content="Jakub Vojáček" />
  <?php
  $kategorie = "";
  if (IsSet($_GET["kat"])){
      $kategorie = $_GET["kat"];
  }
  if (IsSet($_GET["kategorie"])){
      $kategorie = $_GET["kategorie"];
  }
  $title = "Online testy - Matematika, Logika, Programování, Právo";
  if ($kategorie != ""){
      $q = mysqli_query(DATABASE::getDb(), "select * from kategorie_otazky where id = '$kategorie'");
      $v = mysqli_fetch_array($q);
      $title = "Online testy - ".$v["jmeno"];
  }
  ?>
  <title><?php echo $title; ?></title>
  <link rel="stylesheet" href="style.css" type="text/css" media="print, projection, screen" />
  <script type="text/javascript" src="lib/jquery_004.js"></script>
<script type="text/javascript" src="lib/jquery.js"></script>
<script type="text/javascript" src="lib/js.js"></script>
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
<script>
  window.fbAsyncInit = function() {
    FB.init({appId: '135212003208377', status: true, cookie: true,
             xfbml: true});
  };
  (function() {
    var e = document.createElement('script'); e.async = true;
    e.src = document.location.protocol +
      '//connect.facebook.net/cs_CZ/all.js';
    document.getElementById('fb-root').appendChild(e);
  }());
</script>



<?php
class Index extends Funkce{
    function show_header(){
        ?>
         <div id="wrapper">
            <div id="sitename">
                <span style="float: right; ">
                        <fb:login-button show-faces="true" width="350" max-rows="0"></fb:login-button>
                    </span>
                <h1>
                    <a href="index.php">Online testy</a></h1>
                <h2>Matematika &amp; logika &amp; programování &amp; právo</h2>
            </div>
            <div id="nav">
                <ul class="clear">
                    <?php $this->show_menu(); ?>
                </ul>
            </div>

            <div id="body" class="clear">
                <div id="content" class="column-left">
                    
        <?php
        }
    function show_footer(){
        ?>
                </div>
            </div>
            <div id="footer" class="clear">
                <p class="left">&copy; 2007-<?php Date('Y'); ?> Matematika pro každého.
                                  <br />

                </p>
               
            </div>
        </div><?php
        }
    function show_menu(){
        $menu = array(
            array("index.php", "Hlavní stránka", 0),
            array("../index.php", "Matematika pro každého", 0),
            array("index.php?akce=statistiky", "Statistiky", 0),
            array("", "", 0),
            array("index.php?akce=vzkazy-pripominky", "Vzkazy a připomínky", 0)
        );
        if ($this->je_prihlasen == 1){
            $menu[3] = array("index.php?akce=pridat-otazku", "Přidat otázku", 0);
        }
        
        if (IsSet($_GET["akce"])){
            $akce = $_GET["akce"];
            if ($akce == "statistiky"){
                $menu[2][2] = 1;
            }
            elseif ($akce == "pridat-otazku"){
                $menu[3][2] = 1;
            }
            elseif ($akce == "vzkazy-pripominky"){
                $menu[4][2] = 1;
            }
        }
        else{
            $menu[0][2] = 1;
        }
        for ($i = 0; $i != count($menu); $i++){
            if ($menu[$i][0] == ""){
                continue;
            }
            ?><li <?php if ($menu[$i][2] == 1){echo "class = 'current'"; } ?> ><a href='<?php echo $menu[$i][0]; ?>'><span><?php echo $menu[$i][1]; ?></span></a></li><?php
        }


        }
    function show_info(){
      
        if (IsSet($_SESSION["info"]) && is_array($_SESSION["info"])){
            ?><blockquote><?php echo $_SESSION["info"][1]; ?></blockquote><?php
            $_SESSION["info"] = 0;
            }
        }
    function main_page(){
        ?>
        <p>Vyberte kategorii</p>
        <ul>
        <?php
        $q = mysqli_query(DATABASE::getDb(), "select * from kategorie_otazky where nadrazena = '-1' order by jmeno");
        while ($v = mysqli_fetch_array($q)){
            ?>
            <li><a href='index.php?kategorie=<?php echo $v["id"]; ?>'><?php echo $v["jmeno"]; ?></a></li>
            <?php
            }
           
        ?></ul><?php
        }

    function return_option_range($from, $to, $default){
        while ($from != $to){
            ?><option <?php if ($from == $default){echo "selected='selected'";} ?> value="<?php echo $from-1; ?>"><?php echo $from; ?></option><?php
            $from++;
            }
        }

    function show(){
        $this->id_uzivatele = $this->je_prihlasen();
        $this->je_prihlasen = 1;
        if ($this->id_uzivatele == -1){
            $this->je_prihlasen = 0;
            }

        $this->show_header();
        
        $this->show_info();
        if (IsSet($_GET["akce"])){
            $akce = $_GET["akce"];
            $pole = array("nahodny-test" => "nahodny-test.php",
                          "prihlasit" => "prihlasit.php",
                          "registrace" => "registrace.php",
                          "zobrazit-otazky" => "zobrazit-otazky.php",
                          "test" => "test.php",
                          "vysledky" => "vysledky.php",
                          "profil" => "profil.php",
                          "statistiky" => "statistiky.php",
                          "vzkazy-pripominky" => "vzkazy-pripominky.php",
                          "pridat-otazku" => "pridat-otazku.php");
            if (array_key_exists($akce, $pole)){
                include($pole[$akce]);
                }
            else{
                ?><p>Požadovaná stránka se na tomto serveru pravděpodobně nenachází, kontaktujte prosím administrátora. </p><?php
                }
            }
        elseif (IsSet($_GET["kategorie"])){
            $kategorie = $_GET["kategorie"];
            if (!is_numeric($kategorie)){
                return 0;
                }   
            $q = mysqli_query(DATABASE::getDb(), "select * from kategorie_otazky where id = '$kategorie'");
            $v = mysqli_fetch_array($q);
            $id_kategorie = $v["id"];
            
            ?>
            <div style="padding-bottom: 13px; "><?php $this->strom_kategorii($_GET["kategorie"]); ?></div>
            <h2><?php echo $v["jmeno"]; ?></h2><?php
            $q = mysqli_query(DATABASE::getDb(), "select * from kategorie_otazky where nadrazena = '$id_kategorie' order by jmeno");
            if (mysqli_num_rows($q) == 0){
                ?><p>Tato kategorie již nemá žádné podkategorie</p><?php
                }
            else{
                ?>
                <p>Možné podkategorie</p>
                <ul><?php
                while ($v = mysqli_fetch_array($q)){
                    ?><li><a href='index.php?kategorie=<?php echo $v["id"]; ?>'><?php echo $v["jmeno"]; ?></a></li><?php
                    }
                ?></ul><?php
                }
            //vyber zpusobu testovani
            $q = $this->make_cat_select($id_kategorie);
            $q = mysqli_query(DATABASE::getDb(), "select count(*) as pocet from otazky where kontrola = '1' and  $q") or die(mysql_error());
            $v = mysqli_fetch_array($q);
            $pocet_otazek = $v["pocet"];

            if ($this->je_prihlasen == 0){
                ?>
                <fieldset>
                    <legend>[ Přihlašte se ]</legend>
                    <p>Přihlášením získáte přístup ke statistice svých odpovědí. Zjistíte, ve kterých tématech máte největší mezery a která naopak už nemusíte procvičovat.</p>
                     <fb:login-button show-faces="true" width="350" max-rows="0"></fb:login-button>
                </fieldset>
                <?php
            }

            ?>
            <fieldset><legend>[ Rozsah testování ]</legend>
            <form method = 'get' action='index.php'>
            <input type = 'hidden' name = 'kat' value = '<?php echo $id_kategorie; ?>' />
            <input type = 'hidden' name = 'akce' value = 'test' />
            <p>Otázky:
                <select name="otazka">
                    <?php echo $this->return_option_range(1, $pocet_otazek+1, 0); ?>
                </select>
                <select name="do">
                    <?php echo $this->return_option_range(1, $pocet_otazek+1, $pocet_otazek); ?>
                </select>
            </p>
            <p>Zvolit způsob řazení:
            <input checked="checked" type="radio" name="razeni" value="0" /> Klasicky
            <input type="radio" name="razeni" value="1" /> Od nejtěžších
            <input type="radio" name="razeni" value="2" /> Od nejlehčích
            </p>
            <p><input type = 'submit' value = 'Začít' /></p>
            </form>            
            </fieldset>

            <fieldset><legend>[ Náhodné testování ]</legend>
                <form method="get" action="index.php">
                <input type = 'hidden' name = 'kat' value = '<?php echo $id_kategorie; ?>' />
                <input type = 'hidden' name = 'akce' value = 'nahodny-test' />
                <p><input type = 'submit' value = 'Spustit test' /></p>
                </form>
            </fieldset>

            <fieldset><legend>[ Zobrazit všechny otázky ]</legend>
                <form method="get" action="index.php">
                <input type = 'hidden' name = 'kat' value = '<?php echo $id_kategorie; ?>' />
                <input type = 'hidden' name = 'akce' value = 'zobrazit-otazky' />
                <p><input type = 'submit' value = 'Zobrazit' /></p>
                </form>
            </fieldset>
            <?php
            }
        else{
            $this->main_page();
            }
        $this->show_footer();
        }
    
    }

$index = new Index();
$navrat = $index->show();

?>
</body>

</html>
