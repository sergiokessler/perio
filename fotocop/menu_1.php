<?php

/*

  $Id: menu_1.php,v 1.1 2007/10/10 17:15:47 develop Exp $

  este script arma la barra de navegacion o menu

*/


unset($menu_1);

$menu_1[]= array (
                'title' => 'Inicio', 
                'url' => 'index.php'
               );
/*
$menu_1[]= array (
                'title' => 'Institucional', 
                'url' => 'index.php'
               );
$menu_1[]= array (
                'title' => 'Preguntas Frecuentes', 
                'url' => 'index.php'
               );
$menu_1[]= array (
                'title' => 'Sitios de Interes', 
                'url' => 'index.php'
               );
*/

echo '<div id="navcontainer">';
echo '<ul id="navlist">';
foreach ($menu_1 as $menu)
{
    echo '<li><a href="' . $menu['url'] . '">' . $menu['title'] . '</a></li>';
}
echo '</ul>';
echo '</div>';


?>
