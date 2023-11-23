<?php

require_once("./Keyboard.class.php");

$keyboard = new Keyboard();
$keyboard->setUseOnlyInCS(false);

$div_keyboard = $keyboard->draw();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html style='background-color:white;'>
  <head>
    <title>Identification</title>
    
    <link rel="stylesheet" href="agd_style.css" type="text/css" />
    
    <script src="./scriptaculous/prototype.js" type="text/javascript"></script>
    <script src="./scriptaculous/scriptaculous.js" type="text/javascript"></script>
  </head>
  
  <body>
  	<center>
  	
    <?php echo $div_keyboard; ?>
    
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    
    
    	<table cellpadding=0 cellspacing=0>
				<tr><td align='left'>Pseudonyme&nbsp;</td><td><input type='text' name='login' id='login' style='position:relative;' onclick="openKeyboard(this.id, 'none', null, 200);" /></td></tr>
				<tr><td align='left'>Mot de passe&nbsp;</td><td><input type='password' class='m_top_inter' name='password' id='password' style='position:relative;' onclick="openKeyboard(this.id, 'none', '', 200);" /></td></tr>
			</table>
		</center>
    
    <script type='text/javascript'> $('login').focus(); </script>
    
  </body>
  
<!-- WEBGENIUS HTTP 200 -->

</html>
