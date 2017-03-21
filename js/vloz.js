// JavaScript Document

function rozbal(idecko){

  el=document.getElementById(idecko).style;

  el.display=(el.display == 'block')?'none':'block';

}

function rozbal_reseni(idecko){

  $("#res-"+idecko).show("slow");

  $("#tlacitko-"+idecko).hide("slow");

  /*el = document.getElementById("res-"+idecko)

  el.style.display='block';

  el = document.getElementById("tlacitko-"+idecko)

  el.style.display='none';

  */

  posliPriklad(idecko);

}



function zmenobrazek(obrazekid, sekceid) {

  obrazek = document.getElementById(obrazekid);

  sekce = document.getElementById(sekceid);

  if(sekce.style.display == 'block') {

  	obrazek.src = 'images/minus.gif';

  }

  else {

	obrazek.src = 'images/plus.gif';

  }

}









function zobrazSkryj(idecko){

    el=document.getElementById(idecko).style;

    el.display=(el.display == 'block')?'none':'block';

}



function insertAtCursor(obj, val){

    var o = document.getElementById(obj);

    o.focus();

    if (document.selection){

        sel = document.selection.createRange();

        sel.text = val;

        }

    else if (o.selectionStart || o.selectionStart == '0'){

        var startPos = o.selectionStart;

        var endPos = o.selectionEnd;

        o.value = o.value.substring(0,startPos) + val + o.value.substring(endPos, o.value.length);

        }

    else{

        o.value += val;

        }

    }





function insertAroundSelection(obj,startVal,endVal) {

    var o = document.getElementById(obj);

    o.focus();

    if (document.selection) {

        sel = document.selection.createRange();

        var selText = sel.text;

        sel.text = startVal + selText + endVal;

        

        }

    else if (o.selectionStart || o.selectionStart == '0') {

        var startPos = o.selectionStart;

        var endPos = o.selectionEnd;

        o.value = o.value.substring(0,startPos) + startVal + o.value.substring(startPos,endPos) + endVal + o.value.substring(endPos,o.value.length);

        }

    else {

        o.value += startVal + endVal;

        }

    }




function validateField(oEvent) {

    var email = document.getElementById("email_");

    var jmeno = document.getElementById("jmeno_");

    var heslo = document.getElementById("heslo_");

    var heslo2 = document.getElementById("heslo_2");

    var oXmlHttp = zXmlHttp.createRequest();

    oXmlHttp.open("get", "kontrola-emailu.php?email="+encodeURIComponent(email.value)+"&jmeno=" + encodeURIComponent(jmeno.value)+"&heslo=" + encodeURIComponent(heslo.value)+"&heslo2=" + encodeURIComponent(heslo2.value), true);

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

function posliPriklad(id) {

    var oXmlHttp = zXmlHttp.createRequest();

    oXmlHttp.open("get", "pricti_priklad.php?id="+id, true);

    oXmlHttp.onreadystatechange = function (){

        if (oXmlHttp.readyState == 4){

            if (oXmlHttp.status == 200){

                1;

                } 

            

            }

        };

    oXmlHttp.send(null);

    };

    

function getRequestBody(oForm){

    var aParams = new Array();

    for (var i=0; i < oForm.elements.length; i++){

        var oField = oForm.elements[i];

        switch(oField.type){

            case "button":

            case "submit":

            case "reset":

                break

            case "radio":

                aParams.push(encodeNameAndValue(oField.name, oField.value));

                break;

            case "checkbox":            

            case "text":

            case "hidden":

            case "password":

                aParams.push(encodeNameAndValue(oField.name, oField.value));

                break;

            default:

                switch(oField.tagName.toLowerCase()){

                    case "select":

                        aParams.push(encodeNameAndValue(oField.name, oField.options[oField.selectedIndex].value));

                        break

                    default:

                        aParams.push(encodeNameAndValue(oField.name, oField.value));

                    }

            }

        }

    return aParams.join("&");

    }

function encodeNameAndValue(sName, sValue){

    var sParam = encodeURIComponent(sName);

    sParam += "=";

    sParam += encodeURIComponent(sValue);

    return sParam;

    }

function schovej(){

    var zprava = document.getElementById("zprava");

    zprava.style.display = "none";

    }

function uloz_clanek(){

    var zprava = document.getElementById("zprava");

    zprava.style.display = "";

    var form = document.forms[0];

    var sBody = getRequestBody(form);

    var oXHR = zXmlHttp.createRequest();

    oXHR.open("post", form.action, true);

    oXHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    oXHR.onreadystatechange = function (){

        if (oXHR.readyState == 4){

            if (oXHR.status == 200){

                zprava.style.color = "green";

                zprava.innerHTML = "Uložení proběhlo v pořádku";

                setTimeout(schovej, 2000);

                }

            else{

                zprava.style.color = "red";

                zprava.innerHTML = "Uložení nebylo dokončeno. Zkuste opakovat akci.";

                setTimeout(schovej, 2000);

                }

            }

            

        }

    oXHR.send(sBody);

    }