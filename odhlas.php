<?php
include("../funkce/funkce.php");
$expire = time() + 1209600;
setcookie("id", "", time()-31536000, '/');
setcookie("heslo", "", time()-31536000, '/');
setcookie("forum_cookie_7afa5f", base64_encode('1|'.random_key(8, false, true).'|'.$expire.'|'.random_key(8, false, true)), $expire, '/', '.maths.cz');
Header("Location: index.php");
?>
