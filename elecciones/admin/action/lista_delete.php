<?php

# vim: set fileencoding=ISO-8859-1 

if (isset($params['record_id'])) {
    $record_id = $params['record_id'];
} else {
    echo 'Debe seleccionar un registro. Presione el boton de Atras';
    exit();
}


$params['table'] = 'lista';
$params['primary_key'] = 'lista_id';
$params['action'] = 'lista_delete';
$params['continue'] = 'lista_list';

$sql_record1 = <<<END
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
$sql_data = array($record_id);

require_once 'lib/data_utils.php';
include_once 'lib/data_display.php';


// <query> 


$btnSubmitValue = 'Confirmar borrado';


$db = new PDO($db_dsn, $db_user, $db_pass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);

if ( (isset($_POST['btnSubmit']))
     and
     ($_POST['btnSubmit'] == $btnSubmitValue) )
{
    $sql = "delete from $params[table] where $params[primary_key] = ?";
    $sql_data = array($record_id);
    
    $st = $db->prepare($sql);
    $st->execute($sql_data);
    
    $msg = "La Lista <em>$record_id</em> ha sido eliminada satisfactoriamente.";
    
    $params_cont = null;
    $params_cont['msg'] = $msg;

    $continue = '?action=' . $params['continue'] . '&params=' . params_encode($params_cont);
    return;
}

// <UI>
include 'header.php';

echo '<div>';
echo '<h1><span class="glyphicon glyphicon-user"></span> Eliminando la Lista <i><span class="alert alert-warning">' . $record_id . '</i></span></h1>';
echo '<br>';
echo '<br>';
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

//echo '<br>';
echo '<form method="post">';
echo '<div class="form-actions">';
///echo '<span class="label label-warning">Cuidado! Al borrar un medio, har� que se borren todas las notas cargadas en ese medio</span>';
echo '<br>';
echo '<input type="hidden" name="params" value="'.$params_delete.'">';
echo '<button type="submit" name="btnSubmit" class="btn btn-danger" value="'.$btnSubmitValue.'">' . $btnSubmitValue . '</button>';
echo ' &nbsp; ';
echo '<a href="javascript:history.go(-1)">Cancelar y volver</a>';
echo '</div>';
echo '</form>';

include 'footer.php'; 


