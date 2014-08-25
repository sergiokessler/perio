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


echo '<div id="navcontainer">';
echo '<ul id="navlist">';
foreach ($data_menu as $menu)
{
    echo '<li><a href="' . $menu['url'] . '">' . $menu['title'] . '</a></li>';
}
echo '</ul>';
echo '</div>';


?>
