<?php
/* 
Jakub Vojáček
*/
?>
  
<script type="text/javascript">
function spocitat_zlomky(){
    a1 = document.getElementById("a1").value;
    a2 = document.getElementById("a2").value;
    b1 = document.getElementById("b1").value;
    b2 = document.getElementById("b2").value;
    zn = document.getElementById("zn").value;
    vysledek = document.getElementById("vysledek");
    chyba = 0;
    
    if (parseInt(a1) != a1 || parseInt(a2) != a2 || parseInt(b1) != b1 || parseInt(b2) != b2){
        vysledek.innerHTML = "Vložte pouze čísla";
        return   ;
        }     
    if (a2 == 0 || b2 == 0){
        vysledek.innerHTML = "Ve jmenovateli nesmí být nula";
        return;
        }
    if (zn == "+"){
        vystup = "\\frac{"+a1+"\\cdot"+b2+"+"+b1+"\\cdot"+a2+"}{"+a2+"\\cdot"+b2+"}";
        citatel = a1*b2+b1*a2;
        jmenovatel = a2*b2;
        }
    if (zn == "-"){
        vystup = "\\frac{"+a1+"\\cdot"+b2+"-"+b1+"\\cdot"+a2+"}{"+a2+"\\cdot"+b2+"}";
        citatel = a1*b2-b1*a2;
        jmenovatel = a2*b2; 
        }
    if (zn == "*"){
        vystup = "\\frac{"+a1+"\\cdot"+b1+"}{"+a2+"\\cdot"+b2+"}";
        citatel = a1*b1;
        jmenovatel = a2*b2;
        }
    if (zn == "/"){
        if (b1 == 0){
            vysledek.innerHTML = "Ve jmenovateli nesmí být nula";
            return;
            }
        vystup = "\\frac{"+a1+"}{"+a2+"}\\cdot\\frac{"+b2+"}{"+b1+"}";
        citatel = a1*b2;
        jmenovatel = a2*b1;
        }
    
    vystup = vystup + "=\\frac{"+citatel+"}{"+jmenovatel+"}";
    delitel = spocitej_delitel(citatel, jmenovatel)
    vystup = vystup + "=\\frac{"+(citatel/delitel)+"}{"+(jmenovatel/delitel)+"}";
    
    //alert("<img src='http://matweb.cz/cgi-bin/mimetex.cgi?"+vystup+"' />");
    vysledek.innerHTML = "<img src='http://maths.cz/cgi-bin/mimetex.cgi?"+vystup+"' />";
         
    }

function spocitej_delitel(cislo1,cislo2){
    while (cislo2 != 0){
        r=cislo1%cislo2;
        cislo1=cislo2;
        cislo2=r;
        }
    return cislo1;   
    }

</script>  
  
<div style = 'background: #a8d1ea; margin: 5px; border:1px solid#3979bb;padding: 8px;'>
<p style = 'font-weight: bold; font-style: italic; '>Sčítání, odčítání, násobení a dělení zlomků si můžete vyzkoušet na tomto nástroji.</p>
<table>
<tr><td style = 'border-bottom: 1px solid#000;'>
<input maxlength='4' type = 'text' name = 'a1' id = 'a1' style = 'width: 30px;' />
</td>
<td rowspan='2'>
<select name = 'zn' id = 'zn'>
<option value = '+'>+</option>
<option value = '-'>-</option>
<option value = '*'>*</option>
<option value = '/'>/</option>
</select>
</td>
<td style = 'border-bottom: 1px solid#000;'>
<input maxlength='4' type = 'text' name = 'b1' id = 'b1' style = 'width: 30px;' />
</td>
<td rowspan='2'>=</td>
<td rowspan='2'><span id = 'vysledek'></span></td>
</tr>

<tr>
<td>
<input maxlength='4' type = 'text' name = 'a2' id = 'a2' style = 'width: 30px;' />
</td><td>
<input maxlength='4' type = 'text' name = 'b2' id = 'b2' style = 'width: 30px;' />
</td>
</tr>
</table>
<input onclick = 'spocitat_zlomky()' type = 'button' value = 'Spočítat' />

</div>         