<?php

if (empty($params['record_id'])) {
    echo 'Debe seleccionar un registro. Presione el boton de Atras';
    die();
} else {
    $record_id = $params['record_id'];
}  

require_once 'lib/data_display.php';


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




include 'header.php';

unset($params_cont);
$params_cont['record_id'] = $record_id;
$params_cont['continue'] = 'user';
$params_cont = params_encode($params_cont);

$action1 = '?action=lista_update&params=' . $params_cont;
$action2 = '?action=lista_delete&params=' . $params_cont; 

echo '<div>';
echo '<h1><span class="glyphicon glyphicon-user"></span> Datos de la Lista <i><span class="alert alert-warning">' . $record_id . '</i></span></h1>';
echo '<br>';
//echo '<a href="?action=user_change_pass" class="btn btn-default active" role="button">Agregar Usuario</a>'; 
echo '<a href="' . $action1 . '" class="btn btn-default active" role="button">Editar Lista</a> ';
echo '<a href="' . $action2 . '" class="btn btn-default active" role="button">Eliminar Lista</a> ';
echo '<br>';
echo '<br>';
echo '</div>';


$db = new PDO($db_dsn, $db_user, $db_pass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);

$st = $db->prepare($sql); 
$st->execute($sql_params);


unset($params);
$params['data'] = $st->fetch(PDO::FETCH_ASSOC);

if (empty($params['data'])) {
    echo ('No se encontraron datos');
} else {
    echo sak_display_array_record($params);
} 


include 'footer.php';


