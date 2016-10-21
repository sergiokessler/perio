<?php

/*

  $Id: menu_operador.php,v 1.1 2006/04/12 15:06:31 sak Exp $

*/





// armamos menu principal
unset($data_menu_op);

/*
$params_r = null;
$params_r = params_encode($params_r); 

$data_menu_op[] = array (
    'title' => 'Reportes',
    'url' => 'index.php?action=report&amp;params=' . $params_r
);
*/


$data_menu_op[] = array (
    'title' => 'Listas',
    'url' => 'index.php?action=lista_list'
);

$data_menu_op[] = array (
    'title' => 'Urnas',
    'url' => 'index.php?action=urna_list'
);

$data_menu_op[] = array (
    'title' => 'Editar votos de una urna y lista',
    'url' => 'index.php?action=urna_total'
);

$data_menu_op[] = array (
    'title' => 'Carga de votos',
    'url' => 'index.php?action=carga'
);

$data_menu_op[] = array (
    'title' => 'Salir del sistema',
    'url' => 'index.php?action=logout'
);

echo '<div class="container">';
echo '<div class="container-fluid">';
echo '<br>';
echo 'Menu Operador, seleccione una opcion:';
echo '<br>';
echo '<div class="row">';
echo '<div class="col-sm-6 col-md-4 col-md-offset-4">'; 

echo '<ul class="nav nav-pills nav-stacked">';
foreach ($data_menu_op as $menu)
{
    echo '<li role="presentation">';
    echo '<a href="' . $menu['url'] . '">'. $menu['title'] .'</a>';
    echo '</li>';
}
echo '</ul>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';

