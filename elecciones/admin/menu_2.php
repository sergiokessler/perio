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


echo '<div class="container">';
echo '<div class="container-fluid">';
echo '<br>';
echo 'Menu Operador, seleccione una opcion:';
echo '<br>';
echo '<br>';

echo '<div align="center">';
echo '<div class="list-group" style="max-width: 720px;">';
foreach ($data_menu_op as $menu)
{
    echo '<a class="list-group-item" href="' . $menu['url'] . '">';
    echo '<h4 class="list-group-item-heading">' . $menu['title'] . '</h4>';
    echo '<p class="list-group-item-text">...</p>';
    echo '</a>';
}
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';

