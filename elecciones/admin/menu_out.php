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

