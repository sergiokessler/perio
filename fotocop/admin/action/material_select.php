<?php


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
        material
    where
        material_id = ?
END;



$params['table'] = 'material';


include_once 'share/data_display.php';
include_once 'header.php';

$link_url = 'index.php?action=material_insert';
$link_label = 'Ingresar material';
echo "<a href=\"$link_url\">$link_label</a>"; 
echo ' | ';
$link_url = 'index.php?action=material_search';
$link_label = 'Búsqueda de material';
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
    
    $db = new PDO($config['db']['dsn']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $st = $db->prepare($sql_record1);
    $st->execute(array($record_id));

    $params_rec['data'] = $st->fetch(PDO::FETCH_ASSOC);

    $params_rec['link_view']['archivo']['label'] = 'Ver archivo PDF';
    $params_rec['link_view']['archivo']['href'] = 'files/' . $params_rec['data']['archivo'];
    
    echo sak_display_array_record($params_rec);


    $delete_title = 'Borrar este registro';
    $delete_url = 'index.php?action=' . $params['table'] . '_delete&params=' . $params_upd;
    echo "<a href=\"$delete_url\">$delete_title</a>";
    echo '<br>';
}


include_once 'footer.php';


