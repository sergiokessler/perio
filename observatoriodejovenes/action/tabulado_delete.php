<?php


if (isset($params['record_id'])) {
    $record_id = $params['record_id'];
} else {
    echo 'Debe seleccionar un registro. Presione el boton de Atras';
    exit();
}

$params['table'] = 'tabulado';
$params['primary_key'] = 'tabulado_id';
$params['action'] = 'tabulado_delete';
$params['continue'] = 'tabulado_list';

$sql_record1 = <<<END
    select
        *
    from 
        $params[table]
    where
        $params[primary_key] = ?
END;
$sql_data = array($record_id);

require_once 'share/data_utils.php';
include_once 'share/data_display.php';


// <query> 


$btnSubmitValue = 'Confirmar borrado';


$db = new PDO($config['db']['dsn']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ( (isset($_POST['btnSubmit']))
     and
     ($_POST['btnSubmit'] == $btnSubmitValue) )
{
    $sql = "delete from $params[table] where $params[primary_key] = ?";
    $sql_data = array($record_id);
    
    $st = $db->prepare($sql);
    $st->execute($sql_data);
    
    $msg = 'El registro ha sido borrado satisfactoriamente.';
    
    $params_cont = null;
    $params_cont['msg'] = $msg;

    $continue = '?action=' . $params['continue'] . '&params=' . params_encode($params_cont);
    return;
}

// <UI>
include 'header.php';

echo '<div class="page-header">';
echo '  <h1>Borrando un registro</h1>';
echo '</div>';

// show the actual data and ask for confirmation
$st = $db->prepare($sql_record1); 
$st->execute(array($record_id));

$data = $st->fetch(PDO::FETCH_ASSOC);
$params_rec['data'] = $data;
echo sak_display_array_record($params_rec);

unset($params_delete);
$params_delete['record_id'] = $record_id;
$params_delete = params_encode($params_delete);

echo '<br>';
echo '<form method="post">';
echo '<div class="form-actions">';
///echo '<span class="label label-warning">Cuidado! Al borrar un medio, hará que se borren todas las notas cargadas en ese medio</span>';
echo '<br>';
echo '<br>';
echo '<input type="hidden" name="params" value="'.$params_delete.'">';
echo '<button type="submit" name="btnSubmit" class="btn btn-danger" value="'.$btnSubmitValue.'">' . $btnSubmitValue . '</button>';
echo ' &nbsp; ';
echo '<a href="javascript:history.go(-1)">Cancelar y volver</a>';
echo '</div>';
echo '</form>';

include 'footer.php'; 


