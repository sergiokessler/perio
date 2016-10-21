<?php

/*

  $Id: menu_operador.php,v 1.1 2006/04/12 15:06:31 sak Exp $

*/





// armamos menu principal
unset($data_menu_op);


$data_menu_op[] = array (
    'title' => 'Iniciar Sesion',
    'url' => 'index.php?action=login'
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

