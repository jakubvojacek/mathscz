<?php
setcookie("id", "", time()-3600, "/");
setcookie("heslo", "", time()-3600, "/");

Header("Location: index.php");


?>
