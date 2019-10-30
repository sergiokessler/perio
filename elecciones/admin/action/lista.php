<?php

if (empty($params['record_id'])) {
    echo 'Debe seleccionar un registro. Presione el boton de Atras';
    die();
}

$record_id = $params['record_id'];

require_once 'lib/data_display.php';

$this_table = 'lista';
$this_table_label = 'Listas';
$this_primary_key = 'lista_id';
$this_icon = '<i class="fa fa-list"></i>';


$sql = <<<END
    select 
        orden,
        lista_nombre,
        lista_nombre_corto as nombre_corto,
        activa,
        en_total,
        en_porcentaje,
        participa_centro,
        participa_claustro,
        color,
        lista_id
    from 
        lista 
    where
        lista_id = ?
END;
$sql_params = array($record_id);


$html = '';


unset($params_cont);
$params_cont['record_id'] = $record_id;
$params_cont['continue'] = 'user';
$params_cont = params_encode($params_cont);

$action1 = '?action='. $this_table .'_update&params=' . $params_cont;
$action2 = '?action='. $this_table .'_delete&params=' . $params_cont; 



$db = new PDO($db_dsn, $db_user, $db_pass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);

$st = $db->prepare($sql); 
$st->execute($sql_params);


unset($params);
$params['data'] = $st->fetch(PDO::FETCH_ASSOC);

if (empty($params['data'])) {
    $table = 'No se encontraron datos';
} else {
    $table = sak_display_array_record($params);
} 

$html = <<<END
    <div>
        <h1>Datos de la Lista <i><span class="alert alert-warning">$record_id</i></span></h1>
        <br>
        <a href="$action1" class="btn btn-primary" role="button">Editar Lista</a> 
        <a href="$action2" class="btn btn-warning" role="button">Eliminar Lista</a> 
        <br>
        <br>
    </div>
    $table
END;


include 'header.php';

echo $html;

include 'footer.php';


