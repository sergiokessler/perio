<?php

/*

$Id: premio.php,v 1.2 2007/10/17 18:03:18 develop Exp $

*/

require_once 'share/data_display.php';


//unset($params);
$params['table'] = 'urna_total';
$params['sql_list'] = <<<END
    select 
        mt.*,
        m.urna_nombre,
        l.lista_nombre
    from 
        urna_total mt,
        urna m,
        lista l
    where 
        mt.urna_id = m.urna_id 
        and 
        mt.lista_id = l.lista_id
END;
$params['sql_where'] = '';
$params['sql_order'] = '';
$params['sql_data'] = null;
$params['primary_key'] = $params['table'] . '_id';
$params['link_view']['field_name'] = $params['primary_key'];
$params['link_view']['action'] = $params['table'] . '_select';
$params['display_record_count'] = true;
//$params['enable_export'] = true;

$field_meta['search']['lista_nombre'] = 'Nombre de Lista';
$field_meta['search']['urna_nombre'] = 'Nombre de Urna';
$field_meta['select']['lista_nombre']['sql'] = 'select lista_id, lista_nombre from lista order by lista_nombre';
$field_meta['select']['urna_nombre']['sql'] = 'select urna_id, urna_nombre from urna order by urna_nombre';



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
    echo sak_display_list($params);
}


include_once 'footer.php';


