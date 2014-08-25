<?php


if (isset($params['record_id'])) {
    $record_id = $params['record_id'];
} else {
    echo 'Debe seleccionar un registro. Presione el boton de Atras';
    exit();
} 

$params['table'] = 'medio';
$params['primary_key'] = 'medio_id';

$sql_record1 = <<<END
    select 
        medio_id,
        nombre,
        zona,
        provincia,
        relevancia,
        tipo,
        web,
        carga_fecha
    from 
        $params[table]
    where
        $params[primary_key] = ?
END;

$sql_data = array($record_id);



include_once 'share/data_display.php';
include_once 'header.php';

echo '<div class="page-header">';
echo '  <img class="pull-right" src="img/logo_sumar_small.png">';
echo '  <h1>Visualizando un registro</h1>';
echo '</div>';

unset($params_upd);
$params_upd['record_id'] = $record_id;
$params_upd = params_encode($params_upd); 

if ((isset($params['record_id'])))
{
    $update_url = '?action=' . $params['table'] . '_update&params=' . $params_upd;
    echo "<a href=\"$update_url\">Editar este registro</a>";
    echo '<br>';

    $db = new PDO($config['db']['dsn']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $st = $db->prepare($sql_record1);
    $st->execute($sql_data);

    $params_rec['data'] = $st->fetch(PDO::FETCH_ASSOC);
    echo sak_display_array_record($params_rec);

    $delete_url = '?action=' . $params['table'] . '_delete&params=' . $params_upd;
    echo "<a href=\"$delete_url\">Borrar este registro</a>";
    echo '<br>';
}


include_once 'footer.php';


