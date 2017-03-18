<?php   

Header('Content-type: text/html; charset=utf-8');
function close_tags($text) { 
    $pole = array();
    $patt_open    = "%((?<!</)(?<=<)[\s]*[^/!>\s]+(?=>|[\s]+[^>]*[^/]>)(?!/>))%"; 
    $patt_close    = "%((?<=</)([^>]+)(?=>))%"; 
    if (preg_match_all($patt_open,$text,$matches)) 
    { 
        $m_open = $matches[1]; 
        if(!empty($m_open)) 
        { 
            preg_match_all($patt_close,$text,$matches2); 
            $m_close = $matches2[1]; 
            if (count($m_open) > count($m_close)) 
            { 
                $m_open = array_reverse($m_open); 
                foreach ($m_close as $tag) $c_tags[$tag]++; 
                foreach ($m_open as $k => $tag)
                   {
                   if ($c_tags[$tag]--<=0) {
                        array_push($pole, $tag);
                        }
                   
                   } 
            } 
        } 
    } 
    return $pole; 
} 




$text = strtolower($text);
$pole = close_tags($text); 
$chyba = "";    


$zkontroluj = array("code", "pre", "a", "p", "ol", "li", "strong", "em", "u", "ul", "span", "h1", "h2", "h3");
foreach ($zkontroluj as $tag){   
    if (in_array($tag, $pole)){
        $chyba = $chyba."Některý tag <code>$tag</code> není uzavřen<br />";
        } 
    }

@session_start();
if ($chyba){
    $_SESSION["zprava"] = array(0, "V dokumentu, který byl právě uložen se vyskytly nějak chyby: <br />".$chyba."<br /><a href='$href'>Vrátit se zpět k editaci</a>");
    }
   

?>