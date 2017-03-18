
function zobraz(obj){
    var obj = document.getElementById(obj);
    obj.style.display = "inline";
    }
function skryj(obj){
  
    var obj = document.getElementById(obj);
    obj.style.display = "none";
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
                if (oField.value == "ano"){
                    aParams.push(encodeNameAndValue(oField.name, oField.value));
                    }
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
