<?php

/*

$Id: report_hoy.php,v 1.1 2007/10/10 17:15:47 develop Exp $

*/

require_once 'share/data_display.php';


//unset($params);
$params['table'] = 'remito';
$params['sql_list'] = 'select * from ' . $params['table'] . ' where fecha = current_date';
$params['sql_where'] = '';
$params['sql_order'] = ' order by id ';
$params['sql_data'] = null;
$params['primary_key'] = 'id';
$params['display_record_count'] = true;
$params['enable_export'] = true;



include_once 'header.php';

echo sak_display_list($params);

include_once 'footer.php';


