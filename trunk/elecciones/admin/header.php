<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1" >
    <meta HTTP-EQUIV="Pragma" content="no-cache">
	<meta HTTP-EQUIV="Expires" content="-1">
	<title>Elecciones FPyCS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="../css/elecciones.css" rel="stylesheet"  type="text/css">
	<link href='//fonts.googleapis.com/css?family=PT+Sans+Narrow' rel='stylesheet' type='text/css'>
  </head>
  <body class="admin">
<?php 

include_once 'menu_1.php';
echo '<div class="container">';
//echo '<center>';
echo '<div id="header">';
echo '<img src="../images/logoperio.png" class="logoperio">';
echo '<h1 class="tituloh1">';
echo "Elecciones $anio<br>";
echo '</h1>';
echo '<img src="../images/logosevit.png" class="logosevit">';
echo '<div class="clear"></div>';
echo '</div>';



if (isset($params['msg']))
    echo '<div style="text-align:right">' . $params['msg'] . '</div>'; 

?>
