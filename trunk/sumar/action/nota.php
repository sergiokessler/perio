<?php


if (isset($params['record_id'])) {
    $record_id = $params['record_id'];
} else {
    echo 'Debe seleccionar un registro. Presione el boton de Atras';
    exit();
} 


$sql_record1 = <<<END
    select
        n.nota_id,
        m.nombre as medio_nombre,
        n.fecha,
        n.titulo,
        n.link,
        n.mencion_escala,
        n.valoracion,
        n.mencion_grupos,
        n.mencion_resultados_inscriptos,
        n.mencion_resultados_inversiones,
        n.mencion_resultados_transferencia,
        n.mencion_resultados_practicas,
        n.mencion_resultados_entrega,
        n.mencion_0800,
        n.mencion_cobertura_efectiva,
        n.mencion_card_cong,
        n.ppac,
        n.mencion_pueblos_orig,
        n.mencion_asignaciones,
        n.mencion_progresar,
        n.texto,
        n.carga_fecha
    from 
        nota n,
        medio m
    where
        n.medio_id = m.medio_id
        and
        nota_id = ?
END;

$sql_data = array($record_id);

$params['table'] = 'nota';


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
    $update_title = 'Editar este registro';
    $update_url = '?action=' . $params['table'] . '_update&params=' . $params_upd;
    echo "<a href=\"$update_url\">$update_title</a>";
    echo '<br>';

    $db = new PDO($config['db']['dsn']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $st = $db->prepare($sql_record1);
    $st->execute($sql_data);

    $params_rec['data'] = $st->fetch(PDO::FETCH_ASSOC);
    echo sak_display_array_record($params_rec);

    $delete_title = 'Borrar este registro';
    $delete_url = '?action=' . $params['table'] . '_delete&params=' . $params_upd;
    echo "<a href=\"$delete_url\">$delete_title</a>";
    echo '<br>';
}


include_once 'footer.php';


