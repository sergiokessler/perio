<?php
// vim: set fileencoding=utf8 :


if (isset($params['record_id'])) {
    $record_id = $params['record_id'];
} else {
    echo 'Debe seleccionar un registro. Presione el boton de Atras';
    exit();
}

require_once 'HTML/QuickForm2.php'; 
require_once 'share/data_utils.php';


$params['table'] = 'nota';
$params['primary_key'] = 'nota_id';
$params['action'] = 'nota_update';
$params['continue'] = 'nota';
// <query> 



include 'action/nota_form.php';





if ( (isset($_REQUEST['btnSubmit']))
     and
     ($_REQUEST['btnSubmit'] == 'Guardar')
     and
     ($form->validate()) )
{

    $new_row = cleanup_new_row($_POST['new_row']);

    $new_row['carga_fecha'] = date('Y-m-d H:i');


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
    echo '  <h1>Nota <small>Editando un registro</small></h1>';
    echo '</div>';

    /*
     * Un usuario solo puede modificar lo cargado por el mismo
     * excepto saludymedios
     */

    if ( ($_SESSION['u'] != 'admin') and ($_SESSION['u'] != $edit_row['carga_usuario']) ) {
        echo 'Ud. no puede editar este registro, fué cargado por otra persona. Presione el boton de Atras';
        include_once 'footer.php';
        exit();
    }

    // Output javascript libraries, needed by hierselect
    //echo $renderer->getJavascriptBuilder()->getLibraries(true, true);
    $form->render($renderer);
    echo $renderer;


    include_once 'footer.php'; 
}


