<!DOCTYPE html>
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

    <link rel="stylesheet" type="text/css" href="css/print.css" media="print">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- <link rel="stylesheet" href="style-responsive.css" type="text/css"> -->

    <style type="text/css">
        body {
            padding-top: 60px;
            padding-bottom: 40px;
        }
        .sidebar-nav {
            padding: 9px 0;
        }
        .form-horizontal .control-label {
            width: 20%;
        }
        .form-horizontal .controls {
            margin-left: 22%;
        }

    </style>
  </head>
  <body>
    <div class="container">  
      <div class="row">
        <div class="span2">  
            <a href="index.php"><img src="img/logo.jpg" border="0" alt=""></a>
        </div>
        <div class="span8">  
            <h1>Agrupación Rodolfo Walsh 17 - Conducción Centro de Estudiantes</h1>
        </div>
      </div>

