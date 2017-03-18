<?php

class Prihlasit extends Funkce{
    function show(){
        if ($this->je_prihlasen() != -1){
            ?><p>Už jste přihlášen. </p><?php
            return; 
            }
        ?>
        <form method = 'post' action='login.php'>
            <table>
                <tr><td>Nick: </td><td><input type="text" name="jmeno" /></td></tr>
                <tr><td>Heslo: </td><td><input type="password" name="heslo" /></td></tr>
                <tr><td colspan="2"><input type="submit" value="Přihlásit" /></td></tr>
            </table>
        </form>
        <p>Ještě nemáte vytvořený účet? <a href="index.php?akce=registrace">Registrujte se</a>. Registrací získáte možnost ukládání Vašeho skóre.</p>
        <?php
        }
    }
    
$prihlasit = new Prihlasit();
$prihlasit->show();
?>
