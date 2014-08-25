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
    'url' => 'index.php?action=report&params=' . $params_r
);



unset($params_t);
$params_t['table'] = 'tesis';
$params_t['primary_key'] = 'tesis_id';
$params_t['op'] = 'select';
$params_t['sql_list'] = 'select tesis_id, titulo, programa, integrantes, director, expediente, estado, sede from tesis '; //order by sede, expediente';
$params_t['sql_record'] = 'select * from tesis where tesis_id = ?';
$params_t['conditions'] = 1;
$params_t['search']['titulo'] = 'Titulo';
$params_t['search']['director'] = 'Director';
$params_t['search']['integrantes'] = 'Integrantes';
$params_t['search']['programa'] = 'Programa';
$params_t['search']['expediente'] = 'Expediente';
$params_t['search']['estado'] = 'Estado';
$params_t['search']['sede'] = 'Sede';
$params_t['lookup']['director']['table'] = 'persona';
$params_t['lookup']['director']['field_key'] = 'apellido_nombre';
$params_t['lookup']['director']['field_list'] = 'apellido_nombre';
$params_t['lookup']['codirector']['table'] = 'persona';
$params_t['lookup']['codirector']['field_key'] = 'apellido_nombre';
$params_t['lookup']['codirector']['field_list'] = 'apellido_nombre';
$params_t['lookup']['asesor']['table'] = 'persona';
$params_t['lookup']['asesor']['field_key'] = 'apellido_nombre';
$params_t['lookup']['asesor']['field_list'] = 'apellido_nombre';
$params_t['lookup']['jurado_1']['table'] = 'persona';
$params_t['lookup']['jurado_1']['field_key'] = 'apellido_nombre';
$params_t['lookup']['jurado_1']['field_list'] = 'apellido_nombre';
$params_t['lookup']['jurado_2']['table'] = 'persona';
$params_t['lookup']['jurado_2']['field_key'] = 'apellido_nombre';
$params_t['lookup']['jurado_2']['field_list'] = 'apellido_nombre';
$params_t['lookup']['jurado_3']['table'] = 'persona';
$params_t['lookup']['jurado_3']['field_key'] = 'apellido_nombre';
$params_t['lookup']['jurado_3']['field_list'] = 'apellido_nombre';
$params_t['options']['estado']['1. En proceso'] = '1. En proceso';
$params_t['options']['estado']['2. Presentada'] = '2. Presentada';
$params_t['options']['estado']['3. Aprobada'] = '3. Aprobada';

//$params_t['fecha_inicio']['defaults'] = $date_defaults;

$params_t = params_encode($params_t);

$data_menu_op[] = array (
    'title' => 'Tesis',
    'url' => 'index.php?action=table&params=' . $params_t
);



unset($params_t);
$params_t['table'] = 'persona';
$params_t['primary_key'] = 'persona_id';
$params_t['op'] = 'select';
$params_t['sql_list'] = 'select * from persona order by apellido_nombre ';
$params_t['sql_record'] = 'select * from persona where persona_id = ?';
$params_t['conditions'] = 1;
$params_t['search']['apellido_nombre'] = 'Apellido Nombre';
$params_t['search']['documento_nro'] = 'Documento nro';
$params_t['search']['legajo'] = 'Legajo';

$params_t = params_encode($params_t);

$data_menu_op[] = array (
    'title' => 'Personas',
    'url' => 'index.php?action=table&params=' . $params_t
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
