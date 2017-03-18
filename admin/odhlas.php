<?php
include("../funkce/pripojeni.php");
include("../funkce/funkce.php");
$expire = time() + 1209600;
setcookie("id", "", time()-31536000, '/', '');
setcookie("heslo", "", time()-31536000, '/', '');
Header("Location: index.php");
?>
