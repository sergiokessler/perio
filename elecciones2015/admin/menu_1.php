<?php

/*

  $Id: menu_main.php,v 1.1 2006/04/12 15:06:31 sak Exp $

  este script arma la barra de navegacion o menu

*/


unset($data_menu);

$data_menu[]= array (
                'title' => 'Inicio', 
                'url' => 'index.php'
               );
$data_menu[]= array (
                'title' => 'Salir', 
                'url' => 'index.php?action=logout'
               );


echo '<nav class="navbar navbar-default navbar-fixed-top" role="navigation">';
echo '<div class="container">';
echo '<ul id="navlist" class="nav nav-pills navbar-right">';
foreach ($data_menu as $menu)
{
    echo '<li class="btn navbar-btn"><a href="' . $menu['url'] . '">' . $menu['title'] . '</a></li>';
}
echo '</ul>';
echo '</div>';
echo '</nav>';


?>
