<?php

/*

$Id: premio.php,v 1.2 2007/10/17 18:03:18 develop Exp $

*/

if($_SESSION['u'] != 'admin')
    return;


require_once 'share/data_display.php';


//unset($params);
$params['table'] = 'usuario_area';
$params['sql_list'] = 'select * from ' . $params['table'];
$params['sql_where'] = '';
$params['sql_order'] = '';
$params['sql_data'] = null;
$params['primary_key'] = $params['table'] . '_id';
$params['link_view']['field_name'] = $params['primary_key'];
$params['link_view']['action'] = $params['table'] . '_select';
$params['display_record_count'] = true;
//$params['enable_export'] = true;

$field_meta['search']['area'] = 'Area';
$field_meta['search']['usuario'] = 'Usuario';




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


