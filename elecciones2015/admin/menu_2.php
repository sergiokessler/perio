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
    'url' => 'index.php?action=lista'
);

$data_menu_op[] = array (
    'title' => 'Urnas',
    'url' => 'index.php?action=urna'
);

$data_menu_op[] = array (
    'title' => 'Editar votos de una urna y lista',
    'url' => 'index.php?action=urna_total'
);

$data_menu_op[] = array (
    'title' => 'Carga de votos',
    'url' => 'index.php?action=carga'
);


echo '<br>';
echo 'Menu Operador, seleccione una opcion:';
echo '<br>';
echo '<br>';

echo '<div id="menucontainer" class="panel panel-primary" style="max-width: 260px;">';
echo '<ul id="navlist" class="nav nav-pills nav-stacked" style="max-width: 260px;">';
foreach ($data_menu_op as $menu)
{
    echo '<li><a href="' . $menu['url'] . '">' . $menu['title'] . '</a></li>';
}
echo '</ul>';
echo '</div>';


?>
