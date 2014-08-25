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
        nota
    where
        nota_id = ?
END;



$params['table'] = 'nota';


include_once 'share/data_display.php';
include_once 'header.php';

$link_url = 'index.php?action=nota_search';
$link_label = 'Volver a búsqueda de notas';
echo "<a href=\"$link_url\">$link_label</a>"; 

echo '<br>'; 
echo '<br>';

unset($params_upd);
$params_upd['record_id'] = $params['record_id'];
$params_upd = params_encode($params_upd); 

if ((isset($params['record_id'])))
{
    $update_title = 'Editar este registro';
    $update_url = 'index.php?action=' . $params['table'] . '_update&params=' . $params_upd;
    echo "<a href=\"$update_url\">$update_title</a>";
    echo '<br>';

    unset($params_rec);
    $params_rec['sql_record'] = $sql_record1;
    $params_rec['record_id'] = $params['record_id'];
    echo sak_display_record($params_rec);

    $delete_title = 'Borrar este registro';
    $delete_url = 'index.php?action=' . $params['table'] . '_delete&params=' . $params_upd;
    echo "<a href=\"$delete_url\">$delete_title</a>";
    echo '<br>';
}


include_once 'footer.php';


