<form method = 'post' action = 'uloz-kategorii.php'>
<?php
$nadrazena = $_GET["nadrazena"];

?>
<input type = 'hidden' name = 'nadrazena' value = '<?php echo $nadrazena; ?>' />
<p>Jméno kategorie: <input type = 'text' name = 'jmeno' /></p>
<p><input type = 'submit' value = 'Uložit' /></p>

</form>
