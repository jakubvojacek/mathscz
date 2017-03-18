<?php
/* 
Jakub Vojáček
*/

function tex_vypis($a){
    $s = "";
    for($i = 0; $i != count($a[0])-1; $i++){
        $s .= "c";
        }
    $r = "http://matweb.cz/cgi-bin/mimetex.cgi?\left[\begin{array}{".$s."|c}";
    for($i=0;$i<count($a);$i++){
        
        for($j=0;$j<count($a[$i]);$j++){
            $r = $r.round($a[$i][$j], 2)."&";
            }
        $r = $r."\\\\";
    }  
    $r =  $r."\end{array}\\right]";
    return "<image src = '$r' alt = 'r' />";
    }
    
function trojuhelnikova ($a, $output){
    for($i=0;$i<count($a)-1;$i++):

# zapoznamkovana cast slouzi k vymene radku v pripade, kdyz je na diagonale nula

        if($a[$i][$i]==0):
            for($r=$i+1;$r<count($a);$r++)              # hledani radku, ktery nema v danem sloupci nulu, pokud ji ten na diagonale ma
                if($a[$r][$i]!=0) break;

            if($r==count($a)):                          # vynechanie cyklu, pokud je cely sloupec nulovy
                    continue;
            else:
                    for($x=0;$x<count($a);$x++):        # vymena radku
                        $b=$a[$i][$x];
                        $a[$i][$x]=$a[$r][$x];
                        $a[$r][$x]=$b;
                    endfor;
            endif;
        endif;
                                                     # tvorime dolni trojuhelnikovou
        for($r=$i+1;$r<count($a);$r++)
            for($s=count($a);$s>=0;$s--)                # puvodni tvar: for($s=count($a)-1;$s>=0;$s--)
                    $a[$r][$s]=$a[$r][$s]-($a[$r][$i]/$a[$i][$i])*$a[$i][$s];
            
        $output = $output."<br /><br />".tex_vypis($a);
    endfor;
    
    return array($a, $output);
}



function nacti($matice){
    $r = explode("\n", $matice);
    $a = array();
    
    for($i = 0; $i < count($r); $i++):
        $r[$i] = Trim($r[$i]);
        $p = explode(" ", $r[$i]);
        for($j = 0; $j<count($p); $j++){
            if (!is_numeric($p[$j])){
                return 0;
                }
            $a[$i][$j] = $p[$j];

            }
        if ($i != 0 && $sirka != $j){
            return 1;
            }
        $sirka = $j;
    endfor;
    return $a;
}


function gauss($a){
    $reseni = array();
    $pocet = 0;
    $pocet_promennych = count($a);
    $j = $pocet_promennych - 1;
    $i= $pocet_promennych-1 ;
    while ($i != -1)    {
        //echo $a[$i][$pocet_promennych]."x".$a[$i][$j]." I: ".$i."z".$j." $pocet <br />";

        if (round($a[$i][$pocet_promennych]*100000)/100000 == 0 && round($a[$i][$j]*100000)/100000 == 0){
            return "Existuje nekonecne mnoho reseni.";

        }
        else if($a[$i][$pocet_promennych] != 0 && round($a[$i][$j]*100000)/100000 == 0){
            return "Soustava nema reseni.";
        }
      
        $reseni[$pocet] = $a[$i][$pocet_promennych]/$a[$i][$j];

        for($u = $i-1; $u !=-1; $u--){
            $a[$u][$pocet_promennych] = $a[$u][$pocet_promennych]-$a[$u][$j]*$reseni[$pocet];

        }
        $j = $j-1;
        $pocet++ ;
        $i = $i - 1;
        //echo "konec: $i";
        }
    return $reseni;
    }


if (IsSet($_GET["matice"])){
    $matice = nacti($_GET["matice"]);
    if ($matice == 0){
        $output = "Vkládejte prosím pouze čísla." ;
        $output = array("output"=>$output);
        echo json_encode($output);
        return;
        }
    if ($matice == 1){
        $output = "Všechny řádky musí mít stejný počet členů." ;
        $output = array("output"=>$output);
        echo json_encode($output);
        return;
        }
    if (count($matice) != count($matice[0])-1){
        $output = "Nesedí počet proměnných (matice musí mít <code>x</code> řádku a <code>x+1</code> sloupců)" ;
        $output = array("output"=>$output);
        echo json_encode($output);
        return;
        }
    $output = "<br />".tex_vypis($matice);
    list($matice, $output) = trojuhelnikova($matice, $output);
    $reseni = gauss($matice);
    $output .= "<br />";
    if (!is_array($reseni)){
        $output = $output."<br />".$reseni;
        }
    else{
        $c = 1;
        foreach($reseni as $cislo){
            $output .= "<br />x$c = ".round($cislo, 2);
            $c = $c + 1;
            }
        //$output = $output."<br />".tex_vypis($reseni);
        }
    $output = array("output"=>$output);
    echo json_encode($output);
    }
else{
    
?>
<script type="text/javascript">
function spocitej_gauss(){
    var select = document.getElementById("matice");
    var vysledek = document.getElementById("vysledek-matice");
    var datastring = $("#matice-form").serialize();  
    //alert("sne");
    $.ajax({
        type: "GET",
        url: "skripty/gauss.php",
        data: datastring,
        dataType: "json",
        success: function(msg){
            //alert(msg.output);
            vysledek.innerHTML = msg.output;
            }
        });
    }
</script>


<div style = 'background: #a8d1ea; margin: 5px; border:1px solid#3979bb;padding: 8px;'>
<p style = 'font-style: italic; font-weight: bold; '>Nechte program spočítat soustavu gaussovou eliminiční metodou za Vás!</p>
<form id='matice-form'>
<textarea name = 'matice' rows="5" cols="20" id = 'matice'>2 1 2
1 1 4</textarea>

<p>Vložte matici soustavy. Prvky oddělujte mezerou, řádky novou řádkou. </p>
<input type = 'button' value = 'Spočítat' onclick = 'spocitej_gauss()' />

</form>
<div id = 'vysledek-matice'>

</div>
</div>
<?php
    }
?>