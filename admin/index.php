<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cz" lang="cz">                 
    <head>  
        <?php 
        @session_start();
        include("../funkce/pripojeni.php");
        include("../funkce/funkce.php");
        $je_prihlasen = je_prihlasen();
        ?> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Administrace</title>
        <link rel="stylesheet" href="styles.css" type="text/css" />  
        <script src="../js/vloz.js" type="text/javascript"></script>
        <script type = "text/javascript" src = "../js/zxml.src.js"></script>         
        <script type = "text/javascript" src = "../js/zxml.js"></script>          
    </head>
    <body>	
        <div id="wrapper">		
            <div id="sitename">			<h1>
                    <a href="index.php">Administrace</a></h1>		
            </div>		
            <div id="nav">			
                <ul class="clear">			 				
                    <?php include("menu.php");?>				 			
                </ul>		
            </div>		
   		
            <div id="body" class="clear">			
                <div id="content" class="column-left">			
<?php                
if ($je_prihlasen == 0){    
    include("login_form.php");    
    }   
elseif (skupina == 3){
    $_SESSION["zprava"] = array(0, "Nemáte právo pro vstup do administrace");
    include("login_form.php");
    }
else{
    ukaz_zpravu();
    $akce = "uvod";
    if (IsSet($_GET["akce"])){
        if (file_exists($_GET["akce"].".php")){
            $akce = $_GET["akce"];
            }
        }
    include($akce.".php");
    }                            
?>                		
                </div>		
            </div>		
            <div id="footer" class="clear">			
                <p class="left">&copy; 2007-2010 Matematika pro každého.
                </p>			
                <p class="right">Design by 
                    <a href="http://www.spyka.net">Free CSS Templates</a> and 
                    <a href="http://www.justfreetemplates.com">Free Web Templates</a>
                </p>		
            </div>	
        </div>
    </body>
</html>