<?php

/*

$Id$

*/



$sql_record1 = <<<END
    select 
        *
    from 
        cargo
    where
        cargo_id = ?
END;



$params['table'] = 'cargo';


include_once 'header.php';
include_once 'share/data_display.php';

echo '<br>';

unset($params_upd);
$params_upd['record_id'] = $params['record_id'];
$params_upd = params_encode($params_upd); 

if ((isset($params['record_id'])))
{
    echo '<b>Datos del cargo</b> &nbsp; '; 

    $update_title = 'Editar este registro';
    $update_url = 'index.php?action=' . $params['table'] . '_update&params=' . $params_upd;
    echo "<a href=\"$update_url\">$update_title</a> &nbsp; ";

    $delete_title = 'Borrar este registro';
    $delete_url = 'index.php?action=' . $params['table'] . '_delete&params=' . $params_upd;
    echo "<a href=\"$delete_url\">$delete_title</a> &nbsp; ";

    echo '<br>';
    unset($params_rec);
    $params_rec['sql_record'] = $sql_record1;
    $params_rec['record_id'] = $params['record_id'];
    echo sak_display_record($params_rec);
}



/*
// sql detail
// 
echo '<br>Cargos de la persona<br>';

unset($params_list);
$params_list['sql_list'] = $sql_record2;
$params_list['sql_data'] = array($params['record_id']);
$params_list['primary_key'] = 'cargo_id';
echo sak_display_list($params_list);
 */


include_once 'footer.php';


