<?php
/* 
Jakub Vojáček
*/

define(DB_HOST,'mysql1.tvujweb.cz');
define(DB_USERNAME,'c144maths1');
define(DB_PSW,'htnr28du');
define(DB_NAME,'c144maths1');
define(domain, '.maths.cz');


$connection = @mysql_connect(DB_HOST, DB_USERNAME, DB_PSW) or die ("Není možné připojit databádddzový server.");
$db = @mysql_select_db(DB_NAME, $connection) or die("Není možné vybrat databázi.");
mysqli_query(DATABASE::getDb(), "SET NAMES UTF8");
echo "pripojen";
?>
