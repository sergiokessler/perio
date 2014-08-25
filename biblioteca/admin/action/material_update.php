<?php


if (isset($params['record_id'])) {
    $record_id = $params['record_id'];
} else {
    echo 'Debe seleccionar un registro. Presione el boton de Atras';
    exit();
}

require_once 'HTML/QuickForm2.php'; 
require_once 'share/data_utils.php';


$params['table'] = 'libros';
$params['primary_key'] = 'inventario';
$params['action'] = 'material_update';
$params['continue'] = 'material_select';
// <query> 



include 'action/material_form.php';





if ( (isset($_REQUEST['btnSubmit']))
     and
     ($_REQUEST['btnSubmit'] == 'Guardar')
     and
     ($form->validate()) )
{

    $new_row = cleanup_new_row($_POST['new_row']);

    //$new_row['carga_fecha'] = date('Y-m-d H:i');

    //var_dump($_FILES);
    if (is_uploaded_file($_FILES['archivo_digital']['tmp_name']))
    {
        $filename = basename($_FILES['archivo_digital']['name']);
        $filename = preg_replace(array('/\s/', '/\.[\.]+/', '/[^\w_\.\-]/'), array('_', '.', ''), $filename);
        $new_row['archivo_digital'] = $filename;
        $filename = $config['app_root'] . "/../files/" . $filename;
        //$uploadfile = strtr($string, '................................', 'SZszYAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy');

        if (!move_uploaded_file($_FILES['archivo_digital']['tmp_name'], $filename)) {
            die($_FILES['archivo_digital']['error']);
        }
    }




    /***********************************************************
     * update the record
     **/
    $set = implode('=?, ', array_keys($new_row));
    $set .= '=?';

    $sql = "update $params[table] set $set where $params[primary_key] = ?";

    $sql_data = array_values($new_row);
    $sql_data[] = $record_id;

    $st = $db->prepare($sql);
    $st->execute($sql_data);
    /**
     ***********************************************************/
    
    
    $msg = "El registro a sido actualizado satisfactoriamente.";

                                  
    $params_cont = null;
    $params_cont['msg'] = $msg;
    $params_cont['record_id'] = $record_id;

    $continue = '?action=' . $params['continue'] . '&params=' . params_encode($params_cont);
}
else
{
    // <UI>
    include_once 'header.php';

    echo '<div class="page-header">';
    echo '  <img class="pull-right" src="img/logo_sumar_small.png">';
    echo '  <h1>Nota <small>Editando un registro</small></h1>';
    echo '</div>';

    // Output javascript libraries, needed by hierselect
    //echo $renderer->getJavascriptBuilder()->getLibraries(true, true);
    $form->render($renderer);
    echo $renderer;


    include_once 'footer.php'; 
}


