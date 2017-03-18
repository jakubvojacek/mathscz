<p>Máte nějakou připomínky, našli jste chybu? Nechte nám vzkaz</p>
<?php
if (IsSet($_GET["chyba"]) && $_GET["chyba"] == 1){
    ?><span style="font-weight: bold; color: red; ">Špatně jste opsali kód z obrázku. </span><?php
}
?>
<form method="post" action="uloz-pripominku.php">
    <table width="100%">
        <tr><td>Jméno: </td><td><input type="text" name="jmeno" /></td></tr>
        <tr><td>Předmět: </td><td><input type="text" name="predmet" /></td></tr>
        <tr><td width="50">Text: </td><td><textarea style="width: 100%;" cols="2" rows="5" name="text"></textarea></td></tr>
        <tr><td style = 'vertical-align: top;'><span style="font-size: 0.9em; ">Opište kód z obrázku: </span></td><td style = 'vertical-align: top;'>
    <?php
          require_once('recaptchalib.php');
          $publickey = "6LdTvrsSAAAAAOthHHR7_bPOlXNqgU1bHWrUydzz"; // you got this from the signup page
          echo recaptcha_get_html($publickey);
    ?>

    </td></tr>   
        <tr><td colspan="2"><input type="submit" value="Odeslat připomínku" /></td></tr>
    </table>
</form>
<br />
<br />
<?php
function PremenKomentar($text) {
    $text = Trim($text);
    $text = HTMLSpecialChars($text, ENT_QUOTES);
    $text = Str_Replace("\r\n"," <br /> ", $text);
    $text = Str_Replace("\n"," <br /> ", $text);
    return Trim($text);
    }

$q = mysql_query("select * from pripominky order by id desc");
while ($v = mysql_fetch_array($q)){
    ?>
    <div style="padding-bottom: 15px; border-bottom: 1px solid#000; padding-top: 5px;">
        <strong>Jméno: </strong><?php echo PremenKomentar($v["jmeno"]); ?>
        <br />
        <strong>Předmět: </strong><?php echo PremenKomentar($v["predmet"]); ?>
    <span style="float: right;"><?php echo Date("d. m. Y G:i", strtotime($v["cas"])); ?></span>
    <p><?php echo PremenKomentar($v["text"]); ?></p>
    </div>
    <?php

    }

?>
