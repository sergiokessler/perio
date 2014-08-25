<?php

/*

$Id$

*/

if (isset($params['record_id'])) {
    $record_id = $params['record_id'];
} else {
    echo 'Debe seleccionar un registro. Presione el boton de Atras';
    exit();
} 


$sql_record1 = <<<END
    select 
        *
    from 
        persona
    where
        doc_nro = ?
END;


$sql_record2 = <<<END
    select 
        *
    from 
        cargo
    where 
        doc_nro = ?
    order by 
        fecha_alta desc
END;

$params['table'] = 'persona';


include_once 'header.php';
include_once 'share/data_display.php';

echo '<br>';

unset($params_upd);
$params_upd['record_id'] = $record_id;
$params_upd = params_encode($params_upd); 

if ((isset($params['record_id'])))
{
    echo '<b>Datos de la persona</b> &nbsp; ';

    $update_title = 'Editar este registro';
    $update_url = 'index.php?action=' . $params['table'] . '_update&params=' . $params_upd;
    echo "<a href=\"$update_url\">$update_title</a> &nbsp; ";

    $delete_title = 'Borrar este registro';
    $delete_url = 'index.php?action=' . $params['table'] . '_delete&params=' . $params_upd;
    echo "<a href=\"$delete_url\">$delete_title</a> &nbsp; ";

    echo '<br>';
    echo '<br>';
    unset($params_display);
    $params_display['sql_record'] = $sql_record1;
    $params_display['record_id'] = $record_id;
    echo sak_display_record($params_display);
}



echo '<br>';
echo '<br>';
echo '<b>Cargos de la persona</b> &nbsp; ';

$params_cargo_insert['record_id'] = $record_id;
$params_cargo_insert = params_encode($params_cargo_insert);
$link_url = 'index.php?action=cargo_insert&params=' . $params_cargo_insert;
$link_label = 'Agregar un nuevo cargo';
echo "<a href=\"$link_url\">$link_label.</a> &nbsp; ";
echo '<br>'; 

unset($params_display);
$params_display['sql_full'] = $sql_record2;
$params_display['sql_data'] = array($record_id);
$params_display['primary_key'] = 'cargo_id';
$params_display['link_view']['field_name'] = 'cargo_id';
$params_display['link_view']['action'] = 'cargo';
echo sak_display_list($params_display);



include_once 'footer.php';


