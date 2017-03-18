<html>
<head>
<meta http-equiv="content-type" content="application/xhtml+xml; charset=utf-8" /> 
<title>Administrace</title>
</head>
<body>
<?php

include("../pripojeni.php");

/*
menu
*/
?><div><a href='index.php?akce=kategorie'>Kategorie</a>  <a href='index.php?akce=otazky'>Otázky</a> <a href="index.php?akce=nastaveni">Nastavení</a> <a href="index.php?akce=chyby">Chyby</a></div><?php

if (IsSet($_GET["akce"])){
    include($_GET["akce"].".php");
    }

?>
<div id = 'footer'>
Jakub Vojáček & Filip Vondrášek &copy; 2010-2011
</div>

</body>
</html>
