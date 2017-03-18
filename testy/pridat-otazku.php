<?php
class PridatOtazku extends Funkce{
    function show(){
        if ($this->je_prihlasen() == -1){
            ?>
            <p>Pro přidání otázky musíte být přihlášen. </p>
            <fb:login-button show-faces="true" width="350" max-rows="0"></fb:login-button>
            <?php
            return;
        }
        ?>
        <p>Chcete přispět ke kvalitě tohoto webu? Přidejte otázku a pomožte tím ostatním. </p>
        <form method="post" action="ulozit-otazku.php">
            <table>
            <tr><td width="50">Otázka:</td><td><textarea name ="otazka" cols="10" rows="3" style="width: 100%; "></textarea></td></tr>
            <?php
            $i = 1;
            while ($i != 5){
                ?>
                <tr><td></td><td><input name = 'check-<?php echo $i; ?>' type = 'checkbox' />
                <input type="text" name="odpoved-<?php echo $i; ?>" /></td></tr>
                <?php
                $i++;
                }
            ?>

            <tr><td colspan="2"><span style="font-size: 0.9em; ">Pro formátování používejte HTML. Matematické vzorce zadávejte LaTEXem mezi tag &lt;math&gt;&lt;/math&gt;.</span></td></tr>
            <tr><td>Kategorie: </td><td>
                    <?php
                    kategorie_select(-1);
                    ?>
                </td></tr>
            <tr><td colspan="2"><input type="submit" value="Uložit" /></td>
            </table>
        </form>
        <?php
    }
}

$pridat = new PridatOtazku();
$pridat->show();
