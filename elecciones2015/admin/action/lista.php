<?php

/*
 * by Sak@perio
 */
# vim: set fileencoding=ISO-8859-1

require_once 'lib/data_display.php';


//unset($params);
$params['table'] = 'lista';
$params['sql_list'] = 'select * from ' . $params['table'];
$params['sql_where'] = '';
$params['sql_order'] = ' order by orden';;
$params['sql_data'] = null;
$params['primary_key'] = $params['table'] . '_id';
$params['link_view']['field_name'] = $params['primary_key'];
$params['link_view']['action'] = $params['table'] . '_select';
$params['display_record_count'] = true;
//$params['enable_export'] = true;

$field_meta['search']['lista_nombre'] = 'Nombre de Lista';




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
}


$db = new PDO($db_dsn, $db_user, $db_pass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);

$sql = $params['sql_list'] . $params['sql_where'] . $params['sql_order'];
$sql_data = $params['sql_data'];

$st = $db->prepare($sql);
$st->execute($sql_data);
$params['data'] = $st->fetchAll(PDO::FETCH_ASSOC);

echo sak_display_array_list($params);


include_once 'footer.php';

