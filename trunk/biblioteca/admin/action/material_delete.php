<?php


if (isset($params['record_id'])) {
    $record_id = $params['record_id'];
} else {
    echo 'Debe seleccionar un registro. Presione el boton de Atras';
    exit();
}

$params['table'] = 'libros';
$params['primary_key'] = 'inventario';
$params['continue'] = 'material_last';


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



$btnSubmitValue = 'Confirmar borrado';


$db = new PDO($config['db']['dsn']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ( (isset($_POST['btnSubmit']))
     and
     ($_POST['btnSubmit'] == $btnSubmitValue) )
{

    if (!empty($_POST['filename'])) {
        $filename = $_POST['filename'];
        $file_to_delete = '../files/'.$filename;
        if (file_exists($file_to_delete)) {
            if (!unlink($file_to_delete))
                die('Error al intentar borrar el archivo ' . $file_to_delete);
        }
    }


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

unset($params_next);
$params_next['record_id'] = $record_id;
$params_next = params_encode($params_next);

echo '<br>';
echo '<br>';
echo '<form method="post">';
echo '<div class="form-actions">';
echo '<input type="hidden" name="params" value="'.$params_next.'">';
echo '<input type="hidden" name="filename" value="'.$params_rec['data']['archivo_digital'].'">';
echo '<input type="submit" name="btnSubmit" class="btn btn-danger" value="'.$btnSubmitValue.'">';
echo ' &nbsp; ';
echo '<a href="javascript:history.go(-1)">Cancelar y volver</a>';
echo '</div>';
echo '</form>';

include 'footer.php'; 


