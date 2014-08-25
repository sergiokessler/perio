<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta HTTP-EQUIV="Pragma" content="no-cache">
	<meta HTTP-EQUIV="Expires" content="-1">
	<title> 
    <?php
        echo $config['realm'];
        if(!empty($action)) {
            echo ' - ', $action;
        }
        if(!empty($header_title)) {
            echo ' - ', $header_title;
        } 
    ?>  
    </title> 

    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" >
    <link rel="stylesheet" type="text/css" href="css/style2.css">
    <link rel="stylesheet" type="text/css" href="css/print.css" media="print">

  </head>
  <body>
    <div class="container">  

      <div class="header">
        <ul class="nav nav-pills pull-right">
          <li><a href=".">Inicio</a></li>
          <li><a href="#">About</a></li>
        </ul>
        <h3 class="text-muted">CDM</h3>
      </div>
