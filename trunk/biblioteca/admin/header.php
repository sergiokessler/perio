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
    <link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="css/style2.css">
    <link rel="stylesheet" type="text/css" href="css/print.css" media="print">

    <style type="text/css">
        body {
            padding-top: 60px;
            padding-bottom: 40px;
        }
        .sidebar-nav {
            padding: 9px 0;
        }
        .control-label {
            width: 20%;
        }
        .controls {
            margin-left: 22%;
        }
    </style>

  </head>
  <body>

    <nav class="navbar navbar-fixed-top navbar-inverse noprint" role="navigation">
        <div class="navbar-header">
	    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	    </button>
	    <a class="navbar-brand" href="."><?php echo $config['realm']; ?></a>
	</div>
	<div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">
              <li <?php $o='home'; echo($action==$o ? 'class="active"' : '')?>><a href="."><i class="icon-home"></i> Inicio</a></li>
              <li <?php $o='about'; echo($action==$o ? 'class="active"' : '')?>><a href="?action=<?php echo $o?>">Acerca de</a></li>
            </ul>
<?php

if (!isset($_SESSION['logged_in'])) {
} else {
    echo '<p class="navbar-text pull-right"><i class="icon-user"></i> Logeado como <a href="#">'.$_SESSION['u'].'</a> &nbsp;|&nbsp; <a href="?action=logout">Salir</a></p>';
}
?>
	</div>
    </nav>



    <div class="container">

      <div class="row">

        <div class="col-md-3">

<?php
if (isset($_SESSION['logged_in'])) {
?>
          <div class="well noprint">
            <ul class="nav nav-pills nav-stacked" role="navigation">
              <li class="">Material bibliográfico</li>
              <li <?php $o='material_last'; echo($action==$o ? 'class="active"' : '')?>><a href="?action=<?php echo $o?>">Último material cargado</a></li>
              <li <?php $o='material_insert'; echo($action==$o ? 'class="active"' : '')?>><a href="?action=<?php echo $o?>">Cargar material</a></li>
              <li <?php $o='material_search'; echo($action==$o ? 'class="active"' : '')?>><a href="?action=<?php echo $o?>">Buscar material</a></li>
              <li class="navbar-header">Préstamos</li>
              <li <?php $o='prestamo_list'; echo($action==$o ? 'class="active"' : '')?>><a href="?action=<?php echo $o?>">Ver préstamos</a></li>
              <li <?php $o='prestamo_insert'; echo($action==$o ? 'class="active"' : '')?>><a href="?action=<?php echo $o?>">Cargar préstamo</a></li>
<!--              <li class="navbar-header">Reportes</li>
              <li <?php $o='report_totales'; echo($action==$o ? 'class="active"' : '')?>><a href="?action=<?php echo $o?>">Totales</a></li>
-->            </ul>
          </div><!--/.well -->
<?php
} else {
?>

          <div class="well noprint">
            <form class="form" method="post" role="form">
		<input type="hidden" name="action" value="login">
	      <div class="form-group">
		<label for="u">Usuario:</label>
    		<input name="u" class="form-control" type="text" id="u" placeholder="Usuario">
	      </div>
	      <div class="form-group">
    		<label for="p"">Clave:</label>
    		<input name="p" class="form-control" type="password" id="p" placeholder="Clave">
	      </div>
    	      <input class="btn btn-primary" type="submit" value="Iniciar Sesión">
	    </form>
	  </div>

<?php            
}
?>
        </div><!--/col-md-2-->


        <div class="col-md-9">

<?php

if (isset($params['msg'])) {
    echo '<div class="alert alert-success">';
    echo $params['msg'];
    echo '</div>';
}


