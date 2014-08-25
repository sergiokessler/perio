<?php

/*

  $Id: report.php,v 1.1 2006/04/12 15:06:31 sak Exp $

*/




unset($data_menu_rep);

$data_menu_rep[]= array (
    'title' => 'Ver inscriptos por materia', 
    'url'   => 'index.php?action=report_materia_inscriptos'
);
$data_menu_rep[]= array (
    'title' => 'Ver inscriptos por materia/comision', 
    'url'   => 'index.php?action=report_materia_comis_inscriptos'
);
$data_menu_rep[]= array (
    'title' => 'Resumen por fecha', 
    'url'   => 'index.php?action=report_by_date'
);
$data_menu_rep[]= array (
    'title' => 'Resumen por materia/comision', 
    'url'   => 'index.php?action=report_summary'
);



include_once 'header.php';

echo '<br>';
echo 'Reportes:';
echo '<div id="menucontainer">';
echo '<ul id="navlist">';
foreach ($data_menu_rep as $menu)
{
    echo '<li><a href="' . $menu['url'] . '">' . $menu['title'] . '</a></li>';
}
echo '</ul>';
echo '</div>';




include_once 'footer.php';


?>
