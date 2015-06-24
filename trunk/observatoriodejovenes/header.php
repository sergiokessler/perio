<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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

    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/offcanvas.css" rel="stylesheet">

    <link href="css/style.css" rel="stylesheet">
    <link href="css/print.css" media="print" rel="stylesheet">

    <link href="share/chartist.min.css" rel="stylesheet">
  </head>
  <body>


<?php
include 'navbar.php';

echo '<div class="container">';

include 'menu.php';

if (isset($params['msg'])) {
    echo '<div class="alert alert-success">';
    echo $params['msg'];
    echo '</div>';
}


