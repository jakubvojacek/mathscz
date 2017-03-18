<p>Jméno testu musí být unikátní (používáme seo url). </p>
<?php
include("kontrola.php");
echo '
<script type="text/javascript">
window.onload = function(){
    if (zXmlHttp.isSupported()){
        var jmeno = document.getElementById("jmeno_");
        jmeno.onchange = validateField;
        jmeno.onkeyup = validateField;
        }
    }
function validateField(oEvent) {
    var jmeno = document.getElementById("jmeno_");
    var typ = document.getElementById("typ_");
    var id = document.getElementById("id_");
    var oXmlHttp = zXmlHttp.createRequest();
    oXmlHttp.open("get", "kontrola-jmena.php?typ="+encodeURIComponent(typ.value)+"&jmeno=" + encodeURIComponent(jmeno.value)+"&id=" + encodeURIComponent(id.value), true);
    oXmlHttp.onreadystatechange = function (){
        if (oXmlHttp.readyState == 4){
            if (oXmlHttp.status == 200){
                var arrInfo = oXmlHttp.responseText.split("||");
                var zprava = document.getElementById("zprava");
                var submit = document.getElementById("submit_");
                zprava.innerHTML = arrInfo[1];
                if (!eval(arrInfo[0])){
                    zprava.style.color = "red";
                    submit.disabled = "disabled";
                    }
                else{
                    zprava.style.color = "green";
                    submit.disabled = "";
                    }
                } 
            
            }
        };
    oXmlHttp.send(null);
    };
</script>
';
echo "<form method = 'post' action = 'uloz-test.php'>";
echo "<input type = 'hidden' value = '-1' name = 'id_' id = 'id_' />";
echo "<input type = 'hidden' value = 'testy' name = 'typ_' id = 'typ_' />";

echo "Jméno: <input type = 'text' name = 'jmeno_' id = 'jmeno_' />";
echo "<br />";
echo "<span id = 'zprava'></span><br />";
echo "<input type = 'submit' value = 'Vytvořit test' id = 'submit_' disabled='disabled'/>";
echo "</form>";
?>

