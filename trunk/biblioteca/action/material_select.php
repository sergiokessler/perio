<?php


if (isset($params['record_id'])) {
    $record_id = $params['record_id'];
} else {
    echo 'Debe seleccionar un registro. Presione el boton de Atras';
    exit();
} 

$params['table'] = 'libros';
$params['primary_key'] = 'inventario';

$sql_record1 = <<<END
    select 
        *
    from 
        $params[table]
    where
        $params[primary_key] = ?
END;

$sql_data = array($record_id);



include_once 'share/data_display.php';
include_once 'header.php';

echo '<div class="page-header">';
echo '  <h1>Visualizando un registro</h1>';
echo '</div>';

unset($params_upd);
$params_upd['record_id'] = $record_id;
$params_upd = params_encode($params_upd); 

if ((isset($params['record_id'])))
{
    $db = new PDO($config['db']['dsn']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $st = $db->prepare($sql_record1);
    $st->execute($sql_data);

    $params_rec['data'] = $st->fetch(PDO::FETCH_ASSOC);
    $params_rec['link_view']['archivo_digital']['label'] = $params_rec['data']['archivo_digital'];
    $params_rec['link_view']['archivo_digital']['href'] = 'files/' . $params_rec['data']['archivo_digital'];

    echo sak_display_array_record($params_rec);
}


include_once 'footer.php';


