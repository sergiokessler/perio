<?php


if (isset($params['record_id'])) {
    $record_id = $params['record_id'];
} else {
    echo 'Debe seleccionar un registro. Presione el boton de Atras';
    exit();
} 


$sql_record1 = <<<END
    select 
        material_id,
        materia,
        titulo,
        autor,
        archivo
    from 
        material
    where
        material_id = ?
END;



$params['table'] = 'material';


include_once 'share/data_display.php';
include_once 'header.php';


echo '<div class="alert alert-info">';
echo '<h3><a href="#" onclick="history.go(-1);return false;">Volver a la Búsqueda de material</a></h3>';
echo '</div>';


echo '<div class="row">';

unset($params_upd);
$params_upd['record_id'] = $params['record_id'];
$params_upd = params_encode($params_upd); 
echo '</div>';


if ((isset($params['record_id'])))
{

    unset($params_rec);
    
    $db = new PDO($config['db']['dsn']); 
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $st = $db->prepare($sql_record1); 
    $st->execute(array($record_id));

    $params_rec['data'] = $st->fetch(PDO::FETCH_ASSOC);

    $params_rec['link_view']['archivo']['label'] = 'Ver archivo PDF';
    $params_rec['link_view']['archivo']['href'] = 'admin/files/' . $params_rec['data']['archivo']; 
    
    echo sak_display_array_record($params_rec);

}


include_once 'footer.php';


