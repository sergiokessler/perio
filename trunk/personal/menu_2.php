<?php

/*

  $Id: menu_operador.php,v 1.1 2006/04/12 15:06:31 sak Exp $

*/





// armamos menu principal
unset($data_menu_op);

$params_r = null;
$params_r = params_encode($params_r); 

$data_menu_op[] = array (
    'title' => 'Reportes',
    'url' => 'index.php?action=report'
);

$data_menu_op[] = array (
    'title' => 'Personas',
    'url' => 'index.php?action=persona_search'
);

$data_menu_op[] = array (
    'title' => 'Cargos',
    'url' => 'index.php?action=cargo_search'
);



echo '<br>';
echo 'Seleccione una opcion:';
echo '<br>';
echo '<br>';

echo '<div id="menucontainer">';
echo '<ul id="navlist">';
foreach ($data_menu_op as $menu)
{
    echo '<li><a href="' . $menu['url'] . '">' . $menu['title'] . '</a></li>';
}
echo '</ul>';
echo '</div>';


?>
