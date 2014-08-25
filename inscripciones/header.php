<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
  <HEAD>
    <meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
    <meta HTTP-EQUIV="Pragma" content="no-cache">
	<meta HTTP-EQUIV="Expires" content="-1">
    <TITLE>
    <?php
        include_once 'config.php';
        echo $config['title'];
    ?>
    </TITLE>
    <link rel="StyleSheet" type="text/css" href="style.css" />
    <link rel="stylesheet" type="text/css" href="print.css" media="print"  /> 
  </HEAD>
  <BODY>
<div class="noprint">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr> 
    <td rowspan="2"><a href="index.php"><img src="logo.gif" border="0" alt=""></a></td>
      <td><?php include_once 'youarehere.php'; ?></td>
    </tr>
    <tr> 
      <td><?php include_once 'menu_1.php'; ?></td>
    </tr>
</table>
</div>
<?php

include_once 'msg.php';


?>
