<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1" >
    <meta HTTP-EQUIV="Pragma" content="no-cache">
	<meta HTTP-EQUIV="Expires" content="-1">
	<title>Elecciones FPyCS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="../css/style.css" rel="stylesheet" media="screen">
	<link href='//fonts.googleapis.com/css?family=PT+Sans+Narrow' rel='stylesheet' type='text/css'>
  </head>
  <body class="admin">
<?php 

unset($data_menu);

$data_menu[]= array (
                'title' => 'Inicio', 
                'url' => 'index.php'
               );
$data_menu[]= array (
                'title' => 'Salir', 
                'url' => 'index.php?action=logout'
               );

echo '<nav class="navbar navbar-default" role="navigation">';
echo '<div class="container">';
echo '<ul id="navlist" class="nav nav-pills navbar-right">';
foreach ($data_menu as $menu)
{
    echo '<li class="btn navbar-btn"><a href="' . $menu['url'] . '">' . $menu['title'] . '</a></li>';
}
echo '</ul>';
echo '</div>';
echo '</nav>';


echo '<div class="container">';
//echo '<center>';
echo '<div id="header">';
echo '<img src="../images/logoperio.png" class="logoperio">';
echo '<h1 class="tituloh1">';
echo "&nbsp; Elecciones $anio<br>";
echo '</h1>';
echo '<img src="../images/logosevit.png" class="logosevit">';
echo '<div class="clear"></div>';
echo '</div>';



if (isset($params['msg']))
    echo '<div style="text-align:right">' . $params['msg'] . '</div>'; 

