<?php

if (isset($params['record_id'])) {
    $record_id = $params['record_id'];
} else {
    echo 'Debe seleccionar un registro. Presione el boton de Atras';
    die();
}

require_once 'share/data_utils.php';


$params['table'] = 'material';
$params['primary_key'] = 'material_id';
$params['action'] = 'material_update';
$params['continue'] = 'material_select';


include 'action/material_form.php'; 


/*
 * Un usuario solo puede modificar lo cargado por el mismo
 * excepto saludymedios
 */
/*
if ( ($_SESSION['u'] != 'saludymedios') and ($_SESSION['u'] != $edit_row['carga_usuario']) ) {
    echo 'Ud. no puede editar este registro, fué cargado por otra persona. Presione el boton de Atras';
    exit();
}
*/



if ( (isset($_REQUEST['btnSubmit']))
     and
     ($_REQUEST['btnSubmit'] == 'Guardar')
     and
     ($form->validate()) )
{

    $new_row = cleanup_new_row($_POST['new_row']);

    $file =& $form->getElement('file');
    if ($file->isUploadedFile()) {
        $fileinfo = $file->getValue();
        $filename = md5($fileinfo['name']) . '.pdf';
        if ($file->moveUploadedFile($config['app_root'] . "/files" , $filename)) {
            $new_row['archivo'] = $filename;
        } else {
            die('Error subiendo archivo');
        }
    }


    $set = implode('=?, ', array_keys($new_row));
    $set .= '=?';

    $sql = "update $params[table] set $set where $params[primary_key] = ?";

    $sql_data = array_values($new_row);
    $sql_data[] = $record_id;

    $st = $db->prepare($sql);
    $st->execute($sql_data);
    
    $msg = "El registro ha sido actualizado satisfactoriamente.";

                                  
    unset($params_cont);
    $params_cont['msg'] = $msg;
    $params_cont['record_id'] = $edit_row[$params['primary_key']];
    $params_cont = params_encode($params_cont);

    $continue = 'action=' . $params['continue'] . '&params=' . $params_cont;
    return;
}


// <UI>
include_once 'header.php';
echo '<h2>Editanto el material</h2>';
echo $form;
include_once 'footer.php';


