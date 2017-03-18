<form method = 'post' action = 'prihlas.php' >
<?php
@session_start();
if (IsSet($_SESSION["prihlaseni"]) and $_SESSION["prihlaseni"] != ""){
    echo "<blockquote>".$_SESSION["prihlaseni"]."</blockquote>";
    $_SESSION["prihlaseni"] = "";
    
    }
?>
<table>
<tr><td>Uživatelské jméno: </td><td><input type = 'text' class = 'komnick' name = 'uzivatelske_jmeno' /></td></tr>
<tr><td>Heslo: </td><td><input type = 'password' class = 'komnick' name = 'heslo' /></td></tr>
<tr><td colspan = '2'><input style = 'float: left;' type = 'submit' class = 'komsubmit' value='Přihlásit' /></td></tr>
</table>
</form>

<p>Pokud ještě nejste registrováný, můžete se <a href='akce/registrace'>registrovat</a></p>
