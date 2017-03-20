

<?php



function adsense(){

    echo '';

    }



echo '

<script type="text/javascript">

function popisek(){ 

    var element = document.getElementById("res");

    var popisek = document.getElementById("popisek");

    if (element.style.display == "none"){

        element.style.display = "block";

        popisek.style.display = "none";

        }

    }

</script>

';

if (IsSet($_GET["hlavolam"])){

    $hlavolam=$_GET["hlavolam"];

    if (!is_numeric($hlavolam)){  

        $vypis=mysqli_query(DATABASE::getDb(), "select * from hlavolamy where link = '$hlavolam'") or die(mysql_error());

        }

    else{

        $vypis=mysqli_query(DATABASE::getDb(), "select * from hlavolamy where id = '$hlavolam'") or die(mysql_error());

        }

    $vypis=mysqli_fetch_array($vypis);

    $otazka=Znacky($vypis["text"]);

    $otazka=str_replace("\n","<br />",$otazka);

    $jm=$vypis["jmeno"];

    $r=Znacky($vypis["reseni"]);

    $r=str_replace("\n","<br />",$r);

    echo "<h2>$jm</h2>";



    echo "<p>$otazka</p>";

        

    //a8d1ea

    

    

 

    

    echo "<div style='text-align: center;margin-top:10px;'>";

    echo "<input value = 'Zobrazit řešení' type='button' id = 'popisek' onclick= 'popisek()'  style='cursor:pointer;' /><br /><br />";

    echo "</div>";

    echo "<div id='res' style='display: none;'>";



    echo "<div style='background: #a8d1ea; margin: 5px; border:1px solid#3979bb;padding: 8px;'>$r</div>";

       

    echo "</div>";

    



    }

  

else{

    

    $vypis=mysqli_query(DATABASE::getDb(), "select * from hlavolamy  where zobrazit = '1' and kat = '0' order by id DESC");

    echo "<br />";

    //echo "<img src='images/novy.png' alt='nový' /> <a onclick= \"zobrazSkryj('formular')\"  style='cursor:pointer;'>Přidat hlavolam</a><br />";

    echo "<a href='akce/matematicke-hlavolamy'>Čistě matematické hlavolamy</a><br />";

    

    echo "<div id = \"formular\" style='display:none;'>";

    echo "<form name=\"form\" method=\"post\" action=\"index.php?akce=uloz_hlavolam\">";

    

    echo "<span class='kompopisek'>Jméno: </span><br />";

    echo "<input class='komnick' type=\"text\" name=\"jmeno_hlavolamu\" size='40'/>";

    echo "<span class='kompopisek'>Otázka: </span><br /><textarea class='komtext' name='otazka'  cols='40'></textarea>";

    echo "<span class='kompopisek'>Řešení: </span><br /><textarea class='komtext' name=reseni' cols='40'></textarea>";

    echo "<span style='font-size:0.7em;'>Hlavolam bude zveřejněn až po kontrole některého člena redakce.</span>";

    echo "<input type='submit' value = 'Uložit' class='komsubmit'/>";

    

    echo "</form>";

    echo "</div>";

    echo "<br /><br />";

    echo "<hr />";

    $pocet = 0;

    while ($vysledek = mysqli_fetch_array($vypis)){

        if ($pocet == 3){

            adsense();

            }

        $jm=$vysledek["jmeno"];

        

        $i=$vysledek["id"];

        //index.php?akce=hlavolamy&amp;hlavolam=$i

        $seo=$vysledek["link"];

        $uryvek=substr($vysledek["text"],0,95)."...";

        echo "<h3 style='font-size:1.1em;margin-bottom:0;'><a href='hlavolamy/$seo'>$jm</a></h2>";

        echo "<p style='margin-top:0;font-style:italic;'>$uryvek</p>";

        $pocet = $pocet + 1;

        } 

    

    }

?>

