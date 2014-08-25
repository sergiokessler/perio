<?php

/*

$Id$

*/

require_once 'share/data_display.php';
require_once 'share/field_mapping.php';


//unset($params);
$params['table'] = 'tpm';
$params['sql_list'] = <<<END
    select
        *
    from
        tpm
END;
$params['sql_where'] = '';
$params['sql_order'] = ' order by anio ';
$params['sql_data'] = null;
$params['primary_key'] = 'id';
$params['link_view']['field_name'] = 'id';
$params['link_view']['action'] = 'tpm_select';


$field_meta['search']['anio'] = 'Año';
$field_meta['search']['tipo'] = 'Tipo';
$field_meta['search']['objetivo_general_diagnostico'] = 'Objetivo General Diagnostico';
$field_meta['search']['objetivo_general_planificacion'] = 'Objetivo General Planificación';
$field_meta['search']['coordinador'] = 'Coordinador';
$field_meta['search']['responsable'] = 'Responsable';




include_once 'header.php';

echo sak_search_form($params, $field_meta);

$insert_title = 'Agregar registro';
$insert_url = 'index.php?action=' . $params['table'] . '_insert';
echo "<a href=\"$insert_url\">$insert_title</a>";
echo '<br>';
echo '<br>';


$buscar = (bool) (isset($_REQUEST['btnSubmit'])) && ($_REQUEST['btnSubmit'] == 'Buscar');
if ($buscar)
{                            
    $params = sak_search_form_process($params);
    echo sak_display_list($params, $field_mapping['tpm']);
}


include_once 'footer.php';


