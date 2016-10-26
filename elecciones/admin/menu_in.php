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
    'accesskey' => 'accesskey="l"',
    'icon'  => '<i class="fa fa-list"></i>&nbsp; &nbsp;',
    'title' => '<u>L</u>istas',
    'url' => 'index.php?action=lista_list'
);

$data_menu_op[] = array (
    'accesskey' => 'accesskey="u"',
    'icon'  => '<i class="fa fa-folder"></i>&nbsp; &nbsp;',
    'title' => '<u>U</u>rnas',
    'url' => 'index.php?action=urna_list'
);

$data_menu_op[] = array (
    'accesskey' => 'accesskey="v"',
    'icon'  => '<i class="fa fa-envelope-open"></i>&nbsp; &nbsp;',
    'title' => 'Editar <u>v</u>otos de una urna y lista',
    'url' => 'index.php?action=urna_total_list'
);

$data_menu_op[] = array (
    'accesskey' => 'accesskey="c"',
    'icon'  => '<i class="fa fa-envelope"></i>&nbsp; &nbsp;',
    'title' => '<u>C</u>arga de votos',
    'url' => 'index.php?action=carga'
);

$data_menu_op[] = array (
    'accesskey' => 'accesskey="s"',
    'icon'  => '<i class="fa fa-sign-out"></i>&nbsp; &nbsp;',
    'title' => '<u>S</u>alir del sistema',
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
    echo '<a href="' . $menu['url'] . '" '. $menu['accesskey'] .'>'. $menu['icon'] . $menu['title'] .'</a>';
    echo '</li>';
}
echo '</ul>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';

