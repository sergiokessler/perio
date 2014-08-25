<!DOCTYPE html>
<!-- # vim: set fileencoding=latin1 : -->
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

    <link rel="stylesheet" href="css/print.css" type="text/css" media="print">
    <link rel="stylesheet" href="css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="css/bootstrap-responsive.css" type="text/css">
    <link rel="stylesheet" href="css/style2.css" type="text/css">

    <style type="text/css">
        body {
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
    <script src="js/bootstrap.min.js"></script>

    <?php include 'header_top.php' ?>
    <?php include 'header_navbar.php' ?>



    <div class="container-fluid">
      <div class="row-fluid">

        <div class="span2">
            <?php include 'menu.php' ?>
        </div><!--/span-->

        <div class="span10">


<?php

if (isset($params['msg'])) {
    echo '<div class="alert alert-success">';
    echo $params['msg'];
    echo '</div>';
}


