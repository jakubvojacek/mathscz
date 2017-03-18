<?php
ukaz_zpravu();
echo $_SESSION["zprava"][1];
?>
<fieldset><legend>[ Pro vstup do administrace se musíte přihlásit ]</legend>
<form method = 'post' action = 'login.php'>
<table>
<tr><td width='100'>Uživatelské jméno: </td><td><input value=''type='text' name='uzivatelske_jmeno' /></td></tr>
<tr><td>Heslo: </td><td><input  value=''type='password' name='heslo' /></td></tr>
<tr><td colspan='2'><input type='submit' value='Přihlásit' /> </td></tr>
</table>
</form>
</fieldset>
