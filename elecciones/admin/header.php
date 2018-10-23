<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1" >
    <meta HTTP-EQUIV="Pragma" content="no-cache">
	<meta HTTP-EQUIV="Expires" content="-1">
	<title>Elecciones FPyCS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="../assets/css/font-awesome.css" rel="stylesheet" media="screen">
    <link href="../assets/css/style.css" rel="stylesheet" media="screen">
	<link href='//fonts.googleapis.com/css?family=PT+Sans+Narrow' rel='stylesheet' type='text/css'>
  </head>
  <body class="admin">
<?php 

unset($data_menu);


echo '<div class="container">';
echo '<div class="container-fluid">';
echo '<img style="margin:0;padding:0" src="../assets/img/bgbody.png">';
echo '<div id="header">';
echo '<img src="../assets/img/logoperio.png" class="logoperio">';
echo '<h1 class="tituloh1">';
echo "&nbsp; Elecciones $anio<br>";
echo '</h1>';
echo '<img src="../assets/img/logosevit.png" class="logosevit">';
echo '<div class="clear"></div>';
echo '</div>';
echo '</div>';


$data_menu[]= array (
    'icon'  => '<i class="fa fa-home fa-2x"></i>',
    'title' => 'Inicio', 
    'url' => 'index.php'
);

echo '<div class="container">';
//echo '<nav class="navbar navbar-default" role="navigation">';
echo '<div class="container-fluid">';
//echo '<div id="navbar" class="navbar-collapse collapse">';
//echo '<ul id="navlist" class="nav nav-pills navbar-right">';
foreach ($data_menu as $menu)
{
    //echo '<li class="btn navbar-btn">';
    echo '<a href="' . $menu['url'] . '">'. $menu['icon'] . ' ' . $menu['title'] . '</a>';
    //echo '</li>';
}
//echo '</ul>';
//echo '</div>';
//echo '</nav>';

if (isset($params['msg'])) {
    echo '<div class="alert alert-success">';
    echo $params['msg'];
    echo '</div>';
}

