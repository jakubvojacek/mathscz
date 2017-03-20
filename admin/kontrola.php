<?php
//Header('Content-type: text/html; charset=utf-8');
function je_prihlasen_kontrola_admin(){  
    if (IsSet($_COOKIE["id"]) and IsSet($_COOKIE["heslo"])){ 
        $id = $_COOKIE["id"];
        $heslo = $_COOKIE["heslo"];
        $vypis = mysqli_query(DATABASE::getDb(), "select * from uzivatele where id = '$id' and heslo = '$heslo'");
        if (mysqli_num_rows($vypis) == 0){
            echo "tady hje pes";
            return 0;
            }
        if ($vypis["typ"] == 2){
            echo "tady hje 3pes";
            return 0;
            }
        return 1;
        }
     echo "tady hje2 pes";
    return 0;//uzivatel neni prihlasen
    }
$_ = je_prihlasen_kontrola_admin();
if (!$_){
    die("Nemáte přístup!");
    }

?>
