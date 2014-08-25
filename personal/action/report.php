<?php

/*

  $Id: report.php,v 1.1 2006/04/12 15:06:31 sak Exp $

*/




unset($data_menu_rep);

$data_menu_rep[]= array (
    'title' => 'Cantidad de cargos por tipo de cargo', 
    'url'   => 'index.php?action=report_cargo_tipo'
);



include_once 'header.php';

echo '<br>';
echo 'Reportes:';
echo '<br>';
echo '<br>';
echo '<div id="menucontainer">';
echo '<ul id="navlist">';
foreach ($data_menu_rep as $menu)
{
    echo '<li><a href="' . $menu['url'] . '">' . $menu['title'] . '</a></li>';
}
echo '</ul>';
echo '</div>';




include_once 'footer.php';

