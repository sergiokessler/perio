<?php

/*

$Id$

*/

if (!isset($_SESSION['alumno_id']))
{
    include_once 'header.php';
    echo 'Sorry, no hay ningun alumno seleccionado, vaya al menú Alumnos.';
    include_once 'footer.php';
    exit();
}

require_once 'share/data_display.php';
require_once 'share/field_mapping.php';


//unset($params);
$params['table'] = 'inscripcion';
$params['sql_list'] = <<<END
    select
        *
    from
        inscripcion_v
END;
$params['sql_where'] = ' where alumno_id = ?';
$params['sql_order'] = ' order by fecha_hora ';
$params['sql_data'] = $_SESSION['alumno_id'];
$params['primary_key'] = 'id';
$params['link_view']['field_name'] = 'id';
$params['link_view']['action'] = $params['table'] . '_select';




include_once 'header.php';

$params_alumno['sql_list'] = 'select * from alumno';
$params_alumno['sql_where'] = ' where id = ?';
$params_alumno['sql_order'] = '';
$params_alumno['sql_data'] = $_SESSION['alumno_id'];

echo sak_display_list($params_alumno);
echo '<br>';


$insert_title = 'Agregar Inscripcion';
$insert_url = 'index.php?action=' . $params['table'] . '_insert';
echo "<a href=\"$insert_url\">$insert_title</a>";
echo '<br>';
echo '<br>';

echo sak_display_list($params);


include_once 'footer.php';


