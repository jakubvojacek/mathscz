<?php

echo '

<script type="text/javascript">

function popisek(id){

    var id = id; 

    var element = document.getElementById("res-"+id);

    var popisek = document.getElementById("popisek-"+id);

    if (element.style.display == "none"){

        element.style.display = "block";

        popisek.style.display = "none";

        }

    }

</script>

';



$vypis=mysqli_query(DATABASE::getDb(), "select * from hlavolamy where zobrazit = '1'and kat = '1' order by ID DESC") or die(mysql_error());

echo "<p>V následujících příkladech nahraďte stejná písmena stejnými číslicemi tak, aby daná matematická operace platila.</p>";

$pocet = 0;

while ($vysledek = mysqli_fetch_array($vypis)){

    if ($pocet == 1){

            echo '

<div style="text-align: center;"><script type="text/javascript"><!--

    google_ad_client = "pub-6682182903831588";

    /* dolni reklama - platí */

    google_ad_slot = "9480239568";

    google_ad_width = 728;

    google_ad_height = 90;

    //-->

    </script>

    <script type="text/javascript"

    src="http://pagead2.googlesyndication.com/pagead/show_ads.js">

    </script></div>

';

        }

    $jm = $vysledek["jmeno"];

    $otazka=$vysledek["text"];

    $r=Znacky($vysledek["reseni"]);

    echo "<h2 style= 'border-bottom: 1px solid#3979bb; width: 100%;'>$jm</h2>";

    echo "<pre>$otazka</pre>";

    $i = $vysledek["id"];

    echo "<div style='text-align: center;margin-top:3px;'>";

    echo "<input value = 'Zobrazit řešení' type='button' id = 'popisek-$i' onclick= 'popisek($i)'  style='cursor:pointer;' /><br /><br />";

    echo "</div>";

    echo "<div id='res-$i' style='display: none;'>";



    echo "<div style='background: #a8d1ea; margin: 5px; border:1px solid#3979bb;padding: 4px;'><pre>$r</pre></div>";

       

    echo "</div>";

    $pocet ++;

    }



?>

