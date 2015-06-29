<?php

/*

  $Id: report.php,v 1.1 2006/04/12 15:06:31 sak Exp $

*/




unset($data_menu_rep);

$data_menu_rep[]= array (
    'title' => 'Cantidad de notas por medio', 
    'url'   => 'index.php?action=report_medio'
);
/*
$data_menu_rep[]= array (
    'title' => 'Cantidad de notas por año y por medio', 
    'url'   => 'index.php?action=report_nota_anio_medio'
);
$data_menu_rep[]= array (
    'title' => 'Cantidad de notas por año, por medio y sección', 
    'url'   => 'index.php?action=report_nota_anio_medio_seccion'
);

$data_menu_rep[]= array (
    'title' => 'Cantidad de notas por año, por medio, por sección y por contenido', 
    'url'   => 'index.php?action=report_nota_anio_medio_seccion_contenido'
);

$data_menu_rep[]= array (
    'title' => 'Cantidad de notas por año y por contenido', 
    'url'   => 'index.php?action=report_nota_anio_contenido'
);

$data_menu_rep[]= array (
    'title' => 'Cantidad de notas por año y por mes', 
    'url'   => 'index.php?action=report_nota_anio_mes'
);

$data_menu_rep[]= array (
    'title' => 'Cantidad de notas por año, por mes y por medio', 
    'url'   => 'index.php?action=report_nota_anio_mes_medio'
);

$data_menu_rep[]= array (
    'title' => 'Cantidad de notas por año, por mes, por medio y sección', 
    'url'   => 'index.php?action=report_nota_anio_mes_medio_seccion'
);

$data_menu_rep[]= array (
    'title' => 'Cantidad de notas por año, por mes, por medio, por sección y por contenido', 
    'url'   => 'index.php?action=report_nota_anio_mes_medio_seccion_contenido'
);

$data_menu_rep[]= array (
    'title' => 'Cantidad de notas por año, por mes y por contenido', 
    'url'   => 'index.php?action=report_nota_anio_mes_contenido'
);
*/

include_once 'header.php';

echo '<div class="page-header">';
echo '  <h1>Listado de reportes</h1>';
echo '</div>'; 

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


?>
