<?php
 no-repeat
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Ordinace praktického lékaře pro dospělé</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/JavaScript" src="curvycorners.js"></script>
  <script type="text/JavaScript" src="curvy.js"></script>
<style>
body{
    background:url(images/tall_top.gif) left top repeat-x #fff;
    margin: 0 auto;
    }
    
.round{
    -moz-border-radius: 20px;
    -webkit-border-radius: 20px;
    -khtml-border-radius: 20px;
    border-radius: 20px;
    }


#wrapper{
    width: 70%;

    margin: auto;
    }
#header{
    height: 230px; 
     
   } 
   
#menu{ 
   
    
    padding: 20px;
    background:url(images/menu.png)  repeat;    
    } 
#menu a{
    color:white;
    text-decoration: none;
    font-size: 1.2em;
    }
#menu a:hover{
    
    text-decoration: underline;
    }

h1{
    margin-bottom: 0;
    }  
h2{
    margin-top: 0;
    color: rgb(95,196,228)
    }  
h1, h2{
    } 

h3{
    color: rgb(32,180,241);
    margin-bottom: 0;
    margin-top: 0;
    }
 
#aktuality{ 
    
    margin: 15px;
    margin-top: 240px;
    padding: 15px;
    width: 200px;
    border: 1px solid#000;
    } 
     
#content{
    margin-top:20px;
    background: #F3F3F3;
    padding: 20px;
    width: 78%;
    
    }     
 
#left{
    float: left;
    background: url(star2.png) no-repeat;
   
    } 
     
</style>

</head>

<body>

<div id='wrapper'>
    <div id = 'left'>
        <div class = 'round' id = 'aktuality'>
        <h3>Aktuality:</h3>
        sfsdf<br />sdfsdf<br />sdf
        </div>
    </div>
    
    <div id = 'header'>
    
        <h1>Nadpis 1</h1>
        <h2>Nadpis 2</h2>
        
        
        <div class = 'round' id = 'menu'>
        <?php
        $menu = array(
            "" => "Hlavní strana",
            "ordinaci-hodiny" => "Ordinační hodiny",
            "aktualni-informace" => "Aktuální informace",
            "sluzby" => "Služby",
            "cenik-sluzen" => "Ceník služeb",
            "objednavani-pacientu" => "Objednávání pacientů",
            "kontakt" => "Kontakt",
            );
        foreach ($menu as $k => $v){
            ?><a href = 'index.php?akce=<?php echo $k; ?>'><?php echo $v; ?></a> &nbsp; <?php
            }
        ?>
        </div>
    
    
    
    
    <div class = 'round' id = 'content' >
    <p>Lorem ipsum dolor sit amet consectetuer Sed et pretium lacinia Phasellus. Integer et enim risus adipiscing tincidunt id nec convallis Fusce Cum. Massa laoreet sociis tempus semper porttitor natoque magnis amet sollicitudin Vestibulum. </p>
    <p>Id laoreet velit turpis a mauris tincidunt ornare lobortis urna natoque. Tristique Vestibulum turpis Duis molestie dolor orci Maecenas tortor pede sem. A at nunc Sed leo felis semper habitasse Nulla et nibh. Volutpat et iaculis pellentesque morbi et aliquam hendrerit Nulla eu ante. Consequat ipsum nibh wisi mus interdum Ut.</p>
    <p>Malesuada aliquam Nulla felis metus pede Vestibulum nulla accumsan neque dis. Tincidunt eget ut Phasellus mauris natoque sagittis iaculis Lorem at interdum. Hendrerit ut eget tortor augue id orci eget consequat nibh enim. Quis eros hendrerit nec Curabitur sapien.</p>
    <p>Sollicitudin ante enim sit Nunc nunc amet iaculis ut urna Morbi. Porta Vestibulum pede adipiscing sed ipsum id leo faucibus feugiat Curabitur. Augue Cras Maecenas lacus interdum nibh dui elit libero a turpis. Purus augue elit sapien id malesuada amet id vel Vestibulum natoque. Vitae quis ullamcorper ac dolor consequat Aenean amet in tincidunt Vestibulum. Consequat nulla.</p>
    <p>Ac porttitor egestas vitae id pretium nonummy Donec et tempus pellentesque. Risus Cras dapibus Curabitur turpis semper laoreet eros laoreet orci wisi. Urna Curabitur facilisis vel vitae consequat tincidunt nec a arcu ac. Integer non Praesent laoreet vel et Vivamus nulla nulla quis libero. Consectetuer sit in et Vestibulum porttitor ante Maecenas et sagittis vitae. Turpis faucibus ligula eleifend eget.</p>
    <p>Ac rutrum auctor Nullam justo sit metus nunc tellus Pellentesque Integer. Sit eu Nulla tellus mauris eu volutpat mi consectetuer lacinia risus. Consequat egestas ligula tempus eros porttitor felis pede et ac congue. Eget pretium sociis at Morbi ipsum arcu Aenean condimentum ipsum In. A quis dolor sagittis Ut sagittis Nulla pellentesque.</p>
    <p>Integer ac ante morbi gravida et Cum ipsum ornare amet ut. Nullam congue sagittis eleifend ac tincidunt ante nibh et sapien Phasellus. Volutpat enim gravida ac Donec dolor dapibus nibh magnis Fusce mauris. Vitae fames sagittis Integer tincidunt tempus nibh non Lorem nonummy semper. Orci consequat suscipit accumsan lorem urna tincidunt Morbi urna lobortis Ut. Sed urna sed ridiculus adipiscing Nam nunc congue elit.</p>
    <p>Ac nunc est nibh Donec libero diam id justo vitae Curabitur. Euismod mattis interdum Nam Nullam leo orci nisl amet quis quis. Aliquet et neque urna condimentum sagittis porta lacus pretium adipiscing eget. Senectus.</p>

    </div>
    </div>
    
</div>


</body>

</html>
