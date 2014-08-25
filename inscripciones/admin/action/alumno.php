<?php

/*

$Id$

*/

require_once 'share/data_display.php';
require_once 'share/field_mapping.php';


//unset($params);
$params['table'] = 'alumno';
$params['sql_list'] = <<<END
    select
        *
    from
        alumno
END;
$params['sql_where'] = '';
$params['sql_order'] = ' order by nombre ';
$params['sql_data'] = null;
$params['primary_key'] = 'id';
$params['link_view']['field_name'] = 'id';
$params['link_view']['action'] = $params['table'] . '_select';


$field_meta['search']['legajo'] = 'Legajo';
$field_meta['search']['doc_nro'] = 'Nro Doc';
$field_meta['search']['nombre'] = 'Nombre';




include_once 'header.php';

echo sak_search_form($params, $field_meta);

$insert_title = 'Agregar un alumno nuevo';
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


